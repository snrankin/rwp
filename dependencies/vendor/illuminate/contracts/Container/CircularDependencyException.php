<?php

namespace RWP\Vendor\Illuminate\Contracts\Container;

use Exception;
use RWP\Vendor\Psr\Container\ContainerExceptionInterface;
class CircularDependencyException extends \Exception implements ContainerExceptionInterface
{
    //
}
