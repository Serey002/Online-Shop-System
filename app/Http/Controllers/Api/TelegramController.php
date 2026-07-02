<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webhook()
    {
        $update = Telegram::commandsHandler(true);

        return response()->json(['status' => 'ok'], 200);
    }
}
