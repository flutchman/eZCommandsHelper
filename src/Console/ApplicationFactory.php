<?php

/**
 * @copyright Copyright (C) Flutchman. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Flutchman\eZCommandsHelper\Console;

use Flutchman\eZCommandsHelper\Console;
use Flutchman\eZCommandsHelper\DependencyInjection\CommandPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;

/**
 * Class ApplicationFactory.
 */
class ApplicationFactory
{
    /**
     * Create the Application.
     *
     * @param bool $autoExit Default: true
     * @param string $env Default: prod
     * @param string $operatingSystem Default: PHP_OS
     *
     * @return Application
     */
    public static function create($autoExit = true, $env = 'prod', $operatingSystem = PHP_OS)
    {
        \define('EZ_HOME', getenv('HOME') . '/.ez-cmd');
        \define('EZ_ON_OSX', 'Darwin' === $operatingSystem);
        $container = new ContainerBuilder();
        $container->addCompilerPass(new CommandPass($env));
        $container->addCompilerPass(new RegisterListenersPass());
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load(__DIR__ . '/../../config/services.yml');
        $loader->load(__DIR__ . '/../../config/commands.yml');
        $application = new Console\Application();
        $application->setContainer($container);
        $application->setEnv($env);
        $application->setName('eZ Commands Helper');
        $application->setVersion('@package_version@' . (('prod' !== $env) ? '-dev' : ''));
        $application->setAutoExit($autoExit);

        return $application;
    }
}
