<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RWP\Vendor\Symfony\Bridge\Twig\Node;

use RWP\Vendor\Symfony\Component\Form\FormRenderer;
use RWP\Vendor\Twig\Compiler;
use RWP\Vendor\Twig\Node\Node;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class FormThemeNode extends Node\Node {
    public function __construct(Node\Node $form, Node\Node $resources, int $lineno, string $tag = null, bool $only = \false) {
        parent::__construct(['form' => $form, 'resources' => $resources], ['only' => $only], $lineno, $tag);
    }
    public function compile(Compiler $compiler): void {
        $compiler->addDebugInfo($this)->write('$this->env->getRuntime(')->string(FormRenderer::class)->raw(')->setTheme(')->subcompile($this->getNode('form'))->raw(', ')->subcompile($this->getNode('resources'))->raw(', ')->raw(\false === $this->getAttribute('only') ? 'true' : 'false')->raw(");\n");
    }
}
