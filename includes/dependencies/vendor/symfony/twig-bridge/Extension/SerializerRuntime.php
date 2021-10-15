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

use RWP\Vendor\Symfony\Component\Serializer\SerializerInterface;
use RWP\Vendor\Twig\Extension\RuntimeExtensionInterface;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
final class SerializerRuntime implements Extension\RuntimeExtensionInterface {
    private $serializer;
    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }
    public function serialize($data, string $format = 'json', array $context = []): string {
        return $this->serializer->serialize($data, $format, $context);
    }
}
