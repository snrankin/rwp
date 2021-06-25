<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

use RWP\Vendor\Illuminate\Contracts\Auth\Access\Gate as GateContract;
/**
 * @method static Gate guessPolicyNamesUsing(callable $callback)
 * @method static Response authorize(string $ability, array|mixed $arguments = [])
 * @method static Response inspect(string $ability, array|mixed $arguments = [])
 * @method static Gate after(callable $callback)
 * @method static Gate before(callable $callback)
 * @method static Gate define(string $ability, callable|string $callback)
 * @method static Gate forUser(\Illuminate\Contracts\Auth\Authenticatable|mixed $user)
 * @method static Gate policy(string $class, string $policy)
 * @method static array abilities()
 * @method static bool allows(string $ability, array|mixed $arguments = [])
 * @method static bool any(iterable|string $abilities, array|mixed $arguments = [])
 * @method static bool check(iterable|string $abilities, array|mixed $arguments = [])
 * @method static bool denies(string $ability, array|mixed $arguments = [])
 * @method static bool has(string $ability)
 * @method static mixed getPolicyFor(object|string $class)
 * @method static mixed raw(string $ability, array|mixed $arguments = [])
 *
 * @see Gate
 */
class Gate extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Gate::class;
    }
}
