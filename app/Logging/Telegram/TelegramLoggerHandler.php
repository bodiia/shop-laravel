<?php

declare(strict_types=1);

namespace App\Logging\Telegram;

use App\Services\Telegram\TelegramBot;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

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
