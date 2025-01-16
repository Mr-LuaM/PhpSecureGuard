<?php

require 'vendor/autoload.php';

use Markl\PhpSecureGuard\InputSanitizer;

$sanitizer = new InputSanitizer();

// Example: Sanitization
$input = "   <script>alert('Hello');</script> ";
echo "Sanitized Input: " . $sanitizer->sanitize($input) . PHP_EOL;

// Example: Email Validation
$email = "test@example.com";
echo "Is Valid Email? " . ($sanitizer->validateEmail($email) ? "Yes" : "No") . PHP_EOL;

// Example: URL Validation
$url = "https://example.com";
echo "Is Valid URL? " . ($sanitizer->validateUrl($url) ? "Yes" : "No") . PHP_EOL;
