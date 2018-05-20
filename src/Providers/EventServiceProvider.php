<?php
declare(strict_types=1);

namespace Harakiri\Repository\Providers;

use Harakiri\Repository\Events\RepositoryEntityCreated;
use Harakiri\Repository\Events\RepositoryEntityDeleted;
use Harakiri\Repository\Events\RepositoryEntityUpdated;
use Harakiri\Repository\Listeners\CleanCacheRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class EventServiceProvider
 * @package harakiri_repository_pattern\Repository\Providers
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class EventServiceProvider extends ServiceProvider
{

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RepositoryEntityCreated::class => [
            CleanCacheRepository::class
        ],
        RepositoryEntityUpdated::class => [
            CleanCacheRepository::class
        ],
        RepositoryEntityDeleted::class => [
            CleanCacheRepository::class
        ]
    ];

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function boot(): void
    {
        $events = app('events');

        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        //
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens(): array
    {
        return $this->listen;
    }
}
