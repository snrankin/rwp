<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RWP\Vendor\Symfony\Bridge\Twig\NodeVisitor;

use RWP\Vendor\Symfony\Bridge\Twig\Node\TransDefaultDomainNode;
use RWP\Vendor\Symfony\Bridge\Twig\Node\TransNode;
use RWP\Vendor\Twig\Environment;
use RWP\Vendor\Twig\Node\BlockNode;
use RWP\Vendor\Twig\Node\Expression\ArrayExpression;
use RWP\Vendor\Twig\Node\Expression\AssignNameExpression;
use RWP\Vendor\Twig\Node\Expression\ConstantExpression;
use RWP\Vendor\Twig\Node\Expression\FilterExpression;
use RWP\Vendor\Twig\Node\Expression\NameExpression;
use RWP\Vendor\Twig\Node\ModuleNode;
use RWP\Vendor\Twig\Node\Node;
use RWP\Vendor\Twig\Node\SetNode;
use RWP\Vendor\Twig\NodeVisitor\AbstractNodeVisitor;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class TranslationDefaultDomainNodeVisitor extends NodeVisitor\AbstractNodeVisitor {
    private $scope;
    public function __construct() {
        $this->scope = new Bridge\Twig\NodeVisitor\Scope();
    }
    /**
     * {@inheritdoc}
     */
    protected function doEnterNode(Node\Node $node, Environment $env): Node\Node {
        if ($node instanceof Node\BlockNode || $node instanceof Node\ModuleNode) {
            $this->scope = $this->scope->enter();
        }
        if ($node instanceof Bridge\Twig\Node\TransDefaultDomainNode) {
            if ($node->getNode('expr') instanceof Node\Expression\ConstantExpression) {
                $this->scope->set('domain', $node->getNode('expr'));
                return $node;
            } else {
                $var = $this->getVarName();
                $name = new Node\Expression\AssignNameExpression($var, $node->getTemplateLine());
                $this->scope->set('domain', new Node\Expression\NameExpression($var, $node->getTemplateLine()));
                return new Node\SetNode(\false, new Node\Node([$name]), new Node\Node([$node->getNode('expr')]), $node->getTemplateLine());
            }
        }
        if (!$this->scope->has('domain')) {
            return $node;
        }
        if ($node instanceof Node\Expression\FilterExpression && 'trans' === $node->getNode('filter')->getAttribute('value')) {
            $arguments = $node->getNode('arguments');
            if ($this->isNamedArguments($arguments)) {
                if (!$arguments->hasNode('domain') && !$arguments->hasNode(1)) {
                    $arguments->setNode('domain', $this->scope->get('domain'));
                }
            } elseif (!$arguments->hasNode(1)) {
                if (!$arguments->hasNode(0)) {
                    $arguments->setNode(0, new Node\Expression\ArrayExpression([], $node->getTemplateLine()));
                }
                $arguments->setNode(1, $this->scope->get('domain'));
            }
        } elseif ($node instanceof Bridge\Twig\Node\TransNode) {
            if (!$node->hasNode('domain')) {
                $node->setNode('domain', $this->scope->get('domain'));
            }
        }
        return $node;
    }
    /**
     * {@inheritdoc}
     */
    protected function doLeaveNode(Node\Node $node, Environment $env): ?Node\Node {
        if ($node instanceof Bridge\Twig\Node\TransDefaultDomainNode) {
            return null;
        }
        if ($node instanceof Node\BlockNode || $node instanceof Node\ModuleNode) {
            $this->scope = $this->scope->leave();
        }
        return $node;
    }
    /**
     * {@inheritdoc}
     */
    public function getPriority(): int {
        return -10;
    }
    private function isNamedArguments(Node\Node $arguments): bool {
        foreach ($arguments as $name => $node) {
            if (!\is_int($name)) {
                return \true;
            }
        }
        return \false;
    }
    private function getVarName(): string {
        return \sprintf('__internal_%s', \hash('sha256', \uniqid(\mt_rand(), \true), \false));
    }
}
