<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramWebhookCommand extends Command
{
    protected $signature = 'telegram:webhook {action? : set or remove}
                          {--url= : Custom webhook URL override}';

    protected $description = 'Set or remove the Telegram bot webhook';

    public function handle()
    {
        $action = $this->argument('action') ?? 'set';
        $bot = Telegram::bot('mybot');

        if ($action === 'remove') {
            $bot->removeWebhook();
            $this->info('Webhook removed successfully.');
            return;
        }

        $webhookUrl = $this->option('url') ?? url('/telegram/webhook');

        $bot->setWebhook([
            'url' => $webhookUrl,
        ]);

        $this->info("Webhook set to: {$webhookUrl}");
    }
}

