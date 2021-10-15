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

use RWP\Vendor\Symfony\Component\Stopwatch\Stopwatch;
use RWP\Vendor\Twig\Extension\ProfilerExtension as BaseProfilerExtension;
use RWP\Vendor\Twig\Profiler\Profile;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class ProfilerExtension extends Extension\ProfilerExtension {
    private $stopwatch;
    private $events;
    public function __construct(Profiler\Profile $profile, Stopwatch $stopwatch = null) {
        parent::__construct($profile);
        $this->stopwatch = $stopwatch;
        $this->events = new \SplObjectStorage();
    }
    public function enter(Profiler\Profile $profile): void {
        if ($this->stopwatch && $profile->isTemplate()) {
            $this->events[$profile] = $this->stopwatch->start($profile->getName(), 'template');
        }
        parent::enter($profile);
    }
    public function leave(Profiler\Profile $profile): void {
        parent::leave($profile);
        if ($this->stopwatch && $profile->isTemplate()) {
            $this->events[$profile]->stop();
            unset($this->events[$profile]);
        }
    }
}
