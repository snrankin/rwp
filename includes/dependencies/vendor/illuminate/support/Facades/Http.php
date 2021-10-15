<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

use RWP\Vendor\Illuminate\Http\Client\Factory;

/**
 * @method static \GuzzleHttp\Promise\PromiseInterface response($body = null, $status = 200, $headers = [])
 * @method staticFactory fake($callback = null)
 * @method staticPendingRequest accept(string $contentType)
 * @method staticPendingRequest acceptJson()
 * @method staticPendingRequest asForm()
 * @method staticPendingRequest asJson()
 * @method staticPendingRequest asMultipart()
 * @method staticPendingRequest async()
 * @method staticPendingRequest attach(string|array $name, string $contents = '', string|null $filename = null, array $headers = [])
 * @method staticPendingRequest baseUrl(string $url)
 * @method staticPendingRequest beforeSending(callable $callback)
 * @method staticPendingRequest bodyFormat(string $format)
 * @method staticPendingRequest contentType(string $contentType)
 * @method staticPendingRequest dd()
 * @method staticPendingRequest dump()
 * @method staticPendingRequest retry(int $times, int $sleep = 0, ?callable $when = null)
 * @method staticPendingRequest sink(string|resource $to)
 * @method staticPendingRequest stub(callable $callback)
 * @method staticPendingRequest timeout(int $seconds)
 * @method staticPendingRequest withBasicAuth(string $username, string $password)
 * @method staticPendingRequest withBody(resource|string $content, string $contentType)
 * @method staticPendingRequest withCookies(array $cookies, string $domain)
 * @method staticPendingRequest withDigestAuth(string $username, string $password)
 * @method staticPendingRequest withHeaders(array $headers)
 * @method staticPendingRequest withMiddleware(callable $middleware)
 * @method staticPendingRequest withOptions(array $options)
 * @method staticPendingRequest withToken(string $token, string $type = 'Bearer')
 * @method staticPendingRequest withUserAgent(string $userAgent)
 * @method staticPendingRequest withoutRedirecting()
 * @method staticPendingRequest withoutVerifying()
 * @method static array pool(callable $callback)
 * @method staticResponse delete(string $url, array $data = [])
 * @method staticResponse get(string $url, array|string|null $query = null)
 * @method staticResponse head(string $url, array|string|null $query = null)
 * @method staticResponse patch(string $url, array $data = [])
 * @method staticResponse post(string $url, array $data = [])
 * @method staticResponse put(string $url, array $data = [])
 * @method staticResponse send(string $method, string $url, array $options = [])
 * @method staticResponseSequence fakeSequence(string $urlPattern = '*')
 * @method static void assertSent(callable $callback)
 * @method static void assertSentInOrder(array $callbacks)
 * @method static void assertNotSent(callable $callback)
 * @method static void assertNothingSent()
 * @method static void assertSentCount(int $count)
 * @method static void assertSequencesAreEmpty()
 *
 * @seeFactory
 */
class Http extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return Factory::class;
    }
}
