<?php

namespace App\Providers;

use App\Repositories\ContactRepository;
use App\Repositories\ContactRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ContactServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ContactRepositoryInterface::class,ContactRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
