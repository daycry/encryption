<?php
namespace Daycry\Encryption;

use CodeIgniter\Config\BaseConfig;

class Encryption
{
    private $config = null;

    public function __construct( BaseConfig $config = null )
    {
        $this->initialize( $config );
    }

    public function initialize( BaseConfig $config = null ) : Encryption
    {
        if( !is_null( $config ) )
        {
            $this->config = $config;
        }else{
            $this->config = new \Config\Encryption();
        }

        return $this;
    }

    public function setCipher( String $mode = 'AES-256-CTR' ) : Encryption
    {
        if( !is_null( $this->config ) )
        {
            //$this->config->cipher = 'AES-256-' . \strtoupper( $mode );
            $this->config->cipher = \strtoupper( $mode );
        }

        return $this;
    }

    public function setKey( String $key ) : Encryption
    {
        if( !is_null( $this->config ) )
        {
            $this->config->key = $key;
        }

        return $this;
    }

    public function encrypt( $data, Bool $urlSafe = true ) : String
    {
        $cipherText = base64_encode( \Config\Services::encrypter( $this->config )->encrypt( $data ) );

        if( $urlSafe )
        {
            $cipherText = str_replace( array( '+', '/', '=' ), array( '-', '_', '~' ), $cipherText );
        }

        return $cipherText;
    }

    public function decrypt( String $data, Bool $urlSafe = true )
    {
        if( $urlSafe )
        {
            $data = str_replace( array( '-', '_', '~' ), array( '+', '/', '=' ), $data );
        }

        $plainText = \Config\Services::encrypter( $this->config )->decrypt( base64_decode( $data ) );

        return $plainText;
    }
}
