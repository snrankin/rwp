<?php

namespace RWP\Vendor\Illuminate\Contracts\Encryption;

interface StringEncrypter
{
    /**
     * Encrypt a string without serialization.
     *
     * @param  string  $value
     * @return string
     *
     * @throwsEncryptException
     */
    public function encryptString($value);
    /**
     * Decrypt the given string without unserialization.
     *
     * @param  string  $payload
     * @return string
     *
     * @throwsDecryptException
     */
    public function decryptString($payload);
}
