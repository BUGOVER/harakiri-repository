<?php
namespace Harakiri\Repository\Events;

/**
 * Class RepositoryEntityUpdated
 * @package harakiri_repository_pattern\Repository\Events
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryEntityUpdated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "updated";
}
