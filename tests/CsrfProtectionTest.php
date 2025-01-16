<?php

use PHPUnit\Framework\TestCase;
use Markl\PhpSecureGuard\CsrfProtection;

class CsrfProtectionTest extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Start a session for testing
        }
    }

    public function testGenerateToken()
    {
        $csrf = new CsrfProtection();
        $token = $csrf->generateToken();

        $this->assertNotEmpty($token);
        $this->assertEquals($token, $_SESSION['csrf_token']);
    }

    public function testValidateToken()
    {
        $csrf = new CsrfProtection();
        $token = $csrf->generateToken();

        $this->assertTrue($csrf->validateToken($token)); // Correct token
        $this->assertFalse($csrf->validateToken('invalid-token')); // Incorrect token
    }

    public function testGetHiddenInput()
    {
        $csrf = new CsrfProtection();
        $hiddenInput = $csrf->getHiddenInput();

        $this->assertStringContainsString('<input type="hidden"', $hiddenInput);
        $this->assertStringContainsString('name="csrf_token"', $hiddenInput);
    }
}
