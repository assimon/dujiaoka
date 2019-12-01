<?php declare(strict_types = 1);
namespace TheSeer\Tokenizer;

use  PHPUnit\Framework\TestCase;

/**
 * @covers \TheSeer\Tokenizer\XMLSerializer
 */
class XMLSerializerTest extends TestCase {

    /** @var TokenCollection $tokens */
    private $tokens;

    protected function setUp() {
        $this->tokens = unserialize(
            file_get_contents(__DIR__ . '/_files/test.php.tokens'),
            [TokenCollection::class]
        );
    }

    public function testCanBeSerializedToXml() {
        $expected = file_get_contents(__DIR__ . '/_files/test.php.xml');

        $serializer = new XMLSerializer();
        $this->assertEquals($expected, $serializer->toXML($this->tokens));
    }

    public function testCanBeSerializedToDomDocument() {
        $serializer = new XMLSerializer();
        $result = $serializer->toDom($this->tokens);

        $this->assertInstanceOf(\DOMDocument::class, $result);
        $this->assertEquals('source', $result->documentElement->localName);
    }

    public function testCanBeSerializedToXmlWithCustomNamespace() {
        $expected = file_get_contents(__DIR__ . '/_files/customns.xml');

        $serializer = new XMLSerializer(new NamespaceUri('custom:xml:namespace'));
        $this->assertEquals($expected, $serializer->toXML($this->tokens));
    }

    public function testEmptyCollectionCreatesEmptyDocument() {
        $expected = file_get_contents(__DIR__ . '/_files/empty.xml');

        $serializer = new XMLSerializer();
        $this->assertEquals($expected, $serializer->toXML((new TokenCollection())));
    }

}
