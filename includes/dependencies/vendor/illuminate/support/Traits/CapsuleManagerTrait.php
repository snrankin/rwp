<?php

namespace RWP\Vendor\Illuminate\Support\Traits;

use RWP\Vendor\Illuminate\Contracts\Container\Container;
use RWP\Vendor\Illuminate\Support\Fluent;
trait CapsuleManagerTrait
{
    /**
     * The current globally used instance.
     *
     * @var object
     */
    protected static $instance;
    /**
     * The container instance.
     *
     * @var Container
     */
    protected $container;
    /**
     * Setup the IoC container instance.
     *
     * @param  Container  $container
     * @return void
     */
    protected function setupContainer(Container $container)
    {
        $this->container = $container;
        if (!$this->container->bound('config')) {
            $this->container->instance('config', new Fluent());
        }
    }
    /**
     * Make this capsule instance available globally.
     *
     * @return void
     */
    public function setAsGlobal()
    {
        static::$instance = $this;
    }
    /**
     * Get the IoC container instance.
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }
    /**
     * Set the IoC container instance.
     *
     * @param  Container  $container
     * @return void
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}