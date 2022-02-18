<?php

namespace Test;

use Tests\Support\TestCase;

class CryptoJsAesTest extends TestCase
{
    protected $value = "Hello!";
    protected $password = "hello";

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    public function testEncryptDecryptWithKey()
    {
        $result = \Daycry\Encryption\CryptoJsAes::encrypt($this->value, $this->password, true);

        $textPlain = \Daycry\Encryption\CryptoJsAes::decrypt($result);

        $this->assertEquals($this->value, $textPlain);
    }

    public function testEncryptDecryptWithoutKey()
    {
        $result = \Daycry\Encryption\CryptoJsAes::encrypt($this->value, $this->password, false);

        $textPlain = \Daycry\Encryption\CryptoJsAes::decrypt($result, $this->password);

        $this->assertEquals($this->value, $textPlain);
    }

    public function testDecryptWithPassword()
    {
        $textPlain = \Daycry\Encryption\CryptoJsAes::decrypt('{"ct":"cXHyaPKB/kcY3g2DpsAztw==","iv":"d7cf99b9835c8373546a6c46294394c6","s":"bd2991eed317974b06d0522b8df4934d1679461bd1420c645cf309887d4da048619a1fcbeb6d119b22872c795c54aab870547a9e9f16eaf7bfb5c764e6d7472d2c43ae4057d25d9cb3bde45ee0e5ce035557b0d2e2ae55dfd848da744a795b3ba6fc524bad4c0f65209454593456ab7a40ece90731cdf2bbb7e9e1cfbabc2adf2643433181011b97da0ea7ce106bb467c4f397232961d84602e9017bf0d4e6b6a9c912007671a00f3cbcf2c084ce6d1cf0b129b28d52396e8796044fca266c2d1de4774b55b5fb8b01a5185b4b6779ad4e5c76de9e196672391236d5cef8c75e6e734f15d092d5aed1cc7f5810f306f329a2364b342268f29e7ab6d03f9cd89e","iterations":999}', $this->password);

        $this->assertEquals('hello text', $textPlain);
    }

    public function testDecryptWithoutPassword()
    {
        $textPlain = \Daycry\Encryption\CryptoJsAes::decrypt('{"ct":"cXHyaPKB/kcY3g2DpsAztw==","iv":"d7cf99b9835c8373546a6c46294394c6","s":"bd2991eed317974b06d0522b8df4934d1679461bd1420c645cf309887d4da048619a1fcbeb6d119b22872c795c54aab870547a9e9f16eaf7bfb5c764e6d7472d2c43ae4057d25d9cb3bde45ee0e5ce035557b0d2e2ae55dfd848da744a795b3ba6fc524bad4c0f65209454593456ab7a40ece90731cdf2bbb7e9e1cfbabc2adf2643433181011b97da0ea7ce106bb467c4f397232961d84602e9017bf0d4e6b6a9c912007671a00f3cbcf2c084ce6d1cf0b129b28d52396e8796044fca266c2d1de4774b55b5fb8b01a5185b4b6779ad4e5c76de9e196672391236d5cef8c75e6e734f15d092d5aed1cc7f5810f306f329a2364b342268f29e7ab6d03f9cd89e","iterations":999,"k":"68656c6c6f"}');

        $this->assertEquals('hello text', $textPlain);
    }

    public function testEncryptDecryptWithoutKeyFailed()
    {
        $result = \Daycry\Encryption\CryptoJsAes::encrypt($this->value, $this->password, false);

        $textPlain = \Daycry\Encryption\CryptoJsAes::decrypt($result);

        $this->assertFalse($textPlain);
    }
}
