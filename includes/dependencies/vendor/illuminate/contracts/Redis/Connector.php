<?php

namespace RWP\Vendor\Illuminate\Contracts\Redis;

interface Connector {
    /**
     * Create a connection to a Redis cluster.
     *
     * @param  array  $config
     * @param  array  $options
     * @returnConnection
     */
    public function connect(array $config, array $options);
    /**
     * Create a connection to a Redis instance.
     *
     * @param  array  $config
     * @param  array  $clusterOptions
     * @param  array  $options
     * @returnConnection
     */
    public function connectToCluster(array $config, array $clusterOptions, array $options);
}
