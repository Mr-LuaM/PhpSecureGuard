<?php

namespace Markl\PhpSecureGuard;

class CsrfProtection
{
    private string $sessionKey;

    public function __construct(string $sessionKey = 'csrf_token')
    {
        $this->sessionKey = $sessionKey;

        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Start the session if it hasn't already been started
        }
    }

    // Generate a CSRF token and store it in the session
    public function generateToken(): string
    {
        $token = bin2hex(random_bytes(32)); // Generate a secure random token
        $_SESSION[$this->sessionKey] = $token;
        return $token;
    }

    // Validate the CSRF token from the form
    public function validateToken(string $submittedToken): bool
    {
        if (!isset($_SESSION[$this->sessionKey])) {
            return false;
        }

        $storedToken = $_SESSION[$this->sessionKey];
        return hash_equals($storedToken, $submittedToken); // Prevent timing attacks
    }

    // Add CSRF token as a hidden input field for forms
    public function getHiddenInput(): string
    {
        $token = $this->generateToken();
        return sprintf('<input type="hidden" name="%s" value="%s">', $this->sessionKey, $token);
    }
}
