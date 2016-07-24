<?php

namespace Punkstar\Ssl;

class Exception extends \Exception
{
    const FILE_NOT_FOUND = 1001;

    const MALFORMED_CERTIFICATE = 2001;
}