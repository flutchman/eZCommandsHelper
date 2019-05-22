<?php
/**
 * @copyright Copyright (C) Flutchman. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Flutchman\eZCommandsHelper\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CommandPass.
 */
class CommandPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    protected $env;

    /**
     * CommandPass constructor.
     *
     * @param string $env
     */
    public function __construct($env)
    {
        $this->env = $env;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $commands = $container->findTaggedServiceIds('flutchman.ezcommands.command');
        foreach ($commands as $id => $tags) {
            $commandDefinition = $container->getDefinition($id);
            $commandDefinition->addMethodCall('setProjectConfiguration', [new Reference('project_configuration')]);
            $commandDefinition->addMethodCall('setAppDir', [$container->getParameter('app_dir')]);
            $commandDefinition->addMethodCall('setProjectPath', [$container->getParameter('project_path')]);
        }
    }
}
