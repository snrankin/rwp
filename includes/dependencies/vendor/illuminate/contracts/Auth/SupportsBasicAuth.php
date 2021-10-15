<?php

namespace RWP\Vendor\Illuminate\Contracts\Auth;

interface SupportsBasicAuth
{
    /**
     * Attempt to authenticate using HTTP Basic Auth.
     *
     * @param  string  $field
     * @param  array  $extraConditions
     * @return \RWP\Vendor\Symfony\HttpFoundation\Response|null
     */
    public function basic($field = 'email', $extraConditions = []);
    /**
     * Perform a stateless HTTP Basic login attempt.
     *
     * @param  string  $field
     * @param  array  $extraConditions
     * @return \RWP\Vendor\Symfony\HttpFoundation\Response|null
     */
    public function onceBasic($field = 'email', $extraConditions = []);
}
