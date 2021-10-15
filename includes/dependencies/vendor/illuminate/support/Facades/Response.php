<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

use RWP\Vendor\Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;

/**
 * @method staticJsonResponse json(string|array $data = [], int $status = 200, array $headers = [], int $options = 0)
 * @method staticJsonResponse jsonp(string $callback, string|array $data = [], int $status = 200, array $headers = [], int $options = 0)
 * @method staticRedirectResponse redirectGuest(string $path, int $status = 302, array $headers = [], bool|null $secure = null)
 * @method staticRedirectResponse redirectTo(string $path, int $status = 302, array $headers = [], bool|null $secure = null)
 * @method staticRedirectResponse redirectToAction(string $action, mixed $parameters = [], int $status = 302, array $headers = [])
 * @method staticRedirectResponse redirectToIntended(string $default = '/', int $status = 302, array $headers = [], bool|null $secure = null)
 * @method staticRedirectResponse redirectToRoute(string $route, mixed $parameters = [], int $status = 302, array $headers = [])
 * @method staticResponse make(string $content = '', int $status = 200, array $headers = [])
 * @method staticResponse noContent($status = 204, array $headers = [])
 * @method staticResponse view(string $view, array $data = [], int $status = 200, array $headers = [])
 * @method static \RWP\Vendor\Symfony\HttpFoundation\BinaryFileResponse download(\SplFileInfo|string $file, string|null $name = null, array $headers = [], string|null $disposition = 'attachment')
 * @method static \RWP\Vendor\Symfony\HttpFoundation\BinaryFileResponse file($file, array $headers = [])
 * @method static \RWP\Vendor\Symfony\HttpFoundation\StreamedResponse stream(\Closure $callback, int $status = 200, array $headers = [])
 * @method static \RWP\Vendor\Symfony\HttpFoundation\StreamedResponse streamDownload(\Closure $callback, string|null $name = null, array $headers = [], string|null $disposition = 'attachment')
 *
 * @seeResponseFactory
 */
class Response extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return ResponseFactory::class;
    }
}
