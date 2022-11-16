<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Support\ViewModels\HomepageViewModel;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('index', [
            'model' => new HomepageViewModel(),
        ]);
    }
}
