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
 * Class CacheClear.
 */
class CacheClear extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('cache')->setDescription('Initiate assets link.');
        $this->setAliases(['4', 'c', 'cc']);
        $this->addOption(
            'env',
            'e',
            InputArgument::OPTIONAL,
            'Specify which env you want to clear cache'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getApplication()->getLogo());
        $this->io->block('Clearing cache');
        $cmd = $this->runProcess(
            'bin/console cache:clear ' .
            ($input->getOption('env') ? ('--env=' . $input->getOption('env')) : '')
        );
        $this->io->success($cmd);
    }
}
