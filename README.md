[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/donate?business=SYC5XDT23UZ5G&no_recurring=0&item_name=Thank+you%21&currency_code=EUR)

# Encryption Library [![](https://github.com/daycry/encryption/workflows/PHP%20Tests/badge.svg)](https://github.com/daycry/encryption/actions?query=workflow%3A%22PHP+Tests%22)

Encryption for Codeigniter 4

## Installation via composer

Use the package with composer install

	> composer require daycry/encryption

## Manual installation

Download this repo and then enable it by editing **app/Config/Autoload.php** and adding the **Daycry\Encryption**
namespace to the **$psr4** array. For example, if you copied it into **app/ThirdParty**:

```php
$psr4 = [
    'Config'      => APPPATH . 'Config',
    APP_NAMESPACE => APPPATH,
    'App'         => APPPATH,
    'Daycry\Encryption' => APPPATH .'Libraries/encryption/src',
];
```


## Usage Loading Library

```php
$encryption = new \Daycry\Encryption\Encryption();
$data = $encryption->encrypt( 'data' );
var_dump( $data );

$encryption = new \Daycry\Encryption\Encryption();
$data = $encryption->decrypt( 'data' );
var_dump( $data );

```

## Setting Cipher algoritm

```php
$encryption = new \Daycry\Encryption\Encryption();
$data = $encryption->setCipher( 'AES-256-CTR' )->encrypt( 'data' );
var_dump( $data );

```

## Setting Key

```php
$encryption = new \Daycry\Encryption\Encryption();
$encrypt = $obj->setCipher( 'AES-256-CTR' )->setKey( '%T3sT1nG$' )->encrypt( 'data', true );
var_dump( $data );

```

## Get algoritm available

```php
var_dump( openssl_get_cipher_methods() );

```

## CryptoJs Compatibility Returning Key

```php
$result = \Daycry\Encryption\CryptoJsAes::encrypt( "Hello", "123456", true );

$textPlain = \Daycry\Encryption\CryptoJsAes::decrypt( $result );
```

## CryptoJs Compatibility Without Returning Key

```php
$result = \Daycry\Encryption\CryptoJsAes::encrypt( "Hello", "123456", false );

$textPlain = \Daycry\Encryption\CryptoJsAes::decrypt( $result, "123456" );
```


## How Run Tests

```php
cd vendor\daycry\encryption\
composer install
vendor\bin\phpunit

```
