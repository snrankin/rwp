<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RWP\Vendor\Symfony\Bridge\Twig\TokenParser;

use RWP\Vendor\Symfony\Bridge\Twig\Node\StopwatchNode;
use RWP\Vendor\Twig\Node\Expression\AssignNameExpression;
use RWP\Vendor\Twig\Node\Node;
use RWP\Vendor\Twig\Token;
use RWP\Vendor\Twig\TokenParser\AbstractTokenParser;

/**
 * Token Parser for the stopwatch tag.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
final class StopwatchTokenParser extends TokenParser\AbstractTokenParser {
    protected $stopwatchIsAvailable;
    public function __construct(bool $stopwatchIsAvailable) {
        $this->stopwatchIsAvailable = $stopwatchIsAvailable;
    }
    public function parse(Token $token): Node\Node {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        // {% stopwatch 'bar' %}
        $name = $this->parser->getExpressionParser()->parseExpression();
        $stream->expect(Token::BLOCK_END_TYPE);
        // {% endstopwatch %}
        $body = $this->parser->subparse([$this, 'decideStopwatchEnd'], \true);
        $stream->expect(Token::BLOCK_END_TYPE);
        if ($this->stopwatchIsAvailable) {
            return new Bridge\Twig\Node\StopwatchNode($name, $body, new Node\Expression\AssignNameExpression($this->parser->getVarName(), $token->getLine()), $lineno, $this->getTag());
        }
        return $body;
    }
    public function decideStopwatchEnd(Token $token): bool {
        return $token->test('endstopwatch');
    }
    public function getTag(): string {
        return 'stopwatch';
    }
}
