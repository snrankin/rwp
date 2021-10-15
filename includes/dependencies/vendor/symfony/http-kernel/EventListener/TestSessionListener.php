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

/**
 * Sets the session in the request.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class TestSessionListener extends AbstractTestSessionListener {
    private $container;
    public function __construct(Container\ContainerInterface $container, array $sessionOptions = []) {
        $this->container = $container;
        parent::__construct($sessionOptions);
    }
    protected function getSession(): ?Component\HttpFoundation\Session\SessionInterface {
        if (!$this->container->has('session')) {
            return null;
        }
        return $this->container->get('session');
    }
}
