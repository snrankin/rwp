<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RWP\Vendor\Symfony\Component\VarDumper\Caster;

use RWP\Vendor\Ramsey\Uuid\UuidInterface;
use RWP\Vendor\Symfony\Component\VarDumper\Cloner\Stub;

/**
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
final class UuidCaster {
    public static function castRamseyUuid(Uuid\UuidInterface $c, array $a, Stub $stub, bool $isNested): array {
        $a += [Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'uuid' => (string) $c];
        return $a;
    }
}
