<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RWP\Vendor\Twig\TokenParser;

use RWP\Vendor\Twig\Error\SyntaxError;
use RWP\Vendor\Twig\Node\AutoEscapeNode;
use RWP\Vendor\Twig\Node\Expression\ConstantExpression;
use RWP\Vendor\Twig\Node\Node;
use RWP\Vendor\Twig\Token;
/**
 * Marks a section of a template to be escaped or not.
 *
 * @internal
 */
final class AutoEscapeTokenParser extends AbstractTokenParser
{
    public function parse(Token $token) : Node
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        if ($stream->test(
            /* Token::BLOCK_END_TYPE */
            3
        )) {
            $value = 'html';
        } else {
            $expr = $this->parser->getExpressionParser()->parseExpression();
            if (!$expr instanceof ConstantExpression) {
                throw new SyntaxError('An escaping strategy must be a string or false.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
            }
            $value = $expr->getAttribute('value');
        }
        $stream->expect(
            /* Token::BLOCK_END_TYPE */
            3
        );
        $body = $this->parser->subparse([$this, 'decideBlockEnd'], \true);
        $stream->expect(
            /* Token::BLOCK_END_TYPE */
            3
        );
        return new AutoEscapeNode($value, $body, $lineno, $this->getTag());
    }
    public function decideBlockEnd(Token $token) : bool
    {
        return $token->test('endautoescape');
    }
    public function getTag() : string
    {
        return 'autoescape';
    }
}
