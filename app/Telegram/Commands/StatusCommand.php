<?php

namespace App\Telegram\Commands;

use App\Models\Order;
use Telegram\Bot\Commands\Command;

class StatusCommand extends Command
{
    protected string $name = 'status';
    protected string $description = 'Check order status. Usage: /status <order_id>';

    public function handle()
    {
        $text = trim($this->getUpdate()->getMessage()->getText());
        $parts = explode(' ', $text, 2);

        if (!isset($parts[1]) || empty(trim($parts[1]))) {
            $this->replyWithMessage([
                'text' => 'Please provide an order ID. Usage: /status <order_id>',
            ]);
            return;
        }

        $orderId = trim($parts[1]);

        if (!is_numeric($orderId)) {
            $this->replyWithMessage([
                'text' => 'Invalid order ID. Please provide a numeric order ID.',
            ]);
            return;
        }

        $order = Order::with('user')->find($orderId);

        if (!$order) {
            $this->replyWithMessage([
                'text' => "Order #{$orderId} not found. Please check your order ID and try again.",
            ]);
            return;
        }

        $statusLabel = ucfirst($order->status);
        $customerName = $order->user->name ?? 'Guest';
        $total = number_format($order->total_price ?? 0.00, 2);

        $message = "📦 *Order #{$order->id}*\n\n"
            . "👤 Customer: {$customerName}\n"
            . "📊 Status: *{$statusLabel}*\n"
            . "💰 Total: \${$total}\n"
            . "📅 Date: {$order->created_at->format('M d, Y h:i A')}";

        if ($order->notes) {
            $message .= "\n📝 Notes: {$order->notes}";
        }

        $this->replyWithMessage([
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);
    }
}
