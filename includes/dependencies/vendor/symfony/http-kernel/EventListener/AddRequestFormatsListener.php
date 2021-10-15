<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RWP\Vendor\Symfony\Component\HttpKernel\EventListener;

use RWP\Vendor\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use RWP\Vendor\Symfony\Component\HttpKernel\Event\RequestEvent;
use RWP\Vendor\Symfony\Component\HttpKernel\KernelEvents;

/**
 * Adds configured formats to each request.
 *
 * @author Gildas Quemener <gildas.quemener@gmail.com>
 *
 * @final
 */
class AddRequestFormatsListener implements EventSubscriberInterface {
    protected $formats;
    public function __construct(array $formats) {
        $this->formats = $formats;
    }
    /**
     * Adds request formats.
     */
    public function onKernelRequest(RequestEvent $event) {
        $request = $event->getRequest();
        foreach ($this->formats as $format => $mimeTypes) {
            $request->setFormat($format, $mimeTypes);
        }
    }
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array {
        return [Component\HttpKernel\KernelEvents::REQUEST => ['onKernelRequest', 100]];
    }
}
