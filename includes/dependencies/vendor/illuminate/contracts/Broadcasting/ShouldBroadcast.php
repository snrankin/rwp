<?php

namespace RWP\Vendor\Illuminate\Contracts\Broadcasting;

interface ShouldBroadcast {
    /**
     * Get the channels the event should broadcast on.
     *
     * @returnChannel|\Illuminate\Broadcasting\Channel[]|string[]|string
     */
    public function broadcastOn();
}
