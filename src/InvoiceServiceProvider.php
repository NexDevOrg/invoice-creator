<?php

namespace NexDev\InvoiceCreator;

use Illuminate\Support\ServiceProvider;
use NexDev\InvoiceCreator\Console\InstallCommand;
use NexDev\InvoiceCreator\Classes\OutgoingInvoice;

class InvoiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('outgoing-invoice', fn () => new OutgoingInvoice);

        $this->setupCommands();
        $this->setupPublishing();
        $this->setupMigrations();
        $this->setupViews();
    }

    protected function setupCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            InstallCommand::class,
        ]);
    }

    protected function setupPublishing(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/invoices'),
        ], 'invoices.views');

        $this->publishes([
            __DIR__ . '/../config/invoices.php' => config_path('invoices.php'),
        ], 'invoices.config');
    }

    protected function setupMigrations(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function setupViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'invoices');
    }
}
