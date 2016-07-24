<?php

namespace Punkstar\SslTest;

use PHPUnit\Framework\TestCase;
use Punkstar\Ssl\Reader;

class IntegrationTest extends TestCase
{
    /**
     * @test
     * @dataProvider exampleCertsDataProvider
     */
    public function testExampleCerts($certFileName)
    {
        $reader = new Reader();
        $cert = $reader->readFromFile($certFileName);

        $this->assertInternalType('string', $cert->certName());
        $this->assertInstanceOf('DateTime', $cert->validTo());
        $this->assertInstanceOf('DateTime', $cert->validFrom());
    }

    public function exampleCertsDataProvider()
    {
        $certs = glob(__DIR__ . "/../../../example_certs/*");
        $dataProvider = [];

        foreach ($certs as $cert) {
            $dataProvider[] = [$cert];
        }

        return $dataProvider;
    }
}
