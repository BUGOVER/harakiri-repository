<?php
declare(strict_types=1);

namespace Harakiri\Repository\Providers;

use Harakiri\Repository\Generators\Commands\CriteriaCommand;
use Harakiri\Repository\Generators\Commands\RepositoryCommand;
use Harakiri\Repository\Generators\Commands\ServiceCommand;
use Harakiri\Repository\Generators\Commands\ValidatorCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package harakiri_repository_pattern\Repository\Providers
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../../config/repository.php' => config_path('repository.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../../config/repository.php', 'repository');

        $this->loadTranslationsFrom(__DIR__ . '/../../../resources/lang', 'repository');
    }


    /**
     * Register the services provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(RepositoryCommand::class);
        $this->commands(ValidatorCommand::class);
        $this->commands(ServiceCommand::class);
        $this->commands(CriteriaCommand::class);
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
