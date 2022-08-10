<?php

namespace Test;

use Daycry\Encryption\Encryption;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class HelperTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        helper(['encryption']);
    }

    public function testReturnsServiceByDefault()
    {
        $this->assertInstanceOf(Encryption::class, encryption_instance());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->resetServices();
    }
}
