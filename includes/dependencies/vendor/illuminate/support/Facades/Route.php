<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

/**
 * @method static PendingResourceRegistration apiResource(string $name, string $controller, array $options = [])
 * @method static PendingResourceRegistration resource(string $name, string $controller, array $options = [])
 * @method static Route any(string $uri, array|string|callable|null $action = null)
 * @method static Route|null current()
 * @method static Route delete(string $uri, array|string|callable|null $action = null)
 * @method static Route fallback(array|string|callable|null $action = null)
 * @method static Route get(string $uri, array|string|callable|null $action = null)
 * @method static Route|null getCurrentRoute()
 * @method static RouteCollectionInterface getRoutes()
 * @method static Route match(array|string $methods, string $uri, array|string|callable|null $action = null)
 * @method static Route options(string $uri, array|string|callable|null $action = null)
 * @method static Route patch(string $uri, array|string|callable|null $action = null)
 * @method static Route permanentRedirect(string $uri, string $destination)
 * @method static Route post(string $uri, array|string|callable|null $action = null)
 * @method static Route put(string $uri, array|string|callable|null $action = null)
 * @method static Route redirect(string $uri, string $destination, int $status = 302)
 * @method static Route substituteBindings(\Illuminate\Support\Facades\Route $route)
 * @method static Route view(string $uri, string $view, array $data = [], int|array $status = 200, array $headers = [])
 * @method static RouteRegistrar as(string $value)
 * @method static RouteRegistrar domain(string $value)
 * @method static RouteRegistrar middleware(array|string|null $middleware)
 * @method static RouteRegistrar name(string $value)
 * @method static RouteRegistrar namespace(string|null $value)
 * @method static RouteRegistrar prefix(string $prefix)
 * @method static RouteRegistrar where(array $where)
 * @method static Router|\Illuminate\Routing\RouteRegistrar group(\Closure|string|array $attributes, \Closure|string $routes)
 * @method static ResourceRegistrar resourceVerbs(array $verbs = [])
 * @method static string|null currentRouteAction()
 * @method static string|null currentRouteName()
 * @method static void apiResources(array $resources, array $options = [])
 * @method static void bind(string $key, string|callable $binder)
 * @method static void model(string $key, string $class, \Closure|null $callback = null)
 * @method static void pattern(string $key, string $pattern)
 * @method static void resources(array $resources, array $options = [])
 * @method static void substituteImplicitBindings(\Illuminate\Support\Facades\Route $route)
 * @method static boolean uses(...$patterns)
 * @method static boolean is(...$patterns)
 * @method static boolean has(string $name)
 * @method static mixed input(string $key, string|null $default = null)
 *
 * @see Router
 */
class Route extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'router';
    }
}
