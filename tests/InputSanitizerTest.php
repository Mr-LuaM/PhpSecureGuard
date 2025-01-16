<?php

use PHPUnit\Framework\TestCase;
use Markl\PhpSecureGuard\InputSanitizer;

class InputSanitizerTest extends TestCase
{
    public function testSanitize()
    {
        $sanitizer = new InputSanitizer();

        $dirtyInput = "   <script>alert('XSS');</script> ";
        $sanitized = $sanitizer->sanitize($dirtyInput, false); // Retain and escape tags
        $this->assertEquals("&lt;script&gt;alert(&#039;XSS&#039;);&lt;/script&gt;", $sanitized);
    }


    public function testValidateEmail()
    {
        $sanitizer = new InputSanitizer();

        $validEmail = "test@example.com";
        $invalidEmail = "invalid-email";

        $this->assertTrue($sanitizer->validateEmail($validEmail));
        $this->assertFalse($sanitizer->validateEmail($invalidEmail));
    }

    public function testValidateUrl()
    {
        $sanitizer = new InputSanitizer();

        $validUrl = "https://example.com";
        $invalidUrl = "not-a-url";

        $this->assertTrue($sanitizer->validateUrl($validUrl));
        $this->assertFalse($sanitizer->validateUrl($invalidUrl));
    }

    public function testValidateInt()
    {
        $sanitizer = new InputSanitizer();

        $validInt = "123";
        $invalidInt = "123abc";

        $this->assertTrue($sanitizer->validateInt($validInt));
        $this->assertFalse($sanitizer->validateInt($invalidInt));
    }
}
