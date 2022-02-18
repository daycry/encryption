<?php

namespace Daycry\Encryption\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Decrypt extends BaseCommand
{
    protected $group       = 'Encryption';
    protected $name        = 'check:hash';
    protected $description = 'Decrypt hash.';
    protected $usage = 'decrypt:identifier <hash> [options]';

    protected $arguments = [
        'hash' => 'Hash for decrypt',
    ];
    protected $options = [ '-mode' => 'Set cipher mode', '-key' => 'Set key', 'method' => 'Encrypt or Decrypt' ];

    public function run(array $params)
    {
        try {
            $config = new \Config\Encryption();

            $hash = array_shift($params);

            if (empty($hash)) {
                $hash = CLI::prompt('Insert hash', null, 'required'); // @codeCoverageIgnore
            }

            $mode = $params[ 'mode' ] ?? CLI::getOption('mode');
            $key = $params[ 'key' ] ?? CLI::getOption('key');
            $method = $params[ 'method' ] ?? CLI::getOption('method');

            if (!empty($mode)) {
                $config->cipher = $mode;
            }

            if (!empty($key)) {
                $config->key = $key;
            }

            if (empty($method)) {
                $method = CLI::prompt('Insert method mode:', ['encrypt','decrypt']);
            }

            $encryption = new \Daycry\Encryption\Encryption($config);
            $text = call_user_func([ $encryption, $method ], $hash, true);
            //$text = $encryption->decrypt( $hash, true );

            CLI::write($text, 'green');
        } catch (\Exception $ex) {
            CLI::error($ex->getMessage());
        }
    }
}
