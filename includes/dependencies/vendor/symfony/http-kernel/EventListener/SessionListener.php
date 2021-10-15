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

use RWP\Vendor\Psr\Container\ContainerInterface;
use RWP\Vendor\Symfony\Component\HttpFoundation\Session\SessionInterface;
use RWP\Vendor\Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use RWP\Vendor\Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Sets the session in the request.
 *
 * When the passed container contains a "session_storage" entry which
 * holds a NativeSessionStorage instance, the "cookie_secure" option
 * will be set to true whenever the current main request is secure.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class SessionListener extends AbstractSessionListener {
    public function __construct(Container\ContainerInterface $container, bool $debug = \false) {
        parent::__construct($container, $debug);
    }
    public function onKernelRequest(RequestEvent $event) {
        parent::onKernelRequest($event);
        if (!$event->isMainRequest() || !$this->container->has('session')) {
            return;
        }
        if ($this->container->has('session_storage') && ($storage = $this->container->get('session_storage')) instanceof NativeSessionStorage && ($mainRequest = $this->container->get('request_stack')->getMainRequest()) && $mainRequest->isSecure()) {
            $storage->setOptions(['cookie_secure' => \true]);
        }
    }
    protected function getSession(): ?Component\HttpFoundation\Session\SessionInterface {
        if (!$this->container->has('session')) {
            return null;
        }
        return $this->container->get('session');
    }
}
