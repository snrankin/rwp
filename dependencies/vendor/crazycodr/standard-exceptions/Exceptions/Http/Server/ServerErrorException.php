<?php

namespace RWP\Vendor\Exceptions\Http\Server;

use RWP\Vendor\Exceptions\Http\HttpException;
use RWP\Vendor\Exceptions\Tag\AbortedTag;
/**
 * All server error http exceptions extend this class and save you the trouble of setting up the method that returns
 * the error class code.
 */
abstract class ServerErrorException extends HttpException implements ServerErrorExceptionInterface, AbortedTag
{
    /**
     * {@inheritdoc}
     */
    public static function getHttpCodeClass()
    {
        return self::CODE_CLASS_SERVER_ERROR;
    }
}
