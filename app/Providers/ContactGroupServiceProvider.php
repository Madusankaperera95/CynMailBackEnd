<?php

namespace App\Providers;

use App\Repositories\ContactGroupInterface;
use App\Repositories\ContactGroupRepository;
use Illuminate\Support\ServiceProvider;

class ContactGroupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ContactGroupInterface::class,ContactGroupRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
