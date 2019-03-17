<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Contracts\FeedContract',
            'App\Services\Providers\Pinboard'
        );

        $this->app->bind(
            'App\Contracts\NetworkContract',
            'App\Services\Networks\Twitter'
        );
    }
}
