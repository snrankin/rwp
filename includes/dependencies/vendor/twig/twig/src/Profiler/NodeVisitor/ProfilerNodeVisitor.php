<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RWP\Vendor\Twig\Profiler\NodeVisitor;

use RWP\Vendor\Twig\Environment;
use RWP\Vendor\Twig\Node\BlockNode;
use RWP\Vendor\Twig\Node\BodyNode;
use RWP\Vendor\Twig\Node\MacroNode;
use RWP\Vendor\Twig\Node\ModuleNode;
use RWP\Vendor\Twig\Node\Node;
use RWP\Vendor\Twig\NodeVisitor\NodeVisitorInterface;
use RWP\Vendor\Twig\Profiler\Node\EnterProfileNode;
use RWP\Vendor\Twig\Profiler\Node\LeaveProfileNode;
use RWP\Vendor\Twig\Profiler\Profile;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class ProfilerNodeVisitor implements NodeVisitorInterface
{
    private $extensionName;
    public function __construct(string $extensionName)
    {
        $this->extensionName = $extensionName;
    }
    public function enterNode(Node $node, Environment $env) : Node
    {
        return $node;
    }
    public function leaveNode(Node $node, Environment $env) : ?Node
    {
        if ($node instanceof ModuleNode) {
            $varName = $this->getVarName();
            $node->setNode('display_start', new Node([new EnterProfileNode($this->extensionName, Profile::TEMPLATE, $node->getTemplateName(), $varName), $node->getNode('display_start')]));
            $node->setNode('display_end', new Node([new LeaveProfileNode($varName), $node->getNode('display_end')]));
        } elseif ($node instanceof BlockNode) {
            $varName = $this->getVarName();
            $node->setNode('body', new BodyNode([new EnterProfileNode($this->extensionName, Profile::BLOCK, $node->getAttribute('name'), $varName), $node->getNode('body'), new LeaveProfileNode($varName)]));
        } elseif ($node instanceof MacroNode) {
            $varName = $this->getVarName();
            $node->setNode('body', new BodyNode([new EnterProfileNode($this->extensionName, Profile::MACRO, $node->getAttribute('name'), $varName), $node->getNode('body'), new LeaveProfileNode($varName)]));
        }
        return $node;
    }
    private function getVarName() : string
    {
        return \sprintf('__internal_%s', \hash('sha256', $this->extensionName));
    }
    public function getPriority() : int
    {
        return 0;
    }
}
