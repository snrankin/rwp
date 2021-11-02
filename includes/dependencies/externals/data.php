<?php
/** ============================================================================
 * data
 *
 * @package   RWP\/includes/dependencies/externals/data.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

use RWP\Vendor\Illuminate\Support\Arr;
use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Vendor\Illuminate\Support\HigherOrderTapProxy;
use RWP\Vendor\Illuminate\Support\Optional;
if (!\function_exists('append_config')) {
    /**
     * Assign high numeric IDs to a config item to force appending.
     *
     * @param  array  $array
     * @return array
     */
    function append_config(array $array)
    {
        $start = 9999;
        foreach ($array as $key => $value) {
            if (\is_numeric($key)) {
                $start++;
                $array[$start] = Arr::pull($array, $key);
            }
        }
        return $array;
    }
}
if (!\function_exists('blank')) {
    /**
     * Determine if the given value is "blank".
     *
     * @param  mixed  $value
     * @return bool
     */
    function blank($value)
    {
        if (\is_null($value)) {
            return \true;
        }
        if (\is_string($value)) {
            return \trim($value) === '';
        }
        if (\is_numeric($value) || \is_bool($value)) {
            return \false;
        }
        if ($value instanceof \Countable) {
            return \count($value) === 0;
        }
        return empty($value);
    }
}
if (!\function_exists('class_basename')) {
    /**
     * Get the class "basename" of the given object / class.
     *
     * @param  string|object  $class
     * @return string
     */
    function class_basename($class)
    {
        $class = \is_object($class) ? \get_class($class) : $class;
        return \basename(\str_replace('\\', '/', $class));
    }
}
if (!\function_exists('class_uses_recursive')) {
    /**
     * Returns all traits used by a class, its parent classes and trait of their traits.
     *
     * @param  object|string  $class
     * @return array
     */
    function class_uses_recursive($class)
    {
        if (\is_object($class)) {
            $class = \get_class($class);
        }
        $results = [];
        foreach (\array_reverse(\class_parents($class)) + [$class => $class] as $class) {
            $results += trait_uses_recursive($class);
        }
        return \array_unique($results);
    }
}

