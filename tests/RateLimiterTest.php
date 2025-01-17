<?php

use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Markl\PhpSecureGuard\RateLimiter;

class RateLimiterTest extends TestCase
{
    public function testAllowsUnderLimit()
    {
        $rateLimiter = new RateLimiter(5, 60, new NullLogger());

        $identifier = 'user123';
        for ($i = 0; $i < 5; $i++) {
            $this->assertTrue($rateLimiter->isAllowed($identifier));
        }
    }

    public function testBlocksOverLimit()
    {
        $rateLimiter = new RateLimiter(3, 60, new NullLogger());

        $identifier = 'user123';
        for ($i = 0; $i < 3; $i++) {
            $this->assertTrue($rateLimiter->isAllowed($identifier));
        }

        $this->assertFalse($rateLimiter->isAllowed($identifier)); // 4th request blocked
    }

    public function testResetsAfterTimeWindow()
    {
        $rateLimiter = new RateLimiter(2, 1, new NullLogger());

        $identifier = 'user123';
        $this->assertTrue($rateLimiter->isAllowed($identifier));
        $this->assertTrue($rateLimiter->isAllowed($identifier));

        // Wait for time window to expire
        sleep(2);

        $this->assertTrue($rateLimiter->isAllowed($identifier)); // Allowed after reset
    }
}
