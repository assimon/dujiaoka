<?php declare(strict_types = 1);
namespace TheSeer\Tokenizer;

use PHPUnit\Framework\TestCase;

/**
 * @covers \TheSeer\Tokenizer\NamespaceUri
 */
class NamespaceUriTest extends TestCase {

    public function testCanBeConstructedWithValidNamespace() {
        $this->assertInstanceOf(
            NamespaceUri::class,
            new NamespaceUri('a:b')
        );
    }

    public function testInvalidNamespaceThrowsException() {
        $this->expectException(NamespaceUriException::class);
        new NamespaceUri('invalid-no-colon');
    }

    public function testStringRepresentationCanBeRetrieved() {
        $this->assertEquals(
            'a:b',
            (new NamespaceUri('a:b'))->asString()
        );
    }
}
