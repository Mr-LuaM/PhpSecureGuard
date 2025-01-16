<?php

namespace Markl\PhpSecureGuard;

class Encryption
{
    private string $method;
    private string $key;

    public function __construct(string $key, string $method = 'aes-256-cbc')
    {
        if (!in_array($method, openssl_get_cipher_methods())) {
            throw new \InvalidArgumentException("Invalid encryption method: {$method}");
        }

        $this->method = $method;
        $this->key = hash('sha256', $key); // Ensure the key is hashed for proper length
    }

    // Encrypt data
    public function encrypt(string $data): string
    {
        $ivLength = openssl_cipher_iv_length($this->method);
        $iv = openssl_random_pseudo_bytes($ivLength);

        $encrypted = openssl_encrypt($data, $this->method, $this->key, 0, $iv);

        if ($encrypted === false) {
            throw new \RuntimeException("Encryption failed");
        }

        // Return the encrypted data with IV as a base64 string
        return base64_encode($iv . $encrypted);
    }

    // Decrypt data
    public function decrypt(string $encryptedData): string
    {
        $data = base64_decode($encryptedData);
        $ivLength = openssl_cipher_iv_length($this->method);

        // Extract the IV and encrypted data
        $iv = substr($data, 0, $ivLength);
        $encrypted = substr($data, $ivLength);

        // Validate IV length
        if (strlen($iv) !== $ivLength) {
            throw new \RuntimeException("Invalid IV length: expected {$ivLength} bytes, got " . strlen($iv));
        }

        $decrypted = openssl_decrypt($encrypted, $this->method, $this->key, 0, $iv);

        if ($decrypted === false) {
            throw new \RuntimeException("Decryption failed");
        }

        return $decrypted;
    }
}
