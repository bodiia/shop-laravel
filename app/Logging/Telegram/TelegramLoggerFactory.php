<?php

declare(strict_types=1);

namespace App\Logging\Telegram;

use App\Services\Telegram\TelegramBot;
use Monolog\Logger;

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
