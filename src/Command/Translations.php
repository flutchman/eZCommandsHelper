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
        $cmd = $this->runProcess('bin/console bazinga:js-translation:dump web/assets --merge-domains');
        $this->io->success($cmd);
    }
}
