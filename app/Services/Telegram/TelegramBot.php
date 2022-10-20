<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use App\Jobs\TelegramLoggerJob;

final class TelegramBot
{
    private const TELEGRAM_API = 'https://api.telegram.org/bot';

    private const PARSE_MODE_MARKDOWN = 'MarkdownV2';

    private const SEND_MESSAGE_METHOD = '/sendMessage';

    public static function sendMessage(string $token, int $channel, string $message): void
    {
        $options = [
            'chat_id' => $channel,
            'text' => $message,
            'parse_mode' => self::PARSE_MODE_MARKDOWN,
        ];
        $url = self::TELEGRAM_API . $token . self::SEND_MESSAGE_METHOD;

        dispatch(new TelegramLoggerJob($url, $options));
    }
}
