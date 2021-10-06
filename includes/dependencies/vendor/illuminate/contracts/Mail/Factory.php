<?php

namespace RWP\Vendor\Illuminate\Contracts\Mail;

interface Factory
{
    /**
     * Get a mailer instance by name.
     *
     * @param  string|null  $name
     * @returnMailer
     */
    public function mailer($name = null);
}
