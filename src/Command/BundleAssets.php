<?php

/**
 * @copyright Copyright (C) Flutchman. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Flutchman\eZCommandsHelper\Command;

use Flutchman\eZCommandsHelper\Core\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $cmd = $this->runProcess('bin/console assets:install --symlink --relative');
        $this->io->success($cmd);
    }
}
