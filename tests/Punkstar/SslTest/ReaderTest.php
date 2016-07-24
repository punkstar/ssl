<?php

namespace Punkstar\SslTest;

use PHPUnit\Framework\TestCase;
use Punkstar\Ssl\Reader;
use VirtualFileSystem\FileSystem;

class ReaderTest extends TestCase
{
    /**
     * @test
     * @expectedException \Punkstar\Ssl\Exception
     * @expectedExceptionCode 1001
     */
    public function testFileNotFound()
    {
        $reader = new Reader();
        $reader->readFromFile("idontexist.tstst.stst.stst");
    }

    /**
     * @test
     * @expectedException \Punkstar\Ssl\Exception
     * @expectedExceptionCode 2001
     */
    public function testJunkCert()
    {
        $fs = new FileSystem();
        $fs->createFile("/junk.crt", "junk-content");

        $reader = new Reader();
        $reader->readFromFile($fs->path("/junk.crt"));
    }
}