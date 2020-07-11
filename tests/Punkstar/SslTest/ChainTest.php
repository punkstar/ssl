<?php

namespace Punkstar\SslTest;

use PHPUnit\Framework\TestCase;
use Punkstar\Ssl\Reader;

class ChainTest extends TestCase
{
    /**
     * @test
     */
    public function testUntrustedRoot()
    {
        $reader = new Reader();
        $cert = $reader->readFromFile(__DIR__ . '/../../../example_certs/untrusted-root.pem');

        $this->assertCount(1, $cert->chain());

        $this->assertFalse($cert->chain()[0]->trusted());
    }
}
