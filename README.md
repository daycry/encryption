# Encryption Library

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
