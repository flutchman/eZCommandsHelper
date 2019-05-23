<?php

/**
 * @copyright Copyright (C) Flutchman. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Flutchman\eZCommandsHelper\Command;

use Flutchman\eZCommandsHelper\Core\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class SymfonyRun.
 */
class SymfonyRun extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('sfrun')->setDescription('Run a Symfony command.');
        $this->addArgument('sfcommand', InputArgument::IS_ARRAY, 'Symfony Command to run. Use "" to pass options.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $allArguments = $input->getArgument('sfcommand');
        array_unshift($allArguments, "bin/console");
        $process = new Process(implode(' ', $allArguments));
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }
}
