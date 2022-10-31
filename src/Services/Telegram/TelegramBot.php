<?php

declare(strict_types=1);

namespace Services\Telegram;

use App\Jobs\SendTelegramMessage;

final class TelegramBot
{
    private const TELEGRAM_API = 'https://api.telegram.org/bot';

    private const PARSE_MODE_MARKDOWN = 'MarkdownV2';

    private const SEND_MESSAGE_METHOD = '/sendMessage';

    public function __construct(
        private string $token,
        private int $channel
    ) {
    }

    public function sendMessage(string $message): void
    {
        $options = [
            'chat_id' => $this->channel,
            'text' => $message,
            'parse_mode' => self::PARSE_MODE_MARKDOWN,
        ];
        $url = self::TELEGRAM_API . $this->token . self::SEND_MESSAGE_METHOD;

        dispatch(new SendTelegramMessage($url, $options));
    }
}
