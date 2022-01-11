<?php

namespace App\Providers;

use App\Models\YoutubeTimelines;
use App\Repositories\Eloquent\EloquentYoutubeTimelineRepository;
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
        $this->app->bind(EloquentYoutubeTimelineRepository::class, function($app) {
            return new EloquentYoutubeTimelineRepository($app->make(YoutubeTimelines::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
