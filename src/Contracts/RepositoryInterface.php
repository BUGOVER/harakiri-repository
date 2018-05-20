<?php
declare(strict_types=1);

namespace Harakiri\Repository\Contracts;

/**
 *
 * Interface RepositoryInterface
 * @package Harakiri\Repository\Contracts
 */
interface RepositoryInterface
{
    /**
     * @param $column
     * @param null $key
     * @return mixed
     */
    public function lists($column, $key = null);

    /**
     * @param $column
     * @param null $key
     * @return mixed
     */
    public function pluck($column, $key = null);
}
