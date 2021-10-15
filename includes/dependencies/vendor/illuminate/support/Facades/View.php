<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

/**
 * @method static Factory addNamespace(string $namespace, string|array $hints)
 * @method static View first(array $views, Arrayable|array $data = [], array $mergeData = [])
 * @method static Factory replaceNamespace(string $namespace, string|array $hints)
 * @method static Factory addExtension(string $extension, string $engine, \Closure|null $resolver = null)
 * @method static View file(string $path, array $data = [], array $mergeData = [])
 * @method static View make(string $view, array $data = [], array $mergeData = [])
 * @method static array composer(array|string $views, \Closure|string $callback)
 * @method static array creator(array|string $views, \Closure|string $callback)
 * @method static bool exists(string $view)
 * @method static mixed share(array|string $key, $value = null)
 *
 * @see Factory
 */
class View extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'view';
    }
}
