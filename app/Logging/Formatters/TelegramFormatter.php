<?php

declare(strict_types=1);

namespace App\Logging\Formatters;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;

final class TelegramFormatter
{
    public function __invoke(Logger $logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new LineFormatter(
                format: '`[%datetime%] %channel%.%level_name%: %message%`',
                dateFormat: 'Y-m-d - H:i:s',
            ));
        }
    }
}
