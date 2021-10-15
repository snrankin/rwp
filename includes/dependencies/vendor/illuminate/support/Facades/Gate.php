<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

use RWP\Vendor\Illuminate\Contracts\Auth\Access\Gate as GateContract;

/**
 * @method staticGate guessPolicyNamesUsing(callable $callback)
 * @method staticResponse authorize(string $ability, array|mixed $arguments = [])
 * @method staticResponse inspect(string $ability, array|mixed $arguments = [])
 * @method staticGate after(callable $callback)
 * @method staticGate before(callable $callback)
 * @method staticGate define(string $ability, callable|string $callback)
 * @method staticGate forUser(\Illuminate\Contracts\Auth\Authenticatable|mixed $user)
 * @method staticGate policy(string $class, string $policy)
 * @method static array abilities()
 * @method static bool allows(string $ability, array|mixed $arguments = [])
 * @method static bool any(iterable|string $abilities, array|mixed $arguments = [])
 * @method static bool check(iterable|string $abilities, array|mixed $arguments = [])
 * @method static bool denies(string $ability, array|mixed $arguments = [])
 * @method static bool has(string $ability)
 * @method static mixed getPolicyFor(object|string $class)
 * @method static mixed raw(string $ability, array|mixed $arguments = [])
 *
 * @seeGate
 */
class Gate extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return Gate::class;
    }
}
