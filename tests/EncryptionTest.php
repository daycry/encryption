<?php

namespace Test;

use CodeIgniter\Test\CIUnitTestCase;

class EncryptionTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    public function testCTR()
    {
        $config = config('Encryption');

        $obj = new \Daycry\Encryption\Encryption($config);
        $encrypt = $obj->setCipher('AES-256-CTR')->setKey('%T3sT1nG$')->encrypt('hola', true);

        $decrypt = $obj->decrypt($encrypt, true);

        $this->assertEquals('hola', $decrypt);
    }

    public function testECB()
    {
        $config = config('Encryption');

        $obj = new \Daycry\Encryption\Encryption($config);
        $obj->setCipher('AES-256-ECB');
        $obj->setKey('%T3sT1nG$');

        $encrypt = $obj->encrypt('hola', true);
        $encryptAnother = $obj->encrypt('hola', true);

        $decrypt = $obj->decrypt($encrypt, true);

        $this->assertEquals('hola', $decrypt);
        $this->assertEquals($encryptAnother, $encrypt);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->resetServices();
    }
}
