<?php

declare (strict_types=1);
namespace RWP\Vendor\Doctrine\Inflector\Rules\Portuguese;

use RWP\Vendor\Doctrine\Inflector\Rules\Patterns;
use RWP\Vendor\Doctrine\Inflector\Rules\Ruleset;
use RWP\Vendor\Doctrine\Inflector\Rules\Substitutions;
use RWP\Vendor\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : Ruleset
    {
        return new Ruleset(new Transformations(...Rules\Portuguese\Inflectible::getSingular()), new Patterns(...Rules\Portuguese\Uninflected::getSingular()), (new Substitutions(...Rules\Portuguese\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : Ruleset
    {
        return new Ruleset(new Transformations(...Rules\Portuguese\Inflectible::getPlural()), new Patterns(...Rules\Portuguese\Uninflected::getPlural()), new Substitutions(...Rules\Portuguese\Inflectible::getIrregular()));
    }
}
