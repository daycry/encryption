<?php

namespace Daycry\Encryption;

class CryptoJsAes
{
    /**
     * @link http://php.net/manual/en/function.openssl-get-cipher-methods.php Available methods.
     * @var string Cipher method. Recommended AES-128-CBC, AES-192-CBC, AES-256-CBC
     */
    protected static $encryptMethod = 'AES-256-CBC';

    /**
     * Encrypt any value
     * @param mixed $value Any value
     * @param string $passphrase Your password
     * @return string
     */
    public static function encrypt($value, string $passphrase, $returnKey = true)
    {
        $ivLength = openssl_cipher_iv_length( self::$encryptMethod );
        $iv = openssl_random_pseudo_bytes($ivLength);
 
        $salt = openssl_random_pseudo_bytes(256);
        $iterations = 999;
        $hashKey = hash_pbkdf2('sha512', $passphrase, $salt, $iterations, (self::encryptMethodLength() / 4));

        $encryptedString = openssl_encrypt($value, self::$encryptMethod, hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);

        $encryptedString = base64_encode($encryptedString);
        unset($hashKey);

        $output = ['ct' => $encryptedString, 'iv' => bin2hex($iv), 's' => bin2hex($salt), 'iterations' => $iterations];

        if( $returnKey )
        {
            $output["k"] = bin2hex($passphrase);
        }

        unset($encryptedString, $iterations, $iv, $ivLength, $salt);

        return json_encode($output);
    }

    /**
     * Decrypt a previously encrypted value
     * @param string $jsonStr Json stringified value
     * @param string $passphrase Your password
     * @return mixed
     */
    public static function decrypt(string $jsonStr, ?string $passphrase = '')
    {
        $json = json_decode($jsonStr, true);

        try {
            $salt = hex2bin($json["s"]);
            $iv = hex2bin($json["iv"]);
        } catch (\Exception $e) {
            return null;
        }

        if( isset( $json["k"] ) )
        {
            $passphrase = hex2bin($json["k"]);
        }

        $cipherText = base64_decode($json['ct']);

        $iterations = 999;
        if( isset( $json['iterations'] ) )
        {
            $iterations = intval(abs($json['iterations']));
            if ($iterations <= 0) {
                $iterations = 999;
            }
        }
        
        $hashKey = hash_pbkdf2('sha512', $passphrase, $salt, $iterations, (self::encryptMethodLength() / 4));
        unset($iterations, $json, $salt);

        $decrypted = openssl_decrypt($cipherText , self::$encryptMethod, hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);
        unset($cipherText, $hashKey, $iv);

        return $decrypted;
    }

    /**
     * Get encrypt method length number (128, 192, 256).
     * 
     * @return integer.
     */
    protected static function encryptMethodLength()
    {
        $number = filter_var(self::$encryptMethod, FILTER_SANITIZE_NUMBER_INT);

        if( !is_numeric( substr( $number, -1 ) ) )
        {
            $number = substr($number, 0, -1);
        }

        return intval(abs($number));
    }
}