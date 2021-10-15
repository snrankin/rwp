<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RWP\Vendor\Symfony\Bridge\Twig\Mime;

use RWP\Vendor\League\HTMLToMarkdown\HtmlConverter;
use RWP\Vendor\Symfony\Component\Mime\BodyRendererInterface;
use RWP\Vendor\Symfony\Component\Mime\Exception\InvalidArgumentException;
use RWP\Vendor\Symfony\Component\Mime\Message;
use RWP\Vendor\Twig\Environment;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class BodyRenderer implements BodyRendererInterface {
    private $twig;
    private $context;
    private $converter;
    public function __construct(Environment $twig, array $context = []) {
        $this->twig = $twig;
        $this->context = $context;
        if (\class_exists(HTMLToMarkdown\HtmlConverter::class)) {
            $this->converter = new HTMLToMarkdown\HtmlConverter(['hard_break' => \true, 'strip_tags' => \true, 'remove_nodes' => 'head style']);
        }
    }
    public function render(Message $message): void {
        if (!$message instanceof Bridge\Twig\Mime\TemplatedEmail) {
            return;
        }
        $messageContext = $message->getContext();
        $previousRenderingKey = $messageContext[__CLASS__] ?? null;
        unset($messageContext[__CLASS__]);
        $currentRenderingKey = $this->getFingerPrint($message);
        if ($previousRenderingKey === $currentRenderingKey) {
            return;
        }
        if (isset($messageContext['email'])) {
            throw new InvalidArgumentException(\sprintf('A "%s" context cannot have an "email" entry as this is a reserved variable.', \get_debug_type($message)));
        }
        $vars = \array_merge($this->context, $messageContext, ['email' => new Bridge\Twig\Mime\WrappedTemplatedEmail($this->twig, $message)]);
        if ($template = $message->getTextTemplate()) {
            $message->text($this->twig->render($template, $vars));
        }
        if ($template = $message->getHtmlTemplate()) {
            $message->html($this->twig->render($template, $vars));
        }
        // if text body is empty, compute one from the HTML body
        if (!$message->getTextBody() && null !== ($html = $message->getHtmlBody())) {
            $message->text($this->convertHtmlToText(\is_resource($html) ? \stream_get_contents($html) : $html));
        }
        $message->context($message->getContext() + [__CLASS__ => $currentRenderingKey]);
    }
    private function getFingerPrint(Bridge\Twig\Mime\TemplatedEmail $message): string {
        $messageContext = $message->getContext();
        unset($messageContext[__CLASS__]);
        $payload = [$messageContext, $message->getTextTemplate(), $message->getHtmlTemplate()];
        try {
            $serialized = \serialize($payload);
        } catch (\Exception $e) {
            // Serialization of 'Closure' is not allowed
            // Happens when context contain a closure, in that case, we assume that context always change.
            $serialized = \random_bytes(8);
        }
        return \md5($serialized);
    }
    private function convertHtmlToText(string $html): string {
        if (null !== $this->converter) {
            return $this->converter->convert($html);
        }
        return \strip_tags(\preg_replace('{<(head|style)\\b.*?</\\1>}is', '', $html));
    }
}
