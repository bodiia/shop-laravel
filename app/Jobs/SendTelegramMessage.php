<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Services\Telegram\Exceptions\TelegramBotException;
use Throwable;

class SendTelegramMessage implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private string $url,
        private array $options
    ) {
    }

    public function handle(): void
    {
        $response = Http::post($this->url, $this->options)->json();

        if (isset($response['error_code'])) {
            throw new Exception($response['description']);
        }
    }

    public function failed(Throwable $exception): void
    {
        report(new TelegramBotException($exception->getMessage()));
    }
}
