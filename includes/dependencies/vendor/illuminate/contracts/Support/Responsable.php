<?php

namespace RWP\Vendor\Illuminate\Contracts\Support;

interface Responsable {
    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request  $request
     * @return \RWP\Vendor\Symfony\HttpFoundation\Response
     */
    public function toResponse($request);
}
