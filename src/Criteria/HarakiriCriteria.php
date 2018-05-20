<?php
declare(strict_types=1);

namespace Harakiri\Repository\Criteria;

use Harakiri\Repository\Contracts\CriteriaInterface;
use Harakiri\Repository\Contracts\RepositoryInterface;

/**
 * Class HarakiriCriteria
 * @package harakiri_repository_pattern\Repository\HarakiriCriteria
 * @author Anderson Andrade <contato@andersonandra.de>
 */
abstract class HarakiriCriteria implements CriteriaInterface
{
    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed|void
     */
    public abstract function apply($model, RepositoryInterface $repository);
}
