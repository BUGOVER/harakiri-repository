<?php
declare(strict_types=1);

namespace Harakiri\Repository\Contracts;

use Harakiri\Repository\Criteria\Criteria;
use Illuminate\Support\Collection;


/**
 * Interface RepositoryCriteriaInterface
 * @package harakiri_repository_pattern\Repository\Contracts
 * @author Anderson Andrade <contato@andersonandra.de>
 */
interface RepositoryCriteriaInterface
{

    /**
     * Push Criteria for filter the query
     *
     * @param $criteria
     *
     * @return $this
     */
    public function pushCriteria($criteria);

    /**
     * Pop Criteria
     *
     * @param $criteria
     *
     * @return $this
     */
    public function popCriteria($criteria);

    /**
     * @return mixed
     */
    public function getCriteria();

    /**
     * @param Criteria $criteria
     * @return mixed
     */
    public function getByCriteria(Criteria $criteria);

    /**
     * @param bool $status
     * @return mixed
     */
    public function skipCriteria($status = true);

    /**
     * @return mixed
     */
    public function resetCriteria();
}
