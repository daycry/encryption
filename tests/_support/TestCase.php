<?php

namespace Tests\Support;

use Daycry\Encryption\Encryption;
use CodeIgniter\Test\CIUnitTestCase;
use Config\Services;
use Nexus\PHPUnit\Extension\Expeditable;

abstract class TestCase extends CIUnitTestCase
{
    use Expeditable;

    /**
     * @var Settings
     */
    protected $encryption;

    /**
     * Sets up the ArrayHandler for faster & easier tests.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $config           = config('Encryption');
        $this->encryption   = new Encryption($config);

        Services::injectMock('encryption', $this->encryption);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->resetServices();
    }
}