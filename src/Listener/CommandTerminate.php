<?php

/**
 * @copyright Copyright (C) Flutchman. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Flutchman\eZCommandsHelper\Listener;

use Flutchman\eZCommandsHelper\Core\Command;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class CommandTerminate.
 */
class CommandTerminate
{
    public function onTerminateAction(ConsoleTerminateEvent $event)
    {
        /** @var Command $command */
        $command = $event->getCommand();
        if (!$command instanceof Command) {
            return;
        }

        $fs = new Filesystem();
        $command->getRequiredRecipes()->each(
            function ($recipe) use ($fs, $command) {
                $fs->remove("{$command->getProjectPath()}/{$recipe}.bash");
            }
        );
    }
}
