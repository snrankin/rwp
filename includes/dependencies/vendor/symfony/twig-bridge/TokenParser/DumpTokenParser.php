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

use RWP\Vendor\Symfony\Bridge\Twig\Node\DumpNode;
use RWP\Vendor\Twig\Node\Node;
use RWP\Vendor\Twig\Token;
use RWP\Vendor\Twig\TokenParser\AbstractTokenParser;

/**
 * Token Parser for the 'dump' tag.
 *
 * Dump variables with:
 *
 *     {% dump %}
 *     {% dump foo %}
 *     {% dump foo, bar %}
 *
 * @author Julien Galenski <julien.galenski@gmail.com>
 */
final class DumpTokenParser extends TokenParser\AbstractTokenParser {
    /**
     * {@inheritdoc}
     */
    public function parse(Token $token): Node\Node {
        $values = null;
        if (!$this->parser->getStream()->test(Token::BLOCK_END_TYPE)) {
            $values = $this->parser->getExpressionParser()->parseMultitargetExpression();
        }
        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);
        return new Bridge\Twig\Node\DumpNode($this->parser->getVarName(), $values, $token->getLine(), $this->getTag());
    }
    /**
     * {@inheritdoc}
     */
    public function getTag(): string {
        return 'dump';
    }
}
