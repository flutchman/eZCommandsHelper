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
        $cmd = $this->getApplication()->find('1');
        $cmd->run(new ArrayInput(['command' => '1']));
        $cmd = $this->getApplication()->find('2');
        $cmd->run(new ArrayInput(['command' => '2']));
        $cmd = $this->getApplication()->find('3');
        $cmd->run(new ArrayInput(['command' => '3']));
        $cmd = $this->getApplication()->find('4');
        $cmd->run(new ArrayInput(['command' => '4']));
        $cmd = $this->getApplication()->find('5');
        $cmd->run(new ArrayInput(['command' => '5']));
        $output->writeln('');
        $output->writeln('');
        $this->io->success('All commands had been runned!');
    }
}
