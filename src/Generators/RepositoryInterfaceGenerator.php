<?php

namespace Harakiri\Repository\Generators;

use const DS;

/**
 * Class RepositoryInterfaceGenerator
 * @package harakiri_repository_pattern\Repository\Generators
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryInterfaceGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'repository/interface';

    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return parent::getRootNamespace() . parent::getConfigGeneratorClassPath($this->getPathConfigNode()) .
            '\\' . $this->getName();
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'interfaces';
    }

    /**
     * @param $name
     * @return bool
     */
    protected function createFolder($name): bool
    {
        return mkdir($this->getBasePath() . DS .
            parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . DS . $name . DS);
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        $folder = $this->createFolder($this->getName());

        if ($folder) {
            return $this->getBasePath() . DS . parent::getConfigGeneratorClassPath($this->getPathConfigNode(),
                    true) . '/' . $this->getName() . '/' . $this->getName() . 'Repository.php';
        }
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
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        return array_merge(parent::getReplacements(), [
            'fillable' => $this->getFillable()
        ]);
    }

    /**
     * Get the fillable attributes.
     *
     * @return string
     */
    public function getFillable()
    {
        if (!$this->fillable) {
            return '[]';
        }
        $results = '[' . PHP_EOL;

        foreach ($this->getSchemaParser()->toArray() as $column => $value) {
            $results .= "\t\t'{$column}'," . PHP_EOL;
        }

        return $results . "\t" . ']';
    }

    /**
     * Get schema parser.
     *
     * @return SchemaParser
     */
    public function getSchemaParser()
    {
        return new SchemaParser($this->fillable);
    }
}
