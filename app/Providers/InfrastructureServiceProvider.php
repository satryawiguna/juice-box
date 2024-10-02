<?php

namespace App\Providers;

use App\Infrastructures\Email\Brevo;
use App\Infrastructures\Email\Contract\IEmailInfrastructure;
use App\Infrastructures\Email\ElasticEmail;
use App\Infrastructures\Email\Mailgun;
use App\Infrastructures\Storage\Contract\IStorageInfrastructure;
use App\Infrastructures\Storage\GDrive;
use App\Infrastructures\Storage\Space;
use Illuminate\Support\ServiceProvider;

class InfrastructureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IEmailInfrastructure::class, function ($app) {
            switch (config('mail.service')) {
                case 'mailgun':
                    return new Mailgun();
                case 'elastic':
                    return new ElasticEmail();
                default:
                    return new Brevo();
            }
        });

        $this->app->bind(IStorageInfrastructure::class, function ($app) {
            switch (config('filesystems.service')) {
                case 'gdrive':
                    return new GDrive();
                default:
                    return new Space();
            }
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
