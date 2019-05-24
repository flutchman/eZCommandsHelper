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
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class Cleanup.
 */
class Cleanup extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('cleanup')->setDescription('Public dir deletion');
        $this->setAliases(['1', 'clean', 'delete', 'd']);
        $this->addOption(
            'folder',
            'f',
            InputArgument::OPTIONAL,
            'Specify folder path, separated by "," if multiple.'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getApplication()->getLogo());
        $this->io->block('Cleaning public directories');
        // Getting folder list
        $folderList = $input->getOption('folder') ?
            explode(',', $input->getOption('folder')) :
            $this->projectConfiguration->get('public_dir')
        ;
        // Update progress
        $this->setProgressMax(100 / \count($folderList));
        // Initiate deletion
        $fileSystem = new Filesystem();
        foreach ($folderList as $folder) {
            $this->progressBar->advance();
            $currentFolder = getcwd() . \DIRECTORY_SEPARATOR . $folder;
            if (!is_dir($currentFolder)) {
                $this->io->text($folder . ' not a folder, moving on.');
                continue;
            }
            // Proper deletion
            $fileSystem->remove($currentFolder);
        }
        // Cleaning console
        $this->progressBar->finish();
        $output->writeln('');
        $output->writeln('');
        $this->io->success('Directories had been deleted');
    }
}
