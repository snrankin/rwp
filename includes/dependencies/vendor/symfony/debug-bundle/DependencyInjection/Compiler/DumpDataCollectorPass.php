<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RWP\Vendor\Symfony\Bundle\DebugBundle\DependencyInjection\Compiler;

use RWP\Vendor\Symfony\Bundle\WebProfilerBundle\EventListener\WebDebugToolbarListener;
use RWP\Vendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use RWP\Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the file link format for the {@link DumpDataCollector}.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
class DumpDataCollectorPass implements CompilerPassInterface {
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container) {
        if (!$container->hasDefinition('data_collector.dump')) {
            return;
        }
        $definition = $container->getDefinition('data_collector.dump');
        if (!$container->hasParameter('web_profiler.debug_toolbar.mode') || Bundle\WebProfilerBundle\EventListener\WebDebugToolbarListener::DISABLED === $container->getParameter('web_profiler.debug_toolbar.mode')) {
            $definition->replaceArgument(3, null);
        }
    }
}
