<?php

namespace RWP\Vendor\Illuminate\Contracts\Broadcasting;

interface ShouldBroadcast
{
    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn();
}
