<?php

require 'vendor/autoload.php';

use Markl\PhpSecureGuard\InputSanitizer;
use Markl\PhpSecureGuard\CsrfProtection;

$sanitizer = new InputSanitizer();
$csrf = new CsrfProtection();

// Example: Sanitization
$input = "   <script>alert('Hello');</script> ";
echo "Sanitized Input: " . $sanitizer->sanitize($input) . PHP_EOL;

// Example: Email Validation
$email = "test@example.com";
echo "Is Valid Email? " . ($sanitizer->validateEmail($email) ? "Yes" : "No") . PHP_EOL;

// Example: URL Validation
$url = "https://example.com";
echo "Is Valid URL? " . ($sanitizer->validateUrl($url) ? "Yes" : "No") . PHP_EOL;

// Example: Generate a token and inject it into a form
echo "Hidden Input for Form:";
echo $csrf->getHiddenInput();

// Example: Validate a submitted token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['csrf_token'] ?? '';
    if ($csrf->validateToken($submittedToken)) {
        echo "CSRF token is valid!";
    } else {
        echo "CSRF token is invalid!";
    }
}
