<?php

namespace Adiazm\Addresses;

use Illuminate\Support\ServiceProvider;

/**
 * Class AddressesServiceProvider
 */
class AddressesServiceProvider extends ServiceProvider
{
    protected array $migrations = [
        'CreateAddressesTable' => 'create_addresses_table',
        'CreateContactsTable' => 'create_contacts_table',
    ];

    public function boot()
    {
        $this->handleConfig();
        $this->handleMigrations();

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'addresses');
    }

    /** {@inheritdoc} */
    public function register()
    {
        //
    }

    /** {@inheritdoc} */
    public function provides(): array
    {
        return [];
    }

    private function handleConfig(): void
    {
        $configPath = __DIR__.'/../config/config.php';

        $this->publishes([$configPath => config_path('address-config.php')]);

        $this->mergeConfigFrom($configPath, 'address-config');
    }

    private function handleMigrations(): void
    {
        $count = 0;
        foreach ($this->migrations as $class => $file) {
            if (! class_exists($class)) {
                $timestamp = date('Y_m_d_Hi'.sprintf('%02d', $count), time());

                $this->publishes([
                    __DIR__.'/../database/migrations/'.$file.'.php.stub' => database_path('migrations/'.$timestamp.'_'.$file.'.php'),
                ], 'migrations');

                $count++;
            }
        }
    }
}
