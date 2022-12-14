<?php

declare (strict_types=1);
namespace RWP\Vendor\Doctrine\Inflector\Rules\NorwegianBokmal;

use RWP\Vendor\Doctrine\Inflector\Rules\Patterns;
use RWP\Vendor\Doctrine\Inflector\Rules\Ruleset;
use RWP\Vendor\Doctrine\Inflector\Rules\Substitutions;
use RWP\Vendor\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : Ruleset
    {
        return new Ruleset(new Transformations(...Rules\NorwegianBokmal\Inflectible::getSingular()), new Patterns(...Rules\NorwegianBokmal\Uninflected::getSingular()), (new Substitutions(...Rules\NorwegianBokmal\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : Ruleset
    {
        return new Ruleset(new Transformations(...Rules\NorwegianBokmal\Inflectible::getPlural()), new Patterns(...Rules\NorwegianBokmal\Uninflected::getPlural()), new Substitutions(...Rules\NorwegianBokmal\Inflectible::getIrregular()));
    }
}
