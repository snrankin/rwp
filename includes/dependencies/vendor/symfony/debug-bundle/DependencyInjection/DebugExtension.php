<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RWP\Vendor\Symfony\Bundle\DebugBundle\DependencyInjection;

use RWP\Vendor\Symfony\Bridge\Monolog\Command\ServerLogCommand;
use RWP\Vendor\Symfony\Bundle\DebugBundle\Command\ServerDumpPlaceholderCommand;
use RWP\Vendor\Symfony\Component\Config\FileLocator;
use RWP\Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use RWP\Vendor\Symfony\Component\DependencyInjection\Extension\Extension;
use RWP\Vendor\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use RWP\Vendor\Symfony\Component\DependencyInjection\Reference;
use RWP\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster;
use RWP\Vendor\Symfony\Component\VarDumper\Dumper\CliDumper;
use RWP\Vendor\Symfony\Component\VarDumper\Dumper\HtmlDumper;

/**
 * DebugExtension.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DebugExtension extends Extension {
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container) {
        $configuration = new Bundle\DebugBundle\DependencyInjection\Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');
        $container->getDefinition('var_dumper.cloner')->addMethodCall('setMaxItems', [$config['max_items']])->addMethodCall('setMinDepth', [$config['min_depth']])->addMethodCall('setMaxString', [$config['max_string_length']]);
        if (\method_exists(ReflectionCaster::class, 'unsetClosureFileInfo')) {
            $container->getDefinition('var_dumper.cloner')->addMethodCall('addCasters', [Component\VarDumper\Caster\ReflectionCaster::UNSET_CLOSURE_FILE_INFO]);
        }
        if (\method_exists(HtmlDumper::class, 'setTheme') && 'dark' !== $config['theme']) {
            $container->getDefinition('var_dumper.html_dumper')->addMethodCall('setTheme', [$config['theme']]);
        }
        if (null === $config['dump_destination']) {
            $container->getDefinition('var_dumper.command.server_dump')->setClass(Bundle\DebugBundle\Command\ServerDumpPlaceholderCommand::class);
        } elseif (\str_starts_with($config['dump_destination'], 'tcp://')) {
            $container->getDefinition('debug.dump_listener')->replaceArgument(2, new Reference('var_dumper.server_connection'));
            $container->getDefinition('data_collector.dump')->replaceArgument(4, new Reference('var_dumper.server_connection'));
            $container->getDefinition('var_dumper.dump_server')->replaceArgument(0, $config['dump_destination']);
            $container->getDefinition('var_dumper.server_connection')->replaceArgument(0, $config['dump_destination']);
        } else {
            $container->getDefinition('var_dumper.cli_dumper')->replaceArgument(0, $config['dump_destination']);
            $container->getDefinition('data_collector.dump')->replaceArgument(4, new Reference('var_dumper.cli_dumper'));
            $container->getDefinition('var_dumper.command.server_dump')->setClass(Bundle\DebugBundle\Command\ServerDumpPlaceholderCommand::class);
        }
        if (\method_exists(CliDumper::class, 'setDisplayOptions')) {
            $container->getDefinition('var_dumper.cli_dumper')->addMethodCall('setDisplayOptions', [['fileLinkFormat' => new Reference('debug.file_link_formatter', ContainerBuilder::IGNORE_ON_INVALID_REFERENCE)]]);
        }
        if (!\class_exists(Bridge\Monolog\Command\ServerLogCommand::class)) {
            $container->removeDefinition('monolog.command.server_log');
        }
    }
    /**
     * {@inheritdoc}
     */
    public function getXsdValidationBasePath() {
        return __DIR__ . '/../Resources/config/schema';
    }
    /**
     * {@inheritdoc}
     */
    public function getNamespace() {
        return 'http://symfony.com/schema/dic/debug';
    }
}
