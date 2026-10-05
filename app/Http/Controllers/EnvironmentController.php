<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class EnvironmentController extends Controller
{
    public function index(): View
    {
        $environment = [
            'app_name' => config('app.name'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug') ? 'Enabled' : 'Disabled',
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'timezone' => config('app.timezone'),
        ];

        return view('environment', compact('environment'));
    }
}