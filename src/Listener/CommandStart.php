<?php

/**
 * @copyright Copyright (C) Flutchman. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Flutchman\eZCommandsHelper\Listener;

use Flutchman\eZCommandsHelper\Core\Command;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

/**
 * Class CommandStart.
 */
class CommandStart
{
    public function onCommandAction(ConsoleCommandEvent $event)
    {
        /** @var Command $command */
        $command = $event->getCommand();
        if (!$command instanceof Command) {
            return;
        }
    }
}
