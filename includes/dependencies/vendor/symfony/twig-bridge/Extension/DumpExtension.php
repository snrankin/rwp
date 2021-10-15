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

use RWP\Vendor\Symfony\Bridge\Twig\TokenParser\DumpTokenParser;
use RWP\Vendor\Symfony\Component\VarDumper\Cloner\ClonerInterface;
use RWP\Vendor\Symfony\Component\VarDumper\Dumper\HtmlDumper;
use RWP\Vendor\Twig\Environment;
use RWP\Vendor\Twig\Extension\AbstractExtension;
use RWP\Vendor\Twig\Template;
use RWP\Vendor\Twig\TwigFunction;

/**
 * Provides integration of the dump() function with Twig.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
final class DumpExtension extends Extension\AbstractExtension {
    private $cloner;
    private $dumper;
    public function __construct(ClonerInterface $cloner, HtmlDumper $dumper = null) {
        $this->cloner = $cloner;
        $this->dumper = $dumper;
    }
    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array {
        return [new TwigFunction('dump', [$this, 'dump'], ['is_safe' => ['html'], 'needs_context' => \true, 'needs_environment' => \true])];
    }
    /**
     * {@inheritdoc}
     */
    public function getTokenParsers(): array {
        return [new Bridge\Twig\TokenParser\DumpTokenParser()];
    }
    public function dump(Environment $env, array $context): ?string {
        if (!$env->isDebug()) {
            return null;
        }
        if (2 === \func_num_args()) {
            $vars = [];
            foreach ($context as $key => $value) {
                if (!$value instanceof Template) {
                    $vars[$key] = $value;
                }
            }
            $vars = [$vars];
        } else {
            $vars = \func_get_args();
            unset($vars[0], $vars[1]);
        }
        $dump = \fopen('php://memory', 'r+');
        $this->dumper = $this->dumper ?? new HtmlDumper();
        $this->dumper->setCharset($env->getCharset());
        foreach ($vars as $value) {
            $this->dumper->dump($this->cloner->cloneVar($value), $dump);
        }
        return \stream_get_contents($dump, -1, 0);
    }
}
