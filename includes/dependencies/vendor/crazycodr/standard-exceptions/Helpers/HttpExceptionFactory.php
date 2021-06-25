<?php

namespace RWP\Vendor\Exceptions\Helpers;

use RWP\Vendor\Exceptions\Data\ValidationException;
use RWP\Vendor\Exceptions\Http\Client;
use RWP\Vendor\Exceptions\Http\HttpExceptionInterface;
use RWP\Vendor\Exceptions\Http\Server;
use Throwable;
class HttpExceptionFactory
{
    protected static $mapping = [
		400 => BadRequestException::class,
		401 => UnauthorizedException::class,
		402 => PaymentRequiredException::class,
		403 => ForbiddenException::class,
		404 => NotFoundException::class,
		405 => MethodNotAllowedException::class,
		406 => NotAcceptableException::class,
		407 => ProxyAuthorizationRequiredException::class,
		408 => RequestTimeoutException::class,
		409 => ConflictException::class,
		410 => GoneException::class,
		411 => LengthRequiredException::class,
		412 => PreConditionRequiredException::class,
		413 => PayloadTooLargeException::class,
		414 => URITooLongException::class,
		415 => UnsupportedMediaTypeException::class,
		416 => RangeNotSatisfiableException::class,
		417 => ExpectationFailedException::class,
		418 => ImATeapotException::class,
		421 => MisdirectedRequestException::class,
		422 => UnprocessableEntityException::class,
		423 => LockedException::class,
		424 => FailedDependencyException::class,
		426 => UpgradeRequiredException::class,
		428 => PreConditionRequiredException::class,
		429 => TooManyRequestsException::class,
		431 => RequestHeaderFieldsTooLargeException::class,
		451 => UnavailableForLegalReasonsException::class,
		456 => UnrecoverableErrorException::class,
		500 => InternalServerErrorException::class,
		501 => NotImplementedException::class,
		502 => BadGatewayException::class,
		503 => ServiceUnavailableException::class,
		504 => GatewayTimeoutException::class,
		505 => HttpVersionNotSupportedException::class,
		507 => InsuficientStorageException::class,
		508 => LoopDetectedException::class
	];
    /**
     * @param int $responseCode
     * @param string|null $message
     * @param Throwable|null $ex
     * @return HttpExceptionInterface
     *
     * @throws ValidationException When {$responseCode} can't be mapped to an HttpException
     */
    public static function build(int $responseCode,  string $message = '', \Throwable $ex = null) : HttpExceptionInterface
    {
        $mapping = static::getMapping();
        if (!\array_key_exists($responseCode, $mapping)) {
            throw new ValidationException('Unknown mapping for response code ' . $responseCode);
        }
        return new $mapping[$responseCode]($message, $responseCode, $ex);
    }
    /**
     * @param int $responseCode
     * @param mixed $context mixed data you can attach to the exception
     * @param string|null $message
     * @param Throwable|null $ex [optional] The previous throwable used for the exception chaining.
     * @return HttpExceptionInterface
     *
     * @throws ValidationException When {$responseCode} can't be mapped to an HttpException
     */
    public static function buildWithContext(int $responseCode, $context, string $message = '', \Throwable $ex = null) : HttpExceptionInterface
    {
        $mapping = static::getMapping();
        if (!\array_key_exists($responseCode, $mapping)) {
            throw new ValidationException('Unknown mapping for response code ' . $responseCode);
        }
        return $mapping[$responseCode]::withContext($context, $message, $responseCode, $ex);
    }
    /**
     * @return array Map between a an Error code (as key) and a Class name (as value)
     */
    protected static function getMapping() : array
    {
        return static::$mapping;
    }
}
