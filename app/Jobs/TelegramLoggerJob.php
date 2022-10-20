<?php

namespace App\Jobs;

use App\Exceptions\TelegramBotException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class TelegramLoggerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $url,
        private array $options
    ) {
    }

    public function handle(): void
    {
        $response = Http::post($this->url, $this->options)->json();

        if (isset($response['error_code'])) {
            $this->fail(new TelegramBotException($response['description']));
        }
    }
}
