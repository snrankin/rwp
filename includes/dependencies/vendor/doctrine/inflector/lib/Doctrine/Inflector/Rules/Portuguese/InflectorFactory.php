<?php

declare (strict_types=1);
namespace RWP\Vendor\Doctrine\Inflector\Rules\Portuguese;

use RWP\Vendor\Doctrine\Inflector\GenericLanguageInflectorFactory;
use RWP\Vendor\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : Ruleset
    {
        return Portuguese\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : Ruleset
    {
        return Portuguese\Rules::getPluralRuleset();
    }
}
