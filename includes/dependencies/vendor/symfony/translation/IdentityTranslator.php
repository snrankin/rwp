<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RWP\Vendor\Symfony\Component\Translation;

use RWP\Vendor\Symfony\Contracts\Translation\LocaleAwareInterface;
use RWP\Vendor\Symfony\Contracts\Translation\TranslatorInterface;
use RWP\Vendor\Symfony\Contracts\Translation\TranslatorTrait;

/**
 * IdentityTranslator does not translate anything.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class IdentityTranslator implements Contracts\Translation\TranslatorInterface, Contracts\Translation\LocaleAwareInterface {
    use TranslatorTrait;
}
