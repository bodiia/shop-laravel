<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Spatie\RouteAttributes\Attributes\Get;
use Support\ViewModels\HomepageViewModel;
use Illuminate\Contracts\Cache\Repository as Cache;

class HomeController extends Controller
{
    public function __construct(private readonly Cache $cache)
    {
    }

    #[Get(uri: '/', name: 'home', middleware: 'web')]
    public function __invoke(): View
    {
        return view('index', new HomepageViewModel($this->cache));
    }
}
