<?php

namespace Helpers\Encrypt;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class EncryptTest extends TestCase
{
    public function testRC4()
    {
        echo rc4('111111', '2');

        echo rc4(rc4('111111', '2'), '2');
    }
}
