<?php

/**
 * @copyright Copyright (C) Flutchman. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Flutchman\eZCommandsHelper\Command;

use Flutchman\eZCommandsHelper\Core\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class BundleAssets.
 */
class BundleAssets extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('bundles')->setDescription('Initiate assets link.');
        $this->setAliases(['2', 'bundle', 'b']);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getApplication()->getLogo());
        $this->io->block('Initiate bundle assets');
        // Add loader
        $progressBar = new ProgressBar($output);
        $progressBar->setFormat('[%bar%]');
        // Getting command
        $process = new Process('bin/console assets:install --symlink --relative');
        $process->start();
        while ($process->isRunning()) {
            $progressBar->advance();
        }
        // Check process ending
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        // Cleaning console
        $progressBar->finish();
        $output->writeln('');
        $output->writeln('');
        $this->io->success($process->getOutput());
    }
}
