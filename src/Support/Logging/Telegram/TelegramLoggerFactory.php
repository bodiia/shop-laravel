<?php

declare(strict_types=1);

namespace Support\Logging\Telegram;

use Monolog\Logger;
use Services\Telegram\TelegramBot;

final class TelegramLoggerFactory
{
    public function __invoke(): Logger
    {
        $handler = new TelegramLoggerHandler(app(TelegramBot::class));

        return (new Logger('telegram'))->pushHandler($handler);
    }
}
