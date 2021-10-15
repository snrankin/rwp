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

use RWP\Vendor\Symfony\Bridge\Twig\Node\TransNode;
use RWP\Vendor\Twig\Environment;
use RWP\Vendor\Twig\Node\Expression\Binary\ConcatBinary;
use RWP\Vendor\Twig\Node\Expression\ConstantExpression;
use RWP\Vendor\Twig\Node\Expression\FilterExpression;
use RWP\Vendor\Twig\Node\Expression\FunctionExpression;
use RWP\Vendor\Twig\Node\Node;
use RWP\Vendor\Twig\NodeVisitor\AbstractNodeVisitor;

/**
 * TranslationNodeVisitor extracts translation messages.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class TranslationNodeVisitor extends NodeVisitor\AbstractNodeVisitor {
    public const UNDEFINED_DOMAIN = '_undefined';
    private $enabled = \false;
    private $messages = [];
    public function enable(): void {
        $this->enabled = \true;
        $this->messages = [];
    }
    public function disable(): void {
        $this->enabled = \false;
        $this->messages = [];
    }
    public function getMessages(): array {
        return $this->messages;
    }
    /**
     * {@inheritdoc}
     */
    protected function doEnterNode(Node\Node $node, Environment $env): Node\Node {
        if (!$this->enabled) {
            return $node;
        }
        if ($node instanceof Node\Expression\FilterExpression && 'trans' === $node->getNode('filter')->getAttribute('value') && $node->getNode('node') instanceof Node\Expression\ConstantExpression) {
            // extract constant nodes with a trans filter
            $this->messages[] = [$node->getNode('node')->getAttribute('value'), $this->getReadDomainFromArguments($node->getNode('arguments'), 1)];
        } elseif ($node instanceof Node\Expression\FunctionExpression && 't' === $node->getAttribute('name')) {
            $nodeArguments = $node->getNode('arguments');
            if ($nodeArguments->getIterator()->current() instanceof Node\Expression\ConstantExpression) {
                $this->messages[] = [$this->getReadMessageFromArguments($nodeArguments, 0), $this->getReadDomainFromArguments($nodeArguments, 2)];
            }
        } elseif ($node instanceof Bridge\Twig\Node\TransNode) {
            // extract trans nodes
            $this->messages[] = [$node->getNode('body')->getAttribute('data'), $node->hasNode('domain') ? $this->getReadDomainFromNode($node->getNode('domain')) : null];
        } elseif ($node instanceof Node\Expression\FilterExpression && 'trans' === $node->getNode('filter')->getAttribute('value') && $node->getNode('node') instanceof Node\Expression\Binary\ConcatBinary && ($message = $this->getConcatValueFromNode($node->getNode('node'), null))) {
            $this->messages[] = [$message, $this->getReadDomainFromArguments($node->getNode('arguments'), 1)];
        }
        return $node;
    }
    /**
     * {@inheritdoc}
     */
    protected function doLeaveNode(Node\Node $node, Environment $env): ?Node\Node {
        return $node;
    }
    /**
     * {@inheritdoc}
     */
    public function getPriority(): int {
        return 0;
    }
    private function getReadMessageFromArguments(Node\Node $arguments, int $index): ?string {
        if ($arguments->hasNode('message')) {
            $argument = $arguments->getNode('message');
        } elseif ($arguments->hasNode($index)) {
            $argument = $arguments->getNode($index);
        } else {
            return null;
        }
        return $this->getReadMessageFromNode($argument);
    }
    private function getReadMessageFromNode(Node\Node $node): ?string {
        if ($node instanceof Node\Expression\ConstantExpression) {
            return $node->getAttribute('value');
        }
        return null;
    }
    private function getReadDomainFromArguments(Node\Node $arguments, int $index): ?string {
        if ($arguments->hasNode('domain')) {
            $argument = $arguments->getNode('domain');
        } elseif ($arguments->hasNode($index)) {
            $argument = $arguments->getNode($index);
        } else {
            return null;
        }
        return $this->getReadDomainFromNode($argument);
    }
    private function getReadDomainFromNode(Node\Node $node): ?string {
        if ($node instanceof Node\Expression\ConstantExpression) {
            return $node->getAttribute('value');
        }
        return self::UNDEFINED_DOMAIN;
    }
    private function getConcatValueFromNode(Node\Node $node, ?string $value): ?string {
        if ($node instanceof Node\Expression\Binary\ConcatBinary) {
            foreach ($node as $nextNode) {
                if ($nextNode instanceof Node\Expression\Binary\ConcatBinary) {
                    $nextValue = $this->getConcatValueFromNode($nextNode, $value);
                    if (null === $nextValue) {
                        return null;
                    }
                    $value .= $nextValue;
                } elseif ($nextNode instanceof Node\Expression\ConstantExpression) {
                    $value .= $nextNode->getAttribute('value');
                } else {
                    // this is a node we cannot process (variable, or translation in translation)
                    return null;
                }
            }
        } elseif ($node instanceof Node\Expression\ConstantExpression) {
            $value .= $node->getAttribute('value');
        }
        return $value;
    }
}
