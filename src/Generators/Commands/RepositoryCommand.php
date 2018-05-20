<?php
declare(strict_types=1);

namespace Harakiri\Repository\Generators\Commands;

use Harakiri\Repository\Generators\FileAlreadyExistsException;
use Harakiri\Repository\Generators\RepositoryEloquentGenerator;
use Harakiri\Repository\Generators\RepositoryInterfaceGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class RepositoryCommand
 * @package harakiri_repository_pattern\Repository\Generators\Commands
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new repository.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * @var Collection
     */
    protected $generators = null;


    /**
     * Execute the command.
     *
     * @see fire()
     * @return void
     */
    public function handle()
    {
        $this->laravel->call([$this, 'fire'], \func_get_args());
    }

    /**
     * Execute the command.
     *
     * @return bool
     */
    public function fire()
    {
        $this->generators = new Collection();

        $this->generators->push(new RepositoryInterfaceGenerator([
            'name' => $this->argument('name'),
            'force' => $this->option('force'),
        ]));

        foreach ($this->generators as $generator) {
            $generator->run();
        }

        try {
            (new RepositoryEloquentGenerator([
                'name' => $this->argument('name'),
                'rules' => $this->option('rules'),
                'validator' => $this->option('validator'),
                'force' => $this->option('force'),
            ]))->run();
            $this->info("Repository created successfully.");
        } catch (FileAlreadyExistsException $e) {
            $this->error($this->type . ' already exists!');

            return false;
        }
    }


    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of class being generated.',
                null
            ],
        ];
    }


    /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            [
                'fillable',
                null,
                InputOption::VALUE_OPTIONAL,
                'The fillable attributes.',
                null
            ],
            [
                'rules',
                null,
                InputOption::VALUE_OPTIONAL,
                'The rules of validation attributes.',
                null
            ],
            [
                'validator',
                null,
                InputOption::VALUE_OPTIONAL,
                'Adds validator reference to the repository.',
                null
            ],
            [
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force the creation if file already exists.',
                null
            ],
            [
                'skip-migrate',
                null,
                InputOption::VALUE_NONE,
                'Skip the creation of a migrate file.',
                null
            ],
            [
                'skip-model',
                null,
                InputOption::VALUE_NONE,
                'Skip the creation of a model.',
                null
            ],
        ];
    }
}
