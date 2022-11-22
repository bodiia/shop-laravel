<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Menu\Menu;
use App\Menu\MenuItem;
use Illuminate\View\View;

final class NavigationComposer
{
    public function compose(View $view): void
    {
        $view->with(
            'menu',
            Menu::make()
                ->add(MenuItem::make(route('home'), 'Главная'))
                ->add(MenuItem::make(route('catalog'), 'Каталог'))
        );
    }
}
