<?php
namespace Harakiri\Repository\Events;

/**
 * Class RepositoryEntityDeleted
 * @package harakiri_repository_pattern\Repository\Events
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryEntityDeleted extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "deleted";
}
