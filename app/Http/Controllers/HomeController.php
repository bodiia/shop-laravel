<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Support\ViewModels\HomepageViewModel;
use Illuminate\Contracts\Cache\Repository as Cache;

class HomeController extends Controller
{
    public function __construct(private readonly Cache $cache)
    {
    }

    public function __invoke(): View
    {
        return view('index', new HomepageViewModel($this->cache));
    }
}
