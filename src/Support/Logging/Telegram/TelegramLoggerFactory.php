<?php

declare(strict_types=1);

namespace Support\Logging\Telegram;

use Monolog\Logger;
use Services\Telegram\TelegramBot;

final class TelegramLoggerFactory
{
    public function __invoke(array $config): Logger
    {
        $handler = new TelegramLoggerHandler(
            $config['level'],
            new TelegramBot($config['token'], (int) $config['channel_id'])
        );

        return (new Logger('telegram'))->pushHandler($handler);
    }
}
