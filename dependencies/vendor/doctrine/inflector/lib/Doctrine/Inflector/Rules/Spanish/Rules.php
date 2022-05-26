<?php

declare (strict_types=1);
namespace RWP\Vendor\Doctrine\Inflector\Rules\Spanish;

use RWP\Vendor\Doctrine\Inflector\Rules\Patterns;
use RWP\Vendor\Doctrine\Inflector\Rules\Ruleset;
use RWP\Vendor\Doctrine\Inflector\Rules\Substitutions;
use RWP\Vendor\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : Ruleset
    {
        return new Ruleset(new Transformations(...Rules\Spanish\Inflectible::getSingular()), new Patterns(...Rules\Spanish\Uninflected::getSingular()), (new Substitutions(...Rules\Spanish\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : Ruleset
    {
        return new Ruleset(new Transformations(...Rules\Spanish\Inflectible::getPlural()), new Patterns(...Rules\Spanish\Uninflected::getPlural()), new Substitutions(...Rules\Spanish\Inflectible::getIrregular()));
    }
}
