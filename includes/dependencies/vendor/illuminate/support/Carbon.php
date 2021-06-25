<?php

namespace RWP\Vendor\Illuminate\Support;

use RWP\Vendor\Carbon\Carbon as BaseCarbon;
use RWP\Vendor\Carbon\CarbonImmutable as BaseCarbonImmutable;
class Carbon extends Carbon
{
    /**
     * {@inheritdoc}
     */
    public static function setTestNow($testNow = null)
    {
        Carbon::setTestNow($testNow);
        CarbonImmutable::setTestNow($testNow);
    }
}
