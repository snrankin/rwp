<?php

namespace RWP\Vendor\Exceptions\IO\Network;

use RWP\Vendor\Exceptions\Tag\AbortedTag;
/**
 * Use this exception when an IO operation based on a communication protocol receives an unexpected response from
 * the remote host.
 *
 * For example, establishing an FTP connection on a SFTP server will yield unexpected communication dialog. In
 * this event, an UnexpectedResponseException should be thrown.
 *
 * @author   Mathieu Dumoulin <thecrazycodr@gmail.com>
 * @license  MIT
 */
class UnexpectedResponseException extends NetworkException implements AbortedTag
{
    const MESSAGE = 'Unexpected response received while communicating with remote host';
    const CODE = 0;
}
