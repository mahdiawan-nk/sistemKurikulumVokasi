<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('activeClass', function ($routes) {
            return <<<PHP
            <?php
                echo request()->routeIs($routes)
                    ? 'text-[#efb034]'
                    : 'text-neutral-900 hover:text-neutral-900';
            ?>
            PHP;
        });

        Blade::directive('activeClassSide', function ($condition) {
            return <<<PHP
            <?php
                echo ($condition)
                    ? 'bg-black/10 dark:bg-white/10 dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white'
                    : 'bg-gray-100/10 dark:bg-black/10 dark:text-white dark:hover:bg-white/5 dark:hover:text-white';
            ?>
            PHP;
        });


    }
}