if (!\function_exists('filled')) {
    /**
     * Determine if a value is "filled".
     *
     * @param  mixed  $value
     * @return bool
     */
    function filled($value)
    {
        return !blank($value);
    }
}
if (!\function_exists('object_get')) {
    /**
     * Get an item from an object using "dot" notation.
     *
     * @param  object  $object
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    function object_get($object, $key, $default = null)
    {
        if (\is_null($key) || \trim($key) === '') {
            return $object;
        }
        foreach (\explode('.', $key) as $segment) {
            if (!\is_object($object) || !isset($object->{$segment})) {
                return value($default);
            }
            $object = $object->{$segment};
        }
        return $object;
    }
}
if (!\function_exists('optional')) {
    /**
     * Provide access to optional objects.
     *
     * @param  mixed  $value
     * @param  callable|null  $callback
     * @return mixed
     */
    function optional($value = null, callable $callback = null)
    {
        if (\is_null($callback)) {
            return new Optional($value);
        } elseif (!\is_null($value)) {
            return $callback($value);
        }
    }
}
if (!\function_exists('preg_replace_array')) {
    /**
     * Replace a given pattern with each value in the array in sequentially.
     *
     * @param  string  $pattern
     * @param  array  $replacements
     * @param  string  $subject
     * @return string
     */
    function preg_replace_array($pattern, array $replacements, $subject)
    {
        return \preg_replace_callback($pattern, function () use(&$replacements) {
            foreach ($replacements as $key => $value) {
                return \array_shift($replacements);
            }
        }, $subject);
    }
}
if (!\function_exists('retry')) {
    /**
     * Retry an operation a given number of times.
     *
     * @param  int  $times
     * @param  callable  $callback
     * @param  int|\Closure  $sleepMilliseconds
     * @param  callable|null  $when
     * @return mixed
     *
     * @throws \Exception
     */
    function retry($times, callable $callback, $sleepMilliseconds = 0, $when = null)
    {
        $attempts = 0;
        beginning:
        $attempts++;
        $times--;
        try {
            return $callback($attempts);
        } catch (\Exception $e) {
            if ($times < 1 || $when && !$when($e)) {
                throw $e;
            }
            if ($sleepMilliseconds) {
                \usleep(value($sleepMilliseconds, $attempts) * 1000);
            }
            goto beginning;
        }
    }
}
if (!\function_exists('tap')) {
    /**
     * Call the given Closure with the given value then return the value.
     *
     * @param  mixed  $value
     * @param  callable|null  $callback
     * @return mixed
     */
    function tap($value, $callback = null)
    {
        if (\is_null($callback)) {
            return new HigherOrderTapProxy($value);
        }
        $callback($value);
        return $value;
    }
}
if (!\function_exists('throw_if')) {
    /**
     * Throw the given exception if the given condition is true.
     *
     * @param  mixed  $condition
     * @param  \Throwable|string  $exception
     * @param  mixed  ...$parameters
     * @return mixed
     *
     * @throws \Throwable
     */
    function throw_if($condition, $exception = 'RuntimeException', ...$parameters)
    {
        if ($condition) {
            if (\is_string($exception) && \class_exists($exception)) {
                $exception = new $exception(...$parameters);
            }
            throw \is_string($exception) ? new \RuntimeException($exception) : $exception;
        }
        return $condition;
    }
}
if (!\function_exists('throw_unless')) {
    /**
     * Throw the given exception unless the given condition is true.
     *
     * @param  mixed  $condition
     * @param  \Throwable|string  $exception
     * @param  mixed  ...$parameters
     * @return mixed
     *
     * @throws \Throwable
     */
    function throw_unless($condition, $exception = 'RuntimeException', ...$parameters)
    {
        throw_if(!$condition, $exception, ...$parameters);
        return $condition;
    }
}
if (!\function_exists('trait_uses_recursive')) {
    /**
     * Returns all traits used by a trait and its traits.
     *
     * @param  string  $trait
     * @return array
     */
    function trait_uses_recursive($trait)
    {
        $traits = \class_uses($trait) ?: [];
        foreach ($traits as $trait) {
            $traits += trait_uses_recursive($trait);
        }
        return $traits;
    }
}
if (!\function_exists('transform')) {
    /**
     * Transform the given value if it is present.
     *
     * @param  mixed  $value
     * @param  callable  $callback
     * @param  mixed  $default
     * @return mixed|null
     */
    function transform($value, callable $callback, $default = null)
    {
        if (filled($value)) {
            return $callback($value);
        }
        if (\is_callable($default)) {
            return $default($value);
        }
        return $default;
    }
}
if (!\function_exists('windows_os')) {
    /**
     * Determine whether the current environment is Windows based.
     *
     * @return bool
     */
    function windows_os()
    {
        return \PHP_OS_FAMILY === 'Windows';
    }
}
if (!\function_exists('with')) {
    /**
     * Return the given value, optionally passed through the given callback.
     *
     * @param  mixed  $value
     * @param  callable|null  $callback
     * @return mixed
     */
    function with($value, callable $callback = null)
    {
        return \is_null($callback) ? $value : $callback($value);
    }
}


 /**
 * Additional data helper functions
 * @link https://gist.github.com/derekmd/34da3c9861c14a7ebe4dc78582e20a35
 */

