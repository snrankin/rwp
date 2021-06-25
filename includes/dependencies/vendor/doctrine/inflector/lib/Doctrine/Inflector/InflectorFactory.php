<?php

declare (strict_types=1);
namespace RWP\Vendor\Doctrine\Inflector;

use RWP\Vendor\Doctrine\Inflector\Rules\English;
use RWP\Vendor\Doctrine\Inflector\Rules\French;
use RWP\Vendor\Doctrine\Inflector\Rules\NorwegianBokmal;
use RWP\Vendor\Doctrine\Inflector\Rules\Portuguese;
use RWP\Vendor\Doctrine\Inflector\Rules\Spanish;
use RWP\Vendor\Doctrine\Inflector\Rules\Turkish;
use InvalidArgumentException;
use function sprintf;
final class InflectorFactory
{
    public static function create() : LanguageInflectorFactory
    {
        return self::createForLanguage(Language::ENGLISH);
    }
    public static function createForLanguage(string $language) : LanguageInflectorFactory
    {
        switch ($language) {
            case Language::ENGLISH:
                return new InflectorFactory();
            case Language::FRENCH:
                return new InflectorFactory();
            case Language::NORWEGIAN_BOKMAL:
                return new InflectorFactory();
            case Language::PORTUGUESE:
                return new InflectorFactory();
            case Language::SPANISH:
                return new InflectorFactory();
            case Language::TURKISH:
                return new InflectorFactory();
            default:
                throw new \InvalidArgumentException(\sprintf('Language "%s" is not supported.', $language));
        }
    }
}
