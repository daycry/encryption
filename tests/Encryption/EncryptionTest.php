<?php

namespace Daycry\Encryption\Test;

use ReflectionObject;

class EncryptionTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    public function testEncryptDecrypt()
    {

        $config = config( 'Encryption' );
        $config->key = '%T3sT1nG$';

        $obj = new \Daycry\Encryption\Encryption( $config );

        $encrypt = $obj->encrypt( 'hola', true, 'ECB' );

        $decrypt = $obj->decrypt( $encrypt, true, 'ECB' );

        $this->assertEquals( 'hola', $decrypt );

    }

    public function testAddFunctionsRunsOnlyOnce()
    {
        $obj = new \Daycry\Encryption\Encryption();

        $ref_obj = new ReflectionObject( $obj );
        $ref_property = $ref_obj->getProperty( 'config' );
        $ref_property->setAccessible( true );
        $config = $ref_property->getValue( $obj );

        $this->assertEquals( null, $config );


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
