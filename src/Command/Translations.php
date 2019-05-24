<?php

/**
 * @copyright Copyright (C) Flutchman. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Flutchman\eZCommandsHelper\Command;

use Flutchman\eZCommandsHelper\Core\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class Translations.
 */
class Translations extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('translate')->setDescription('Initiate assets link.');
        $this->setAliases(['3', 'trans', 't']);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getApplication()->getLogo());
        $this->io->block('Initiate js\' translations');
        // Getting command
        $process = new Process('bin/console bazinga:js-translation:dump web/assets --merge-domains');
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
