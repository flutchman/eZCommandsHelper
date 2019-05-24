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
        $this->addArgument(
            'sfcommand',
            InputArgument::IS_ARRAY,
            'Symfony Command to run. Use "" to pass options.'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getApplication()->getLogo());
        // Getting command
        $allArguments = $input->getArgument('sfcommand');
        array_unshift($allArguments, 'bin/console');
        // Display current command
        $this->io->block(implode(' ', $allArguments));
        // Creating subprocess to be performed
        $cmd = $this->runProcess(implode(' ', $allArguments));
        $this->io->success($cmd);
    }
}
