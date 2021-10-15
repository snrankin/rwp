<?php

namespace RWP\Vendor\Illuminate\Contracts\Support;

interface DeferringDisplayableValue {
    /**
     * Resolve the displayable value that the class is deferring.
     *
     * @returnHtmlable|string
     */
    public function resolveDisplayableValue();
}
