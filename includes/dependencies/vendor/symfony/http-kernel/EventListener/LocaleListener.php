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
use RWP\Vendor\Symfony\Component\HttpFoundation\Request;
use RWP\Vendor\Symfony\Component\HttpFoundation\RequestStack;
use RWP\Vendor\Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use RWP\Vendor\Symfony\Component\HttpKernel\Event\KernelEvent;
use RWP\Vendor\Symfony\Component\HttpKernel\Event\RequestEvent;
use RWP\Vendor\Symfony\Component\HttpKernel\KernelEvents;
use RWP\Vendor\Symfony\Component\Routing\RequestContextAwareInterface;

/**
 * Initializes the locale based on the current request.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class LocaleListener implements EventSubscriberInterface {
    private $router;
    private $defaultLocale;
    private $requestStack;
    public function __construct(RequestStack $requestStack, string $defaultLocale = 'en', RequestContextAwareInterface $router = null) {
        $this->defaultLocale = $defaultLocale;
        $this->requestStack = $requestStack;
        $this->router = $router;
    }
    public function setDefaultLocale(KernelEvent $event) {
        $event->getRequest()->setDefaultLocale($this->defaultLocale);
    }
    public function onKernelRequest(RequestEvent $event) {
        $request = $event->getRequest();
        $this->setLocale($request);
        $this->setRouterContext($request);
    }
    public function onKernelFinishRequest(FinishRequestEvent $event) {
        if (null !== ($parentRequest = $this->requestStack->getParentRequest())) {
            $this->setRouterContext($parentRequest);
        }
    }
    private function setLocale(Request $request) {
        if ($locale = $request->attributes->get('_locale')) {
            $request->setLocale($locale);
        }
    }
    private function setRouterContext(Request $request) {
        if (null !== $this->router) {
            $this->router->getContext()->setParameter('_locale', $request->getLocale());
        }
    }
    public static function getSubscribedEvents(): array {
        return [Component\HttpKernel\KernelEvents::REQUEST => [
            ['setDefaultLocale', 100],
            // must be registered after the Router to have access to the _locale
            ['onKernelRequest', 16],
        ], KernelEvents::FINISH_REQUEST => [['onKernelFinishRequest', 0]]];
    }
}
