<?php

namespace RWP\Vendor\Exceptions\Http\Client;

use RWP\Vendor\Exceptions\Http\HttpException;
use RWP\Vendor\Exceptions\Tag\AbortedTag;
/**
 * This is a tag like class that is used to regroup all Http/Client exceptions under a single base class.
 *
 * Never throw an exception at the user, always catch it can synthesize it to a correct html response with
 * appropriate headers. You can use the constants and accessor to get HTML values to return.
 */
abstract class ClientErrorException extends HttpException implements ClientErrorExceptionInterface, AbortedTag
{
    /**
     * {@inheritdoc}
     */
    public static function getHttpCodeClass()
    {
        return self::CODE_CLASS_CLIENT_ERROR;
    }
}
