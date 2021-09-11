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
     * @param   Request  $request
     * @return  Response
     */
    public function handle($request);
    /**
     * Perform any final actions for the request lifecycle.
     *
     * @param   Request  $request
     * @param   Response  $response
     * @return void
     */
    public function terminate($request, $response);
    /**
     * Get the Laravel application instance.
     *
     * @return Application
     */
    public function getApplication();
}
