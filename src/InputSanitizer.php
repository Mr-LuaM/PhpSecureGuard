<?php

namespace Markl\PhpSecureGuard;

class InputSanitizer
{
    // Sanitize input by trimming, stripping tags, and converting special characters
    public function sanitize(string $input, bool $stripTags = false): string
    {
        $sanitized = trim($input);
        if ($stripTags) {
            $sanitized = strip_tags($sanitized);
        }
        return htmlspecialchars($sanitized, ENT_QUOTES, 'UTF-8');
    }


    // Validate input as an email
    public function validateEmail(string $input): bool
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Validate input as a URL
    public function validateUrl(string $input): bool
    {
        return filter_var($input, FILTER_VALIDATE_URL) !== false;
    }

    // Validate input as an integer
    public function validateInt(string $input): bool
    {
        return filter_var($input, FILTER_VALIDATE_INT) !== false;
    }
}
