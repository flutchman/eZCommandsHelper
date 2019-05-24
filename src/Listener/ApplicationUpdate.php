<?php

/**
 * @copyright Copyright (C) Flutchman. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Flutchman\eZCommandsHelper\Listener;

use Carbon\Carbon;
use Flutchman\eZCommandsHelper\Configuration\Project as ProjectConfiguration;
use Humbug\SelfUpdate\Strategy\ShaStrategy;
use Humbug\SelfUpdate\Updater;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Style\SymfonyStyle;

class ApplicationUpdate
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var ProjectConfiguration
     */
    protected $projectConfiguration;

    /**
     * ApplicationUpdate constructor.
     *
     * @param $configuration
     */
    public function __construct($parameters, ProjectConfiguration $configuration)
    {
        $this->parameters = $parameters;
        $this->projectConfiguration = $configuration;
    }

    public function onCommandAction(ConsoleCommandEvent $event)
    {
        $env = $this->parameters['env'];
        $dir = $this->parameters['dir'];
        $url = $this->parameters['url'];
        $version = $this->parameters['version'];

        $command = $event->getCommand();
        if (\in_array($command->getName(), ['self-update', 'rollback'])) {
            return;
        }

        if (!\in_array($command->getName(), [
            'bundles',
            'cleanup',
            'help',
            'list',
            'self-update',
            'sfrun',
            'translate',
            'rollback',
        ])) {
            $io = new SymfonyStyle($event->getInput(), $event->getOutput());
            $io->error('Unknown command.');
            $event->disableCommand();
            $event->stopPropagation();

            return;
        }

        // check last time check
        if (null != $this->projectConfiguration->get('last_update_check')) {
            $lastUpdate = Carbon::createFromTimestamp($this->projectConfiguration->get('last_update_check'));
            $now = Carbon::now();
            if ($now > $lastUpdate->subDays(3)) {
                return;
            }
        }

        $localPharFile = 'prod' == $env ? null : $dir . 'docs/ez-cmd.phar';
        $updater = new Updater($localPharFile);
        $strategy = $updater->getStrategy();
        if ($strategy instanceof ShaStrategy) {
            $strategy->setPharUrl($url);
            $strategy->setVersionUrl($version);
//            if ($updater->hasUpdate()) {
//                $io = new SymfonyStyle($event->getInput(), $event->getOutput());
//                $io->note('A new version of eZ Commands Helper is available, please run self-update.');
//                sleep(2);
//            }
        }

        if (!\in_array($command->getName(), ['list', 'help'])) {
            $this->projectConfiguration->setLocal('last_update_check', time());
        }
    }
}
