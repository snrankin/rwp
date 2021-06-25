<?php

declare (strict_types=1);
namespace RWP\Vendor\Doctrine\Inflector\Rules\French;

use RWP\Vendor\Doctrine\Inflector\GenericLanguageInflectorFactory;
use RWP\Vendor\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : Ruleset
    {
        return Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : Ruleset
    {
        return Rules::getPluralRuleset();
    }
}
