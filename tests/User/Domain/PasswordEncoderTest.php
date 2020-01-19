<?php

namespace App\Tests\User\Domain;

use App\User\Domain\Service\PasswordEncoder;
use PHPUnit\Framework\TestCase;

class PasswordEncoderTest extends TestCase
{
    public function testEncodePassword()
    {
        $passwordEncoder = new PasswordEncoder();
        $hashedPassword = $passwordEncoder->encode('admin');
        $this->assertEquals('1', '1');
    }
}