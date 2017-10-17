<?php

namespace Punkstar\SslTest\Validator;

use PHPUnit\Framework\TestCase;
use Punkstar\Ssl\Certificate;
use Punkstar\Ssl\Reader;
use Punkstar\Ssl\Validator\CommonNameValidator;

class CommonNameValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function testWrongDomainName()
    {
        $validator = new CommonNameValidator($this->loadExampleCertificate('invalid-cname.crt'));
        
        $this->assertFalse($validator->isValid('www.reputativ.com'));
        $this->assertFalse($validator->isValid('reputativ.com'));
    }
    
    /**
     * @test
     */
    public function testWildcards()
    {
        $validator = new CommonNameValidator($this->loadExampleCertificate('wildcard-google-com.crt'));
    
        $this->assertTrue($validator->isValid('www.google.com'));
        $this->assertTrue($validator->isValid('google.com'));
        $this->assertTrue($validator->isValid('secure.google.com'));
        $this->assertFalse($validator->isValid('www.secure.google.com'));
    }
    
    /**
     * @return Certificate
     */
    protected function loadExampleCertificate($fileName): Certificate
    {
        $reader = new Reader();
        return $reader->readFromFile(implode(DIRECTORY_SEPARATOR, [
            __DIR__,
            '..',
            '..',
            '..',
            '..',
            'example_certs',
            $fileName
        ]));
    }
}
