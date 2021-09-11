<?php

namespace RWP\Vendor\Illuminate\Contracts\Validation;

interface ValidatorAwareRule
{
    /**
     * Set the current validator.
     *
     * @param  Validator  $validator
     * @return $this
     */
    public function setValidator($validator);
}
