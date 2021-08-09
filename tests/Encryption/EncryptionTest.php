<?php

namespace Daycry\Encryption\Test;

use ReflectionObject;

class EncryptionTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    public function testCTR()
    {
        $config = config( 'Encryption' );

        $obj = new \Daycry\Encryption\Encryption( $config );
        $encrypt = $obj->setCipher( 'AES-256-CTR' )->setKey( '%T3sT1nG$' )->encrypt( 'hola', true );

        $decrypt = $obj->decrypt( $encrypt, true );

        $this->assertEquals( 'hola', $decrypt );

    }

    public function testECB()
    {
        $config = config( 'Encryption' );

        $obj = new \Daycry\Encryption\Encryption( $config );
        $obj->setCipher( 'AES-256-ECB' );
        $obj->setKey( '%T3sT1nG$' );

        $encrypt = $obj->encrypt( 'hola', true );
        $encryptAnother = $obj->encrypt( 'hola', true );

        $decrypt = $obj->decrypt( $encrypt, true );

        $this->assertEquals( 'hola', $decrypt );
        $this->assertEquals( $encryptAnother, $encrypt );

    }

    public function testAddFunctionsRunsOnlyOnce()
    {
        $config = config( 'Encryption' );
        $config->key = '%T3sT1nG$';

        $obj = new \Daycry\Encryption\Encryption( $config );
        $ref_obj = new ReflectionObject( $obj );
        $ref_property = $ref_obj->getProperty( 'config' );
        $ref_property->setAccessible( true );
        $configClass = $ref_property->getValue( $obj );

        $this->assertEquals( $configClass, $config );
    }
}
