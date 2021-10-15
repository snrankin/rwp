<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RWP\Vendor\Symfony\Bridge\Twig\Extension;

use RWP\Vendor\Symfony\Bridge\Twig\NodeVisitor\TranslationDefaultDomainNodeVisitor;
use RWP\Vendor\Symfony\Bridge\Twig\NodeVisitor\TranslationNodeVisitor;
use RWP\Vendor\Symfony\Bridge\Twig\TokenParser\TransDefaultDomainTokenParser;
use RWP\Vendor\Symfony\Bridge\Twig\TokenParser\TransTokenParser;
use RWP\Vendor\Symfony\Component\Translation\TranslatableMessage;
use RWP\Vendor\Symfony\Contracts\Translation\TranslatableInterface;
use RWP\Vendor\Symfony\Contracts\Translation\TranslatorInterface;
use RWP\Vendor\Symfony\Contracts\Translation\TranslatorTrait;
use RWP\Vendor\Twig\Extension\AbstractExtension;
use RWP\Vendor\Twig\TwigFilter;
use RWP\Vendor\Twig\TwigFunction;
// Help opcache.preload discover always-needed symbols
\class_exists(Contracts\Translation\TranslatorInterface::class);
\class_exists(Contracts\Translation\TranslatorTrait::class);
/**
 * Provides integration of the Translation component with Twig.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class TranslationExtension extends Extension\AbstractExtension {
    private $translator;
    private $translationNodeVisitor;
    public function __construct(Contracts\Translation\TranslatorInterface $translator = null, Bridge\Twig\NodeVisitor\TranslationNodeVisitor $translationNodeVisitor = null) {
        $this->translator = $translator;
        $this->translationNodeVisitor = $translationNodeVisitor;
    }
    public function getTranslator(): Contracts\Translation\TranslatorInterface {
        if (null === $this->translator) {
            if (!\interface_exists(Contracts\Translation\TranslatorInterface::class)) {
                throw new \LogicException(\sprintf('You cannot use the "%s" if the Translation Contracts are not available. Try running "composer require symfony/translation".', __CLASS__));
            }
            $this->translator = new class implements Contracts\Translation\TranslatorInterface {
                use TranslatorTrait;
            };
        }
        return $this->translator;
    }
    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array {
        return [new TwigFunction('t', [$this, 'createTranslatable'])];
    }
    /**
     * {@inheritdoc}
     */
    public function getFilters(): array {
        return [new TwigFilter('trans', [$this, 'trans'])];
    }
    /**
     * {@inheritdoc}
     */
    public function getTokenParsers(): array {
        return [
            // {% trans %}Symfony is great!{% endtrans %}
            new Bridge\Twig\TokenParser\TransTokenParser(),
            // {% trans_default_domain "foobar" %}
            new Bridge\Twig\TokenParser\TransDefaultDomainTokenParser(),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function getNodeVisitors(): array {
        return [$this->getTranslationNodeVisitor(), new Bridge\Twig\NodeVisitor\TranslationDefaultDomainNodeVisitor()];
    }
    public function getTranslationNodeVisitor(): Bridge\Twig\NodeVisitor\TranslationNodeVisitor {
        return $this->translationNodeVisitor ?: ($this->translationNodeVisitor = new Bridge\Twig\NodeVisitor\TranslationNodeVisitor());
    }
    /**
     * @param string|\Stringable|TranslatableInterface|null $message
     * @param array|string                                  $arguments Can be the locale as a string when $message is a TranslatableInterface
     */
    public function trans($message, $arguments = [], string $domain = null, string $locale = null, int $count = null): string {
        if ($message instanceof Contracts\Translation\TranslatableInterface) {
            if ([] !== $arguments && !\is_string($arguments)) {
                throw new \TypeError(\sprintf('Argument 2 passed to "%s()" must be a locale passed as a string when the message is a "%s", "%s" given.', __METHOD__, Contracts\Translation\TranslatableInterface::class, \get_debug_type($arguments)));
            }
            return $message->trans($this->getTranslator(), $locale ?? (\is_string($arguments) ? $arguments : null));
        }
        if (!\is_array($arguments)) {
            throw new \TypeError(\sprintf('Unless the message is a "%s", argument 2 passed to "%s()" must be an array of parameters, "%s" given.', Contracts\Translation\TranslatableInterface::class, __METHOD__, \get_debug_type($arguments)));
        }
        if ('' === ($message = (string) $message)) {
            return '';
        }
        if (null !== $count) {
            $arguments['%count%'] = $count;
        }
        return $this->getTranslator()->trans($message, $arguments, $domain, $locale);
    }
    public function createTranslatable(string $message, array $parameters = [], string $domain = null): TranslatableMessage {
        if (!\class_exists(TranslatableMessage::class)) {
            throw new \LogicException(\sprintf('You cannot use the "%s" as the Translation Component is not installed. Try running "composer require symfony/translation".', __CLASS__));
        }
        return new TranslatableMessage($message, $parameters, $domain);
    }
}
