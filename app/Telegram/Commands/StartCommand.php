<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Start using the bot';

    public function handle()
    {
        $this->replyWithMessage([
            'text' => "Welcome to our Online Shop! 🛍️\n\n"
                . "You can use the following commands:\n"
                . "/status <order_id> - Check your order status\n"
                . "/help - Show available commands",
        ]);
    }
}
