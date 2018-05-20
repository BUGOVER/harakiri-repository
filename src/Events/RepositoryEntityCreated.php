<?php

namespace Harakiri\Repository\Events;

/**
 * Class RepositoryEntityCreated
 * @package harakiri_repository_pattern\Repository\Events
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryEntityCreated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "created";
}
