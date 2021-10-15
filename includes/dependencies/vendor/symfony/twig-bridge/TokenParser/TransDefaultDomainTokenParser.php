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

use RWP\Vendor\Symfony\Bridge\Twig\Node\TransDefaultDomainNode;
use RWP\Vendor\Twig\Node\Node;
use RWP\Vendor\Twig\Token;
use RWP\Vendor\Twig\TokenParser\AbstractTokenParser;

/**
 * Token Parser for the 'trans_default_domain' tag.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class TransDefaultDomainTokenParser extends TokenParser\AbstractTokenParser {
    /**
     * {@inheritdoc}
     */
    public function parse(Token $token): Node\Node {
        $expr = $this->parser->getExpressionParser()->parseExpression();
        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);
        return new Bridge\Twig\Node\TransDefaultDomainNode($expr, $token->getLine(), $this->getTag());
    }
    /**
     * {@inheritdoc}
     */
    public function getTag(): string {
        return 'trans_default_domain';
    }
}
