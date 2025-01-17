<?php

namespace Markl\PhpSecureGuard;

use Psr\Log\LoggerInterface;

class RateLimiter
{
    private array $requests = [];
    private int $maxRequests;
    private int $timeWindow; // Time window in seconds
    private LoggerInterface $logger;

    public function __construct(int $maxRequests, int $timeWindow, LoggerInterface $logger)
    {
        $this->maxRequests = $maxRequests;
        $this->timeWindow = $timeWindow;
        $this->logger = $logger;
    }

    // Check if a request is allowed for a given identifier (e.g., IP or user ID)
    public function isAllowed(string $identifier): bool
    {
        $currentTime = time();

        // Initialize request log for the identifier if not set
        if (!isset($this->requests[$identifier])) {
            $this->requests[$identifier] = [];
        }

        // Remove expired requests
        $this->requests[$identifier] = array_filter(
            $this->requests[$identifier],
            fn($timestamp) => $timestamp > $currentTime - $this->timeWindow
        );

        // Allow the request if under the limit
        if (count($this->requests[$identifier]) < $this->maxRequests) {
            $this->requests[$identifier][] = $currentTime;
            return true;
        }

        // Log the rate limit breach
        $this->logger->warning("Rate limit exceeded for identifier: {$identifier}");
        return false;
    }
}
