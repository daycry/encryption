<?php

/**
 * This file is part of Daycry Auth.
 *
 * (c) Daycry <daycry9@proton.me>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Test;

use CodeIgniter\Test\CIUnitTestCase;
use Daycry\Encryption\Encryption;

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
