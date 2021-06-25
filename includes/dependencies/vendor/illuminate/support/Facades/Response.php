<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

use RWP\Vendor\Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;

/**
 * @method static JsonResponse json(string|array $data = [], int $status = 200, array $headers = [], int $options = 0)
 * @method static JsonResponse jsonp(string $callback, string|array $data = [], int $status = 200, array $headers = [], int $options = 0)
 * @method static RedirectResponse redirectGuest(string $path, int $status = 302, array $headers = [], bool|null $secure = null)
 * @method static RedirectResponse redirectTo(string $path, int $status = 302, array $headers = [], bool|null $secure = null)
 * @method static RedirectResponse redirectToAction(string $action, mixed $parameters = [], int $status = 302, array $headers = [])
 * @method static RedirectResponse redirectToIntended(string $default = '/', int $status = 302, array $headers = [], bool|null $secure = null)
 * @method static RedirectResponse redirectToRoute(string $route, mixed $parameters = [], int $status = 302, array $headers = [])
 * @method static Response make(string $content = '', int $status = 200, array $headers = [])
 * @method static Response noContent($status = 204, array $headers = [])
 * @method static Response view(string $view, array $data = [], int $status = 200, array $headers = [])
 * @method static  BinaryFileResponse download(\SplFileInfo|string $file, string|null $name = null, array $headers = [], string|null $disposition = 'attachment')
 * @method static  BinaryFileResponse file($file, array $headers = [])
 * @method static  StreamedResponse stream(\Closure $callback, int $status = 200, array $headers = [])
 * @method static  StreamedResponse streamDownload(\Closure $callback, string|null $name = null, array $headers = [], string|null $disposition = 'attachment')
 *
 * @see ResponseFactory
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
