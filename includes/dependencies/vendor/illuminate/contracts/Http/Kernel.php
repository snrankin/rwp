<?php

namespace RWP\Vendor\Illuminate\Contracts\Http;

interface Kernel {
    /**
     * Bootstrap the application for HTTP requests.
     *
     * @return void
     */
    public function bootstrap();
    /**
     * Handle an incoming HTTP request.
     *
     * @param  \RWP\Vendor\Symfony\HttpFoundation\Request  $request
     * @return \RWP\Vendor\Symfony\HttpFoundation\Response
     */
    public function handle($request);
    /**
     * Perform any final actions for the request lifecycle.
     *
     * @param  \RWP\Vendor\Symfony\HttpFoundation\Request  $request
     * @param  \RWP\Vendor\Symfony\HttpFoundation\Response  $response
     * @return void
     */
    public function terminate($request, $response);
    /**
     * Get the Laravel application instance.
     *
     * @returnApplication
     */
    public function getApplication();
}
