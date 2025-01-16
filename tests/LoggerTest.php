<?php

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Markl\PhpSecureGuard\Logger;

class LoggerTest extends TestCase
{
    public function testCustomLogger()
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger->expects($this->once())
            ->method('log')
            ->with('info', 'Test message', []);

        $logger = new Logger($mockLogger);
        $logger->info('Test message');
    }

    public function testDefaultLogger()
    {
        $logger = new Logger();
        $this->expectNotToPerformAssertions(); // NullLogger doesn't perform any operations
        $logger->info('This will not log anything');
    }
}
