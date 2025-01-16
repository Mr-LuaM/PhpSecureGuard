<?php

use PHPUnit\Framework\TestCase;
use Markl\PhpSecureGuard\SecurityHeaders;

class SecurityHeadersTest extends TestCase
{
    public function testAddCSP()
    {
        $security = new SecurityHeaders();
        $security->addCSP("default-src 'self'");
        $this->assertEquals(
            ['Content-Security-Policy' => "default-src 'self'"],
            $security->getHeaders()
        );
    }

    public function testAddHSTS()
    {
        $security = new SecurityHeaders();
        $security->addHSTS(31536000, true);
        $this->assertEquals(
            ['Strict-Transport-Security' => "max-age=31536000; includeSubDomains"],
            $security->getHeaders()
        );
    }
}
