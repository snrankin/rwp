<?php

/**
 * Thanks to https://github.com/flaushi for his suggestion:
 * https://github.com/doctrine/dbal/issues/2873#issuecomment-534956358
 */
namespace RWP\Vendor\Carbon\Doctrine;

use RWP\Vendor\Carbon\CarbonImmutable;
use RWP\Vendor\Doctrine\DBAL\Types\VarDateTimeImmutableType;
class DateTimeImmutableType extends VarDateTimeImmutableType implements CarbonDoctrineType
{
    use CarbonTypeConverter;
    protected function getCarbonClassName() : string
    {
        return CarbonImmutable::class;
    }
}
