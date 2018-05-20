<?php
declare(strict_types=1);

namespace Harakiri\Repository\Generators\Commands;

use Harakiri\Repository\Generators\FileAlreadyExistsException;
use Harakiri\Repository\Generators\ServiceGenerator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ControllerCommand
 * @package harakiri_repository_pattern\Repository\Generators\Commands
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class ServiceCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'make:services';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Service.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * ControllerCommand constructor.
     */
    public function __construct()
    {
        $this->name = ((float)app()->version() >= 5.5 ? 'make:services' : '');
        parent::__construct();
    }

    /**
     * Execute the command.
     *
     * @see fire()
     * @return void
     */
    public function handle()
    {
        $this->laravel->call([$this, 'fire'], func_get_args());
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function fire()
    {
        try {

            (new ServiceGenerator([
                'name' => $this->argument('name'),
                'force' => $this->option('force'),
            ]))->run();

            $this->info($this->type . ' created successfully.');

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
                'The name of model for which the services is being generated.',
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
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force the creation if file already exists.',
                null
            ],
        ];
    }
}
