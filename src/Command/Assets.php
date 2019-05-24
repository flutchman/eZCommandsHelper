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
 * Class Assets.
 */
class Assets extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('assets')->setDescription('Generate Webpack assets.');
        $this->setAliases(['5', 'asset', 'a']);
        $this->addOption(
            'env',
            'e',
            InputArgument::OPTIONAL,
            'Select which env to generate assets'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getApplication()->getLogo());
        $this->io->block('Generate Webpack assets');
        $this->io->text('Installation');
        $cmd = $this->runProcess('yarn install');
        $this->io->success($cmd);
        $this->io->text('Building');
        $cmd = $this->runProcess('yarn encore ' . ($input->getOption('env') ?: 'dev'));
        $this->io->success($cmd);
    }
}
