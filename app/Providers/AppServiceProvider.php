<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share warna acak di semua view
        View::share('randomColor', $this->generateRandomColor());
    }

    public function register()
    {
        //
    }

    private function generateRandomColor()
    {
        return '#' . strtoupper(dechex(rand(0, 255))) . strtoupper(dechex(rand(0, 255))) . strtoupper(dechex(rand(0, 255)));
    }
}
