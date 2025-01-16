<?php

namespace Markl\PhpSecureGuard;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Logger
{
    private LoggerInterface $logger;

    public function __construct(?LoggerInterface $logger = null)
    {
        $this->logger = $logger ?? new NullLogger(); // Use NullLogger by default
    }

    // Log a security event
    public function log(string $level, string $message, array $context = []): void
    {
        $this->logger->log($level, $message, $context);
    }

    // Shortcut for logging warnings
    public function warning(string $message, array $context = []): void
    {
        $this->log('warning', $message, $context);
    }

    // Shortcut for logging errors
    public function error(string $message, array $context = []): void
    {
        $this->log('error', $message, $context);
    }

    // Shortcut for logging info
    public function info(string $message, array $context = []): void
    {
        $this->log('info', $message, $context);
    }
}
