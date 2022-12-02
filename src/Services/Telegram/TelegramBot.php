<?php

declare(strict_types=1);

namespace Services\Telegram;

use Services\Telegram\Jobs\SendTelegramMessage;

final class TelegramBot
{
    private const TELEGRAM_API = 'https://api.telegram.org/bot';

    private const PARSE_MODE_MARKDOWN = 'MarkdownV2';

    private const SEND_MESSAGE_METHOD = '/sendMessage';

    public function __construct(
        private readonly string $token,
        private readonly int $channel
    ) {
    }

    public function sendMessage(string $message): void
    {
        $options = [
            'chat_id' => $this->channel,
            'text' => $message,
            'parse_mode' => self::PARSE_MODE_MARKDOWN,
        ];

        SendTelegramMessage::dispatch(
            self::TELEGRAM_API . $this->token . self::SEND_MESSAGE_METHOD,
            $options
        );
    }
}
