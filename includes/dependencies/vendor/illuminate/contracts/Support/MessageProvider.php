<?php

namespace RWP\Vendor\Illuminate\Contracts\Support;

interface MessageProvider
{
    /**
     * Get the messages for the instance.
     *
     * @return MessageBag
     */
    public function getMessageBag();
}
