<?php

declare (strict_types=1);
namespace RWP\Vendor\Doctrine\Inflector\Rules\Turkish;

use RWP\Vendor\Doctrine\Inflector\Rules\Patterns;
use RWP\Vendor\Doctrine\Inflector\Rules\Ruleset;
use RWP\Vendor\Doctrine\Inflector\Rules\Substitutions;
use RWP\Vendor\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : Ruleset
    {
        return new Ruleset(new Transformations(...Rules\Turkish\Inflectible::getSingular()), new Patterns(...Rules\Turkish\Uninflected::getSingular()), (new Substitutions(...Rules\Turkish\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : Ruleset
    {
        return new Ruleset(new Transformations(...Rules\Turkish\Inflectible::getPlural()), new Patterns(...Rules\Turkish\Uninflected::getPlural()), new Substitutions(...Rules\Turkish\Inflectible::getIrregular()));
    }
}
