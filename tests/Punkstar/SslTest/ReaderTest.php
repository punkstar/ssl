<?php

namespace Punkstar\SslTest;

use PHPUnit\Framework\TestCase;
use Punkstar\Ssl\Exception;
use Punkstar\Ssl\Reader;
use VirtualFileSystem\FileSystem;

class ReaderTest extends TestCase
{
    /**
     * @test
     */
    public function testFileNotFound()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(1001);

        $reader = new Reader();
        $reader->readFromFile("idontexist.tstst.stst.stst");
    }

    /**
     * @test
     */
    public function testJunkCert()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(2001);

        $fs = new FileSystem();
        $fs->createFile("/junk.crt", "junk-content");

        $reader = new Reader();
        $reader->readFromFile($fs->path("/junk.crt"));
    }
}
