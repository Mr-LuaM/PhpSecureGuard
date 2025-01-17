<?php

require 'vendor/autoload.php';

use Markl\PhpSecureGuard\InputSanitizer;
use Markl\PhpSecureGuard\CsrfProtection;
use Markl\PhpSecureGuard\Encryption;

use Markl\PhpSecureGuard\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;
use Markl\PhpSecureGuard\RateLimiter;

$sanitizer = new InputSanitizer();
$csrf = new CsrfProtection();
$key = "supersecretkey";
$encryption = new Encryption($key);
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
// Example: Encrypt data
$data = "Sensitive information";
$encryptedData = $encryption->encrypt($data);
echo "Encrypted: " . $encryptedData . PHP_EOL;

// Example: Decrypt data
$decryptedData = $encryption->decrypt($encryptedData);
echo "Decrypted: " . $decryptedData . PHP_EOL;
// Example: Using Monolog as the PSR-3 Logger
$monolog = new MonologLogger('php-secure-guard');
$monolog->pushHandler(new StreamHandler('php://stdout'));

$logger = new Logger($monolog);
$logger->info('This is an informational message.');
$logger->warning('This is a warning message.');
$logger->error('This is an error message.');

// Example: Using Default Logger (NullLogger)
$defaultLogger = new Logger();
$defaultLogger->info('This will not output anything.');
// Setup Monolog logger
$logger = new MonologLogger('rate_limiter');
$logger->pushHandler(new StreamHandler('php://stdout'));

// Create a RateLimiter instance
$rateLimiter = new RateLimiter(5, 60, $logger);

// Simulate requests
$identifier = 'user123';
for ($i = 0; $i < 7; $i++) {
    if ($rateLimiter->isAllowed($identifier)) {
        echo "Request {$i} allowed\n";
    } else {
        echo "Request {$i} blocked\n";
    }
}
