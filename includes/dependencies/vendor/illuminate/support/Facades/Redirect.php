<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

/**
 * @method static RedirectResponse action(string $action, array $parameters = [], int $status = 302, array $headers = [])
 * @method static RedirectResponse away(string $path, int $status = 302, array $headers = [])
 * @method static RedirectResponse back(int $status = 302, array $headers = [], $fallback = false)
 * @method static RedirectResponse guest(string $path, int $status = 302, array $headers = [], bool $secure = null)
 * @method static RedirectResponse home(int $status = 302)
 * @method static RedirectResponse intended(string $default = '/', int $status = 302, array $headers = [], bool $secure = null)
 * @method static RedirectResponse refresh(int $status = 302, array $headers = [])
 * @method static RedirectResponse route(string $route, array $parameters = [], int $status = 302, array $headers = [])
 * @method static RedirectResponse secure(string $path, int $status = 302, array $headers = [])
 * @method static RedirectResponse signedRoute(string $name, array $parameters = [], \DateTimeInterface|\DateInterval|int $expiration = null, int $status = 302, array $headers = [])
 * @method static RedirectResponse temporarySignedRoute(string $name, \DateTimeInterface|\DateInterval|int $expiration, array $parameters = [], int $status = 302, array $headers = [])
 * @method static RedirectResponse to(string $path, int $status = 302, array $headers = [], bool $secure = null)
 * @method static UrlGenerator getUrlGenerator()
 * @method static void setSession(\Illuminate\Session\Store $session)
 * @method static void setIntendedUrl(string $url)
 *
 * @see Redirector
 */
class Redirect extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'redirect';
    }
}
