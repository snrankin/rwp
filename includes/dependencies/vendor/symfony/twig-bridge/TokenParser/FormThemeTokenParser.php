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

use RWP\Vendor\Symfony\Bridge\Twig\Node\FormThemeNode;
use RWP\Vendor\Twig\Node\Expression\ArrayExpression;
use RWP\Vendor\Twig\Node\Node;
use RWP\Vendor\Twig\Token;
use RWP\Vendor\Twig\TokenParser\AbstractTokenParser;

/**
 * Token Parser for the 'form_theme' tag.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class FormThemeTokenParser extends TokenParser\AbstractTokenParser {
    /**
     * {@inheritdoc}
     */
    public function parse(Token $token): Node\Node {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $form = $this->parser->getExpressionParser()->parseExpression();
        $only = \false;
        if ($this->parser->getStream()->test(Token::NAME_TYPE, 'with')) {
            $this->parser->getStream()->next();
            $resources = $this->parser->getExpressionParser()->parseExpression();
            if ($this->parser->getStream()->nextIf(Token::NAME_TYPE, 'only')) {
                $only = \true;
            }
        } else {
            $resources = new Node\Expression\ArrayExpression([], $stream->getCurrent()->getLine());
            do {
                $resources->addElement($this->parser->getExpressionParser()->parseExpression());
            } while (!$stream->test(Token::BLOCK_END_TYPE));
        }
        $stream->expect(Token::BLOCK_END_TYPE);
        return new Bridge\Twig\Node\FormThemeNode($form, $resources, $lineno, $this->getTag(), $only);
    }
    /**
     * {@inheritdoc}
     */
    public function getTag(): string {
        return 'form_theme';
    }
}
