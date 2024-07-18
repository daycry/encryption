<?php

/**
 * This file is part of Daycry Auth.
 *
 * (c) Daycry <daycry9@proton.me>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Daycry\Encryption;

use CodeIgniter\Config\BaseConfig;
use Config\Encryption as ConfigEncryption;
use Config\Services;

class Encryption
{
    private $config;

    public function __construct(?BaseConfig $config = null)
    {
        $this->initialize($config);
    }

    public function initialize(?BaseConfig $config = null): Encryption
    {
        if (null !== $config) {
            $this->config = $config;
        } else {
            $this->config = new ConfigEncryption();
        }

        return $this;
    }

    public function setCipher(string $mode = 'AES-256-CTR'): Encryption
    {
        if (null !== $this->config) {
            // $this->config->cipher = 'AES-256-' . \strtoupper( $mode );
            $this->config->cipher = \strtoupper($mode);
        }

        return $this;
    }

    public function setKey(string $key): Encryption
    {
        if (null !== $this->config) {
            $this->config->key = $key;
        }

        return $this;
    }

    public function encrypt($data, bool $urlSafe = true, $params = null): string
    {
        $cipherText = base64_encode(Services::encrypter($this->config)->encrypt($data, $params));

        if ($urlSafe) {
            $cipherText = str_replace(['+', '/', '='], ['-', '_', '~'], $cipherText);
        }

        return $cipherText;
    }

    public function decrypt(string $data, bool $urlSafe = true, $params = null)
    {
        if ($urlSafe) {
            $data = str_replace(['-', '_', '~'], ['+', '/', '='], $data);
        }

        return Services::encrypter($this->config)->decrypt(base64_decode($data, true), $params);
    }
}
