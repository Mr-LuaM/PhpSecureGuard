<?php

use PHPUnit\Framework\TestCase;
use Markl\PhpSecureGuard\Encryption;

class EncryptionTest extends TestCase
{
    private string $key = 'supersecretkey';

    public function testEncryptAndDecrypt()
    {
        $encryption = new Encryption($this->key);

        $data = "This is a test string";
        $encrypted = $encryption->encrypt($data);
        $decrypted = $encryption->decrypt($encrypted);

        $this->assertNotEquals($data, $encrypted); // Encrypted data should not match the original
        $this->assertEquals($data, $decrypted); // Decrypted data should match the original
    }

    public function testInvalidDecryption()
    {
        $encryption = new Encryption($this->key);

        $this->expectException(\RuntimeException::class);
        $encryption->decrypt("invalid-data");
    }
}
