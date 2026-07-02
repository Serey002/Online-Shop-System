<?php

namespace App\Services;

use App\Models\Order;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramService
{
    protected string $chatId;

    public function __construct()
    {
        $this->chatId = env('TELEGRAM_GROUP_CHAT_ID', '');
    }

    public function sendMessage(string $message, string $parseMode = 'Markdown'): void
    {
        if (empty($this->chatId)) {
            return;
        }

        try {
            Telegram::sendMessage([
                'chat_id' => $this->chatId,
                'text' => $message,
                'parse_mode' => $parseMode,
            ]);
        } catch (\Exception $e) {
            logger()->error('Telegram notification failed: ' . $e->getMessage());
        }
    }

    public function notifyNewOrder(Order $order): void
    {
        $customerName = $order->user->name ?? 'Guest';
        $itemsSummary = $order->items_summary ?? 'N/A';
        $total = number_format($order->total_price ?? 0.00, 2);

        $message = "🆕 *New Order Received!*\n\n"
            . "🆔 Order ID: #{$order->id}\n"
            . "👤 Customer: {$customerName}\n"
            . "📦 Items: {$itemsSummary}\n"
            . "💰 Total: \${$total}\n"
            . "📅 Date: {$order->created_at->format('M d, Y h:i A')}\n"
            . "📍 Status: Preparing";

        $this->sendMessage($message);
    }

    public function notifyOrderStatusChange(Order $order): void
    {
        $customerName = $order->user->name ?? 'Guest';
        $statusLabel = ucfirst($order->status);
        $total = number_format($order->total_price ?? 0.00, 2);

        $message = "🔄 *Order Status Updated!*\n\n"
            . "🆔 Order ID: #{$order->id}\n"
            . "👤 Customer: {$customerName}\n"
            . "📊 New Status: *{$statusLabel}*\n"
            . "💰 Total: \${$total}\n"
            . "📅 Date: {$order->updated_at->format('M d, Y h:i A')}";

        $this->sendMessage($message);
    }
}
