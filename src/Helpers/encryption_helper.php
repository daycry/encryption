<?php

use CodeIgniter\Config\BaseConfig;

if (! function_exists('encryption_instance')) {
    /**
     * Provides a convenience interface to the Encryption service.
     *
     * @param \CodeIgniter\Config\BaseConfig|null $value
     *
     * @return \Daycry\Encryption\Encryption
     */
    function encryption_instance(BaseConfig $config = null)
    {
        return new \Daycry\Encryption\Encryption( $config );
    }
}