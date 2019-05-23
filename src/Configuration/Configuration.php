<?php

/**
 * @copyright Copyright (C) Flutchman. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Flutchman\eZCommandsHelper\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class Configuration.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * Configuration constructor.
     */
    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $currentContainer = $this->container;

        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ez-cmd');
        $rootNode
            ->children()
                ->scalarNode('last_update_check')->defaultNull()->end()
                ->arrayNode('public_dir')
                    ->prototype('scalar')
                        ->validate()
                            ->always(function ($v) use ($currentContainer) {
                                $v = str_replace(\DIRECTORY_SEPARATOR, '/', $v);

                                if ('@' === $v[0]) {
                                    if (false === $pos = strpos($v, '/')) {
                                        $bundleName = substr($v, 1);
                                    } else {
                                        $bundleName = substr($v, 1, $pos - 1);
                                    }

                                    $bundles = $currentContainer->getParameter('kernel.bundles');
                                    if (!isset($bundles[$bundleName])) {
                                        throw new \Exception(sprintf(
                                            'The bundle "%s" does not exist. Available bundles: %s',
                                            $bundleName,
                                            implode(', ', array_keys($bundles))
                                        ));
                                    }

                                    $ref = new \ReflectionClass($bundles[$bundleName]);
                                    if (false === $pos) {
                                        $v = \dirname($ref->getFileName());
                                    } else {
                                        $v = \dirname($ref->getFileName()) . substr($v, $pos);
                                    }
                                }

                                if (!is_dir($v)) {
                                    throw new \Exception(sprintf('The directory "%s" does not exist.', $v));
                                }

                                return $v;
                            })
                        ->end()
                    ->end()
                    ->defaultValue([
                        'var/cache/',
                        'var/logs/',
                        'var/encore/',
                        'var/sessions/',
                        'web/assets/build/',
                        'web/assets/ezplatform/build/',
                        'web/bundles/',
                    ])
                ->end()
            ->end();

        return $treeBuilder;
    }
}
