<?php

namespace GloCurrency\PolarisBank;

use Illuminate\Support\ServiceProvider;
use GloCurrency\PolarisBank\Console\FetchTransactionsUpdateCommand;
use GloCurrency\PolarisBank\Config;
use BrokeYourBike\PolarisBank\Interfaces\ConfigInterface;

class PolarisBankServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMigrations();
        $this->registerPublishing();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
        $this->bindConfig();
        $this->registerCommands();
    }

    /**
     * Setup the configuration for PolarisBank.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/polaris_bank.php', 'services.polaris_bank'
        );
    }

    /**
     * Bind the PolarisBank config interface to the PolarisBank config.
     *
     * @return void
     */
    protected function bindConfig()
    {
        $this->app->bind(ConfigInterface::class, Config::class);
    }

    /**
     * Register the package migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        if (PolarisBank::$runsMigrations && $this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/polaris_bank.php' => $this->app->configPath('polaris_bank.php'),
            ], 'polaris-bank-config');

            $this->publishes([
                __DIR__.'/../database/migrations' => $this->app->databasePath('migrations'),
            ], 'polaris-bank-migrations');
        }
    }

    /**
     * Register the package's commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchTransactionsUpdateCommand::class,
            ]);
        }
    }
}
