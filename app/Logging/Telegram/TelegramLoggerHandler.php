<?php

declare(strict_types=1);

namespace App\Logging\Telegram;

use App\Services\Telegram\TelegramBot;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

final class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected string $token;
    protected int $channel;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);

        $this->token = $config['token'];
        $this->channel = (int) $config['channel_id'];
    }

    protected function write(array $record): void
    {
        TelegramBot::sendMessage(
            $this->token,
            $this->channel,
            $record['formatted']
        );
    }
}
