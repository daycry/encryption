<?php

namespace Test;

use Tests\Support\TestCase;

class CryptoJsAesTest extends TestCase
{
    protected $value = "Hello!";
    protected $password = "123456";

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    public function testEncryptDecryptWithKey()
    {
        $result = \Daycry\Encryption\CryptoJsAes::encrypt( $this->value, $this->password, true );

        $textPlain = \Daycry\Encryption\CryptoJsAes::decrypt( $result );
        
        $this->assertEquals( $this->value, $textPlain );
    }

    public function testEncryptDecryptWithoutKey()
    {
        $result = \Daycry\Encryption\CryptoJsAes::encrypt( $this->value, $this->password, false );

        $textPlain = \Daycry\Encryption\CryptoJsAes::decrypt( $result, $this->password );
        
        $this->assertEquals( $this->value, $textPlain );
    }

    public function testDecrypt()
    {
        $textPlain = \Daycry\Encryption\CryptoJsAes::decrypt( '{"ct":"RkDB0rCxlUgRz3LdeAFDFNSmERozVhpTSk9pEw4bG3A=","iv":"9399be042297d6c52be1538caaff6dea","s":"08cdebce79bce813"}', $this->password );
        
        $this->assertEquals( 'value to encrypt', $textPlain );
    }

    public function testEncryptDecryptWithoutKeyFailed()
    {
        $result = \Daycry\Encryption\CryptoJsAes::encrypt( $this->value, $this->password, false );

        $textPlain = \Daycry\Encryption\CryptoJsAes::decrypt( $result );

        $this->assertNull( $textPlain );
    }
}
