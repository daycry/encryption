<?php

/**
 * This file is part of Daycry Auth.
 *
 * (c) Daycry <daycry9@proton.me>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Daycry\Encryption\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Exception;

class Checker extends BaseCommand
{
    protected $group       = 'Encryption';
    protected $name        = 'encryption:check';
    protected $description = 'Encrypt/Decrypt data.';
    protected $usage       = 'encryption:check <data> [options]';
    protected $arguments   = [
        'data' => 'Data for encrypt or decrypt',
    ];
    protected $options = ['-mode' => 'Set cipher mode', '-key' => 'Set key', 'method' => 'Encrypt or Decrypt'];

    public function run(array $params)
    {
        try {
            $config = new \Config\Encryption();

            $data = array_shift($params);

            if (empty($data)) {
                $data = CLI::prompt('Insert hash', null, 'required'); // @codeCoverageIgnore
            }

            $mode   = $params['mode'] ?? CLI::getOption('mode');
            $key    = $params['key'] ?? CLI::getOption('key');
            $method = $params['method'] ?? CLI::getOption('method');

            if (! empty($mode)) {
                $config->cipher = $mode;
            }

            if (! empty($key)) {
                $config->key = $key;
            }

            if (empty($method)) {
                $method = CLI::prompt('Insert method mode:', ['encrypt', 'decrypt']);
            }

            $encryption = new \Daycry\Encryption\Encryption($config);
            $text       = call_user_func([$encryption, $method], $data, true);

            CLI::write($text, 'green');
        } catch (Exception $ex) {
            CLI::error($ex->getMessage());
        }
    }
}
