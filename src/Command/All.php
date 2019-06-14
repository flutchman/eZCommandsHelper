<?php

/**
 * @copyright Copyright (C) Flutchman. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Flutchman\eZCommandsHelper\Command;

use Flutchman\eZCommandsHelper\Core\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class All.
 */
class All extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('all')->setDescription('Run all initialisation commands.');
        $this->setAliases(['0', 'al']);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getApplication()->getLogo());
        $this->io->block('Running all commands');
        // Getting commands
        $cmd = $this->getApplication()->find('cleanup');
        $cmd->run(new ArrayInput(['command' => 'cleanup']), $output);
        $cmd = $this->getApplication()->find('bundles');
        $cmd->run(new ArrayInput(['command' => 'bundles']), $output);
        $cmd = $this->getApplication()->find('translate');
        $cmd->run(new ArrayInput(['command' => 'translate']), $output);
        $cmd = $this->getApplication()->find('cache');
        $cmd->run(new ArrayInput(['command' => 'cache']), $output);
        $cmd = $this->getApplication()->find('assets');
        $cmd->run(new ArrayInput(['command' => 'assets']), $output);
        $output->writeln('');
        $output->writeln('');
        $this->io->success('All commands had been runned!');
    }
}
