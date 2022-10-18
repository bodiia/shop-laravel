<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use App\Exceptions\TelegramBotException;
use Illuminate\Support\Facades\Http;

final class TelegramBot
{
    public const TELEGRAM_API = 'https://api.telegram.org/bot';

    private const SEND_MESSAGE_METHOD = '/sendMessage';

    public static function sendMessage(string $token, int $channel, string $message): bool
    {
        $credentials = [
            'chat_id' => $channel,
            'text' => $message,
        ];
        $url = self::TELEGRAM_API . $token . self::SEND_MESSAGE_METHOD;

        try {
            $response = Http::post($url, $credentials)->json();

            if (isset($response['error_code'])) {
                throw new TelegramBotException($response['description']);
            }
        } catch (\Exception) {
            return false;
        }

        return true;
    }
}
