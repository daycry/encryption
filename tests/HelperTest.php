<?php

namespace Test;

use Daycry\Encryption\Encryption;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class HelperTest extends TestCase
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
}