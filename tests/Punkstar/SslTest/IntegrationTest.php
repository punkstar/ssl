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

        $this->assertIsString($cert->certName());
        $this->assertIsString($cert->toString());
        $this->assertIsString((string) $cert);
        $this->assertInstanceOf('DateTime', $cert->validTo());
        $this->assertInstanceOf('DateTime', $cert->validFrom());
        $this->assertIsArray($cert->subject());
        $this->assertIsArray($cert->issuer());
        $this->assertIsArray($cert->sans());
        $this->assertIsString($cert->signatureAlgorithm());
    }

    /**
     * @test
     * @dataProvider exampleCertsDataProvider
     */
    public function testRawCertificate($certFileName)
    {
        $reader = new Reader();
        $cert = $reader->readFromFile($certFileName);

        $rawCertFromFile = trim(file_get_contents($certFileName));

        $this->assertEquals($rawCertFromFile, trim($cert->toString()));
        $this->assertEquals($rawCertFromFile, trim((string) $cert));
    }

    /**
     * @test
     */
    public function testUrlReading()
    {
        $reader = new Reader();
        $cert = $reader->readFromUrl("https://google.com");
        $this->assertInstanceOf("Punkstar\\Ssl\\Certificate", $cert);
    }

    public function exampleCertsDataProvider()
    {
        $certs = glob(__DIR__ . "/../../../example_certs/*.crt");
        $dataProvider = [];

        foreach ($certs as $cert) {
            $dataProvider[] = [$cert];
        }

        return $dataProvider;
    }
}
