<?php
declare(strict_types=1);

namespace Harakiri\Repository\Generators;

/**
 * Class ServiceGenerator
 * @package harakiri_repository_pattern\Repository\Generators
 * @author Anderson Andrade <contato@andersonandra.de>
 */

/**
 * Class ServiceGenerator
 * @package harakiri_repository_pattern\Repository\Generators
 */
class ServiceGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'service/service';

    /**
     *
     */
    protected function checkAfterDirectory()
    {

    }

    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return str_replace('/', '\\',
                parent::getRootNamespace() . parent::getConfigGeneratorClassPath($this->getPathConfigNode())) .
            'Services';
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'services';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/Services' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(),
                true) . '/' . $this->getServiceName() . 'Service.php';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return config('repository.generator.basePath', app()->path());
    }

    /**
     * Gets controller name based on model
     *
     * @return string
     */
    public function getServiceName()
    {
        return ucfirst($this->getPluralName());
    }

    /**
     * Gets plural name based on model
     *
     * @return string
     */
    public function getPluralName()
    {
        return /*str_plural(*/
            lcfirst(ucwords($this->getClass()))/*)*/
            ;
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {

        return array_merge(parent::getReplacements(), [
            'controller' => $this->getServiceName(),
            'plural' => $this->getPluralName(),
            'singular' => $this->getSingularName(),
            'validator' => $this->getValidator(),
            'repository' => $this->getRepository(),
            'appname' => $this->getAppNamespace(),
        ]);
    }

    /**
     * Gets singular name based on model
     *
     * @return string
     */
    public function getSingularName()
    {
        return str_singular(lcfirst(ucwords($this->getClass())));
    }

    /**
     * Gets validator full class name
     *
     * @return string
     */
    public function getValidator()
    {
        $validatorGenerator = new ValidatorGenerator([
            'name' => $this->name,
        ]);

        $validator = $validatorGenerator->getRootNamespace() . '\\' . $validatorGenerator->getName();

        return 'use ' . str_replace([
                "\\",
                '/'
            ], '\\', $validator) . 'Validator;';
    }


    /**
     * Gets repository full class name
     *
     * @return string
     */
    public function getRepository()
    {
        $repositoryGenerator = new RepositoryInterfaceGenerator([
            'name' => $this->name,
        ]);

        $repository = $repositoryGenerator->getRootNamespace() . '\\' . $repositoryGenerator->getName();

        return 'use ' . str_replace([
                "\\",
                '/'
            ], '\\', $repository) . 'Repository;';
    }
}
