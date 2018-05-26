<?php
declare(strict_types=1);

namespace Harakiri\Repository\Eloquent;

use Closure;
use Exception;
use Harakiri\Repository\Contracts\CriteriaInterface;
use Harakiri\Repository\Contracts\RepositoryCriteriaInterface;
use Harakiri\Repository\Contracts\RepositoryInterface;
use Harakiri\Repository\Criteria\HarakiriCriteria;
use Harakiri\Repository\Exceptions\RepositoryException;
use Harakiri\Repository\Traits\RepositoryTrait;
use Harakiri\Validator\Contracts\ValidatorInterface;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class BaseRepository
 * @package harakiri_repository_pattern\Repository\Eloquent
 * @author Anderson Andrade <contato@andersonandra.de>
 */
abstract class BaseRepository extends Model implements RepositoryInterface, RepositoryCriteriaInterface
{
    use RepositoryTrait;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var null
     */
    protected $rules = null;

    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * @var
     */
    protected $scopeQuery;

    /**
     * BaseRepository constructor.
     * @param Application $app
     * @throws RepositoryException
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->criteria = new Collection();
        $this->makeModel();
        $this->makeValidator();
        $this->boot();
    }

    /**
     *
     */
    public function boot()
    {
        //
    }

    /**
     * @throws RepositoryException
     */
    public function resetModel()
    {
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function model();

    /**
     * Specify Validator class name of harakiri_repository_pattern\Validator\Contracts\ValidatorInterface
     *
     * @return null
     * @throws Exception
     */
    public function validator()
    {

        if ($this->rules !== null && null !== $this->rules && \is_array($this->rules) && !empty($this->rules)) {
            if (class_exists('Harakiri\Validator\LaravelValidator')) {
                $validator = app('Harakiri\Validator\LaravelValidator');
                if ($validator instanceof ValidatorInterface) {
                    $validator->setRules($this->rules);

                    return $validator;
                }
            } else {
                throw new Exception(trans('repository::packages.Harakiri_laravel_validation_required'));
            }
        }

        return null;
    }

    /**
     * @return Model|mixed
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * @param null $validator
     * @return ValidatorInterface|null
     * @throws RepositoryException
     * @throws Exception
     */
    public function makeValidator($validator = null)
    {
        $validator = $validator ?? $this->validator();

        if (null !== $validator) {
            $this->validator = \is_string($validator) ? $this->app->make($validator) : $validator;

            if (!$this->validator instanceof ValidatorInterface) {
                throw new RepositoryException("Class {$validator} must be an instance of harakiri_repository_pattern\\Validator\\Contracts\\ValidatorInterface");
            }

            return $this->validator;
        }

        return null;
    }

    /**
     * @param $criteria
     * @return $this|RepositoryCriteriaInterface
     * @throws RepositoryException
     */
    public function pushCriteria($criteria)
    {
        if (\is_string($criteria)) {
            $criteria = new $criteria;
        }
        if (!$criteria instanceof CriteriaInterface) {
            throw new RepositoryException("Class " . \get_class($criteria) . " must be an instance of BugOver\\Repository\\Contracts\\CriteriaInterface");
        }
        $this->criteria->push($criteria);

        return $this;
    }

    /**
     * @param $criteria
     * @return $this|RepositoryCriteriaInterface
     */
    public function popCriteria($criteria)
    {
        $this->criteria = $this->criteria->reject(function ($item) use ($criteria) {
            if (\is_object($item) && \is_string($criteria)) {
                return \get_class($item) === $criteria;
            }

            if (\is_string($item) && \is_object($criteria)) {
                return $item === \get_class($criteria);
            }

            return \get_class($item) === \get_class($criteria);
        });

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCriteria(): Collection
    {
        return $this->criteria;
    }

    /**
     * @param HarakiriCriteria $criteria
     * @return $this
     */
    public function getByCriteria(HarakiriCriteria $criteria)
    {
        $this->modelQuery = $criteria->apply($this->modelQuery, $this);
        return $this;
    }

    /**
     * @param bool $status
     * @return $this|RepositoryCriteriaInterface
     */
    public function skipCriteria($status = true)
    {
        $this->skipCriteria = $status;

        return $this;
    }

    /**
     * @return $this|RepositoryCriteriaInterface
     */
    public function resetCriteria()
    {
        $this->criteria = new Collection();

        return $this;
    }

    /**
     * @param Closure $query
     * @return $this
     */
    public function query(Closure $query): self
    {
        $this->scopeQuery = $query;
        return $this;
    }

    /**
     * @return $this
     */
    protected function applyCriteria(): self
    {

        if ($this->skipCriteria === true) {
            return $this;
        }

        $criteria = $this->getCriteria();

        if ($criteria) {
            foreach ($criteria as $c) {
                if ($c instanceof CriteriaInterface) {
                    $this->model = $c->apply($this->model, $this);
                }
            }
        }

        return $this;
    }

    /**
     * @param $column
     * @param null $key
     * @return mixed
     */
    public function lists($column, $key = null)
    {
        $this->applyCriteria();

        return $this->model->lists($column, $key);
    }

    /**
     * @param $column
     * @param null $key
     * @return mixed
     */
    public function pluck($column, $key = null)
    {
        $this->applyCriteria();

        return $this->model->pluck($column, $key);
    }

    /**
     * @param $name
     * @param $argument
     * @return Model
     */
    public function __call($name, $argument)
    {
        return $this->model;
    }
}
