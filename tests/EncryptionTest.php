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
final class EncryptionTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    public function testCTR()
    {
        $config = config('Encryption');

        $obj     = new Encryption($config);
        $encrypt = $obj->setCipher('AES-256-CTR')->setKey('%T3sT1nG$')->encrypt('hola', true);

        $decrypt = $obj->decrypt($encrypt, true);

        $this->assertSame('hola', $decrypt);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->resetServices();
    }
}
