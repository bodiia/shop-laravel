<?php

declare(strict_types=1);

namespace Support\Logging\Telegram;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Services\Telegram\TelegramBot;

final class TelegramLoggerHandler extends AbstractProcessingHandler
{
    private TelegramBot $telegramBot;

    public function __construct(string $level, TelegramBot $telegramBot)
    {
        parent::__construct(Logger::toMonologLevel($level));

        $this->telegramBot = $telegramBot;
    }

    protected function write(array $record): void
    {
        $this->telegramBot->sendMessage($record['formatted']);
    }
}
