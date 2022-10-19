<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use App\Exceptions\TelegramBotException;
use Exception;
use Illuminate\Support\Facades\Http;

final class TelegramBot
{
    private const TELEGRAM_API = 'https://api.telegram.org/bot';

    private const PARSE_MODE_MARKDOWN = 'MarkdownV2';

    private const SEND_MESSAGE_METHOD = '/sendMessage';

    public static function sendMessage(string $token, int $channel, string $message): bool
    {
        $options = [
            'chat_id' => $channel,
            'text' => $message,
            'parse_mode' => self::PARSE_MODE_MARKDOWN,
        ];
        $url = self::TELEGRAM_API . $token . self::SEND_MESSAGE_METHOD;

        try {
            $response = Http::post($url, $options)->json();
        } catch (Exception) {
            return false;
        }

        if (isset($response['error_code'])) {
            throw new TelegramBotException($response['description']);
        }

        return true;
    }
}
