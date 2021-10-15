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

use RWP\Vendor\Imagine\Image\ImageInterface;
use RWP\Vendor\Symfony\Component\VarDumper\Cloner\Stub;

/**
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
final class ImagineCaster {
    public static function castImage(Image\ImageInterface $c, array $a, Stub $stub, bool $isNested): array {
        $imgData = $c->get('png');
        if (\strlen($imgData) > 1 * 1000 * 1000) {
            $a += [Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'image' => new ConstStub($c->getSize())];
        } else {
            $a += [Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'image' => new ImgStub($imgData, 'image/png', $c->getSize())];
        }
        return $a;
    }
}
