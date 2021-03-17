<?php
namespace Daycry\Encryption;

use CodeIgniter\Config\BaseConfig;

class Encryption
{
    private $config = null;

    public function __construct( BaseConfig $config = null )
    {
        if( !is_null( $config ) )
        {
            $this->config = $config;
        }
    }

    public function encrypt( $data, $url_safe = true, $mode = 'CTR' )
    {
        $config = $this->_getConfig( $mode );

        $cipherText = base64_encode( \Config\Services::encrypter( $config )->encrypt( $data ) );

        if( $url_safe )
        {
            $cipherText = str_replace( array( '+', '/', '=' ), array( '-', '_', '~' ), $cipherText );
        }

        return $cipherText;
    }

    public function decrypt( $data, $url_safe = true, $mode = 'CTR' )
    {
        if( $url_safe )
        {
            $data = str_replace( array( '-', '_', '~' ), array( '+', '/', '=' ), $data );
        }

        $config = $this->_getConfig( $mode );

        $plainText = \Config\Services::encrypter( $config )->decrypt( base64_decode( $data ) );

        return $plainText;
    }

    /**
    * Encrypt value to a cryptojs compatiable json encoding string
    *
    * @param mixed $passphrase
    * @param mixed $value
    * @return string
    */
    public function cryptoJsAesEncrypt( $passphrase, $value )
    {
        $salt = openssl_random_pseudo_bytes( 8 );
        $salted = '';
        $dx = '';
        while( strlen( $salted ) < 48 )
        {
            $dx = md5( $dx.$passphrase.$salt, true );
            $salted .= $dx;
        }
        $key = substr( $salted, 0, 32 );
        $iv  = substr( $salted, 32,16 );
        $encrypted_data = openssl_encrypt( json_encode( $value ), 'aes-256-cbc', $key, true, $iv );
        $data = array( "ct" => base64_encode( $encrypted_data ), "iv" => bin2hex( $iv ), "s" => bin2hex( $salt ), 'k' => $passphrase );
        
        return json_encode($data);
    }

    private function _getConfig( $mode )
    {
        if( $this->config == null )
        {
            $config = new \Config\Encryption();

            if( $mode == 'ECB' )
            {
                $config->cipher = 'AES-256-ECB';
            }

            return $config;

        }else{

            $this->config->cipher = 'AES-256-ECB';
            return $this->config;
        }
    }
}
