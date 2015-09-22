<?php

namespace UrbanEtter\Hoi;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use UrbanEtter\Hoi\Check\Executable;
use UrbanEtter\Hoi\Check\Homebrew;
use UrbanEtter\Hoi\Install\Shell;

class Step extends Command
{
    protected $config;

    public function __construct($name, $config)
    {
        $this->config = $config;
        parent::__construct($name);
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        if (isset($this->config['description'])) {
            $this->setDescription($this->config['description']);
        }
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @param InputInterface $input An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int null or 0 if everything went fine, or an error code
     *
     * @throws \LogicException When this abstract method is not implemented
     *
     * @see setCode()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (isset($this->config['required'])) {
            foreach ($this->config['required'] as $required) {
                $this->getApplication()->find($required)->run($input, $output);
            }
        }

        if (isset($this->config['check'])) {
            $expressionLanguage = new ExpressionLanguage();
            $checks = [
                "executable" => new Executable(),
                "homebrew" => new Homebrew(),
            ];
            $result = $expressionLanguage->evaluate($this->config['check'], $checks);

            if (!$result) {
                $output->writeln($this->getName() . ' is already installed');
                return;
            }
        }

        $types = [
            "shell" => new Shell(),
        ];
        $typeName = (isset($this->config['type'])) ? isset($this->config['type']) : 'shell';

        if (!isset($types[$typeName])) {
            throw new \InvalidArgumentException("Install type $typeName unknown");
        }

        /** @var InstallInterface $type */
        $type = $types[$typeName];
        $result = $type->install($this->config);

        $output->writeln(trim($result));
    }

}