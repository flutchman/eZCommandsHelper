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
        // Getting command
        $this->io->text('Installation');
        $this->runProcess('yarn install', $output);
        $this->io->text('Building');
        $this->runProcess('yarn run ' . $input->getOption('env') ?: 'dev', $output);
    }

    /**
     * @param $processCmd
     */
    private function runProcess($processCmd, OutputInterface $output)
    {
        $process = new Process($processCmd);
        $process->start();
        while ($process->isRunning()) {
            $this->progressBar->advance();
        }
        // Check process ending
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        // Cleaning console
        $this->progressBar->finish();
        $output->writeln('');
        $output->writeln('');
        $this->io->success($process->getOutput());
    }
}
