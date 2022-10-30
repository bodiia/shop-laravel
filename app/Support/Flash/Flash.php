<?php

declare(strict_types=1);

namespace App\Support\Flash;

use Illuminate\Contracts\Session\Session;

final class Flash
{
    protected const MESSAGE_KEY = 'shop_flash_message';

    protected const MESSAGE_CLASS_KEY = 'shop_flash_class';

    public function __construct(protected Session $session)
    {
    }

    public function get(): ?FlashMessage
    {
        if ($message = $this->session->get(self::MESSAGE_KEY)) {
            return new FlashMessage($message, $this->session->get(self::MESSAGE_CLASS_KEY));
        }

        return null;
    }

    public function info(string $message): void
    {
        $this->flash($message, 'info');
    }

    public function alert(string $message): void
    {
        $this->flash($message, 'alert');
    }

    protected function flash(string $message, string $class): void
    {
        $this->session->flash(self::MESSAGE_KEY, $message);
        $this->session->flash(self::MESSAGE_CLASS_KEY, config("flash.$class"));
    }
}
