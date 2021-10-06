<?php

namespace RWP\Vendor\Illuminate\Contracts\Encryption;

interface Encrypter
{
    /**
     * Encrypt the given value.
     *
     * @param  mixed  $value
     * @param  bool  $serialize
     * @return string
     *
     * @throwsEncryptException
     */
    public function encrypt($value, $serialize = \true);
    /**
     * Decrypt the given value.
     *
     * @param  string  $payload
     * @param  bool  $unserialize
     * @return mixed
     *
     * @throwsDecryptException
     */
    public function decrypt($payload, $unserialize = \true);
}
