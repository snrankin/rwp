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

use RWP\Vendor\Symfony\Bridge\Twig\TokenParser\StopwatchTokenParser;
use RWP\Vendor\Symfony\Component\Stopwatch\Stopwatch;
use RWP\Vendor\Twig\Extension\AbstractExtension;
use RWP\Vendor\Twig\TokenParser\TokenParserInterface;

/**
 * Twig extension for the stopwatch helper.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
final class StopwatchExtension extends Extension\AbstractExtension {
    private $stopwatch;
    private $enabled;
    public function __construct(Stopwatch $stopwatch = null, bool $enabled = \true) {
        $this->stopwatch = $stopwatch;
        $this->enabled = $enabled;
    }
    public function getStopwatch(): Stopwatch {
        return $this->stopwatch;
    }
    /**
     * @return TokenParserInterface[]
     */
    public function getTokenParsers(): array {
        return [
            /*
             * {% stopwatch foo %}
             * Some stuff which will be recorded on the timeline
             * {% endstopwatch %}
             */
            new Bridge\Twig\TokenParser\StopwatchTokenParser(null !== $this->stopwatch && $this->enabled),
        ];
    }
}
