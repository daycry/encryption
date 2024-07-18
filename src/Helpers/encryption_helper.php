<?php

/**
 * This file is part of Daycry Auth.
 *
 * (c) Daycry <daycry9@proton.me>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use CodeIgniter\Config\BaseConfig;

if (! function_exists('encryption_instance')) {
    /**
     * Provides a convenience interface to the Encryption service.
     *
     * @param BaseConfig|null $value
     *
     * @return Daycry\Encryption\Encryption
     */
    function encryption_instance(?BaseConfig $config = null)
    {
        return new Daycry\Encryption\Encryption($config);
    }
}
