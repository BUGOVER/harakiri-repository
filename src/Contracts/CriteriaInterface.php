<?php
declare(strict_types=1);

namespace Harakiri\Repository\Contracts;

/**
 * Interface CriteriaInterface
 * @package harakiri_repository_pattern\Repository\Contracts
 * @author Anderson Andrade <contato@andersonandra.de>
 */
interface CriteriaInterface
{
    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository);
}
