<?php
declare(strict_types=1);

namespace Harakiri\Repository\Contracts;

use Harakiri\Repository\Criteria\HarakiriCriteria;
use Illuminate\Support\Collection;


/**
 * Interface RepositoryCriteriaInterface
 * @package harakiri_repository_pattern\Repository\Contracts
 * @author Anderson Andrade <contato@andersonandra.de>
 */
interface RepositoryCriteriaInterface
{

    /**
     * Push HarakiriCriteria for filter the query
     *
     * @param $criteria
     *
     * @return $this
     */
    public function pushCriteria($criteria);

    /**
     * Pop HarakiriCriteria
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
     * @param HarakiriCriteria $criteria
     * @return mixed
     */
    public function getByCriteria(HarakiriCriteria $criteria);

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
