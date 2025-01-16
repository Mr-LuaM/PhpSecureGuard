<?php

namespace Markl\PhpSecureGuard;

class SecurityHeaders
{
    private $headers = [];

    public function addCSP(string $policy): self
    {
        $this->headers['Content-Security-Policy'] = $policy;
        return $this;
    }

    public function addHSTS(int $maxAge = 31536000, bool $includeSubdomains = true): self
    {
        $policy = "max-age={$maxAge}";
        if ($includeSubdomains) {
            $policy .= "; includeSubDomains";
        }
        $this->headers['Strict-Transport-Security'] = $policy;
        return $this;
    }

    // Get the headers for testing or further processing
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
