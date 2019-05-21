<?php

/**
 * @copyright Copyright (C) Flutchman. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Flutchman\eZCommandsHelper\Listener;

use Symfony\Component\Console\Event\ConsoleErrorEvent;

/**
 * Class CommandException.
 */
class CommandException
{
    public function onExceptionAction(ConsoleErrorEvent $event)
    {
        //@todo logs
    }
}
