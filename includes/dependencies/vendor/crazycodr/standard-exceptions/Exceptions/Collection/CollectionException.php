<?php

namespace RWP\Vendor\Exceptions\Collection;

use RWP\Vendor\Exceptions\Helpers\DefaultConstructorTrait;
use RWP\Vendor\Exceptions\Helpers\DefaultsInterface;
use RWP\Vendor\Exceptions\Helpers\FromException;
use RWP\Vendor\Exceptions\Helpers\WithContext;
/**
 * This is a tag like class that is used to regroup all Collection exceptions under a single base class.
 *
 * @author   Mathieu Dumoulin <thecrazycodr@gmail.com>
 * @license  MIT
 */
abstract class CollectionException extends \RuntimeException implements CollectionExceptionInterface, DefaultsInterface
{
    use FromException, DefaultConstructorTrait, WithContext;
    /**
     * {@inheritdoc}
     */
    public static function getDefaultMessage() : string
    {
        return static::MESSAGE;
    }
    /**
     * {@inheritdoc}
     */
    public static function getDefaultCode() : int
    {
        return static::CODE;
    }
}