if ( ! function_exists( 'data_dot' ) ) {
    /**
     * Flatten a multi-dimensional object with dots.
     *
     * @param  array|ArrayAccess|object $object
     * @param  string $prepend
     *
     * @return array
     */
    function data_dot( $object, $prepend = '' ) { // phpcs:ignore
        $results = [];

        if ( Arr::accessible( $object ) ) {
            $array = $object;
        } elseif ( is_object( $object ) ) {
            $array = get_object_vars( $object );
        } else {
            $array = [];
        }

        foreach ( $array as $key => $value ) {
            if ( is_array( $value ) && ! empty( $value ) ) {
                $results = array_merge( $results, data_dot( $value, $prepend . $key . '.' ) );
            } elseif ( $value instanceof Collection ) {
                $results = array_merge( $results, data_dot( $value->all(), $prepend . $key . '.' ) );
            } elseif ( is_object( $value ) && ! empty( get_object_vars( $value ) ) ) {
				$props = get_object_vars( $value );
                $results = array_merge( $results, data_dot( $props, $prepend . $key . '.' ) );
            } else {
                $results[ $prepend . $key ] = $value;
            }
        }

        return $results;
    }
}

if ( ! function_exists( 'data_has' ) ) {
    /**
     * Find if there is an item in an array or object using "dot" notation.
     *
     * @param  mixed   $target
     * @param  string|array  $keys
     *
     * @return bool
     */
    function data_has( $target, $keys ) { // phpcs:ignore
        if ( is_null( $keys ) ) {
            return false;
        }

        $keys = (array) $keys;

        if ( ! $target ) {
            return false;
        }

        if ( [] === $keys ) {
            return false;
        }

        foreach ( $keys as $i => $key ) {
            $sub_key_target = $target;

            if ( Arr::accessible( $sub_key_target ) && Arr::exists( $sub_key_target, $key ) ) {
                continue;
            }

            if ( is_object( $sub_key_target ) && Arr::exists( get_object_vars( $sub_key_target ), $key ) ) {
                continue;
            }

            foreach ( explode( '.', $key ) as $segment ) {
                if ( '*' === $segment ) {
                    if ( $sub_key_target instanceof Collection ) {
                        $sub_key_target = $sub_key_target->all();
                    } elseif ( ! is_array( $sub_key_target ) ) {
                        return false;
                    }

                    if ( empty( $key ) ) {
                        return true;
                    }

                    return array_reduce($sub_key_target, function ( $present, $item ) use ( $keys, $i ) {
                        return $present || data_has( $item, array_slice( $keys, $i + 1 ) );
                    }, false);
                }

                if ( Arr::accessible( $sub_key_target ) && Arr::exists( $sub_key_target, $segment ) ) {
                    $sub_key_target = $sub_key_target[ $segment ];
                } elseif ( is_object( $sub_key_target ) && isset( $sub_key_target->{$segment} ) ) {
                    $sub_key_target = $sub_key_target->{$segment};
                } else {
                    return false;
                }
            }
        }

        return true;
    }
}

if ( ! \function_exists( 'data_remove' ) ) {
    /**
     * Set an item on an array or object using dot notation.
     *
     * @param  mixed  $target
     * @param  string|array  $key
     * @return mixed
     */
    function data_remove( &$target, $key ) { // phpcs:ignore
        $segments = \is_array( $key ) ? $key : \explode( '.', $key );
        if ( ( $segment = \array_shift( $segments ) ) === '*' ) { // phpcs:ignore
            if ( ! Arr::accessible( $target ) ) {
                return $target;
            }
            if ( $segments ) {
                foreach ( $target as &$inner ) {
                    data_remove( $inner, $segments );
                }
            } else {
				unset( $target[ $segment ] );
			}
        } elseif ( Arr::accessible( $target ) ) {
            if ( $segments ) {
                if ( ! Arr::exists( $target, $segment ) ) {
                    return $target;
                }
                data_remove( $target[ $segment ], $segments );
            } else {
				unset( $target[ $segment ] );
			}
        } elseif ( \is_object( $target ) ) {
            if ( $segments ) {
                if ( ! isset( $target->{$segment} ) ) {
                    return $target;
                }
                data_remove( $target->{$segment}, $segments );
            } else {
				unset( $target->{$segment} );
			}
        } else {
            return $target;
        }
    }
}
