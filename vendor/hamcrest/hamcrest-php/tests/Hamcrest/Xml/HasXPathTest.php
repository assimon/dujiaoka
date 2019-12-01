<?php
namespace Hamcrest\Xml;

class HasXPathTest extends \Hamcrest\AbstractMatcherTest
{
    protected static $xml;
    protected static $doc;
    protected static $html;

    public static function setUpBeforeClass()
    {
        self::$xml = <<<XML
<?xml version="1.0"?>
<users>
    <user>
        <id>alice</id>
        <name>Alice Frankel</name>
        <role>admin</role>
    </user>
    <user>
        <id>bob</id>
        <name>Bob Frankel</name>
        <role>user</role>
    </user>
    <user>
        <id>charlie</id>
        <name>Charlie Chan</name>
        <role>user</role>
    </user>
</users>
XML;
        self::$doc = new \DOMDocument();
        self::$doc->loadXML(self::$xml);

        self::$html = <<<HTML
<html>
    <head>
        <title>Home Page</title>
    </head>
    <body>
        <h1>Heading</h1>
        <p>Some text</p>
    </body>
</html>
HTML;
    }

    protected function createMatcher()
    {
        return \Hamcrest\Xml\HasXPath::hasXPath('/users/user');
    }

    public function testMatchesWhenXPathIsFound()
    {
        assertThat('one match', self::$doc, hasXPath('user[id = "bob"]'));
        assertThat('two matches', self::$doc, hasXPath('user[role = "user"]'));
    }

    public function testDoesNotMatchWhenXPathIsNotFound()
    {
        assertThat(
            'no match',
            self::$doc,
            not(hasXPath('user[contains(id, "frank")]'))
        );
    }

    public function testMatchesWhenExpressionWithoutMatcherEvaluatesToTrue()
    {
        assertThat(
            'one match',
            self::$doc,
            hasXPath('count(user[id = "bob"])')
        );
    }

    public function testDoesNotMatchWhenExpressionWithoutMatcherEvaluatesToFalse()
    {
        assertThat(
            'no matches',
            self::$doc,
            not(hasXPath('count(user[id = "frank"])'))
        );
    }

    public function testMatchesWhenExpressionIsEqual()
    {
        assertThat(
            'one match',
            self::$doc,
            hasXPath('count(user[id = "bob"])', 1)
        );
        assertThat(
            'two matches',
            self::$doc,
            hasXPath('count(user[role = "user"])', 2)
        );
    }

    public function testDoesNotMatchWhenExpressionIsNotEqual()
    {
        assertThat(
            'no match',
            self::$doc,
            not(hasXPath('count(user[id = "frank"])', 2))
        );
        assertThat(
            'one match',
            self::$doc,
            not(hasXPath('count(user[role = "admin"])', 2))
        );
    }

    public function testMatchesWhenContentMatches()
    {
        assertThat(
            'one match',
            self::$doc,
            hasXPath('user/name', containsString('ice'))
        );
        assertThat(
            'two matches',
            self::$doc,
            hasXPath('user/role', equalTo('user'))
        );
    }

    public function testDoesNotMatchWhenContentDoesNotMatch()
    {
        assertThat(
            'no match',
            self::$doc,
            not(hasXPath('user/name', containsString('Bobby')))
        );
        assertThat(
            'no matches',
            self::$doc,
            not(hasXPath('user/role', equalTo('owner')))
        );
    }

    public function testProvidesConvenientShortcutForHasXPathEqualTo()
    {
        assertThat('matches', self::$doc, hasXPath('count(user)', 3));
        assertThat('matches', self::$doc, hasXPath('user[2]/id', 'bob'));
    }

    public function testProvidesConvenientShortcutForHasXPathCountEqualTo()
    {
        assertThat('matches', self::$doc, hasXPath('user[id = "charlie"]', 1));
    }

    public function testMatchesAcceptsXmlString()
    {
        assertThat('accepts XML string', self::$xml, hasXPath('user'));
    }

    public function testMatchesAcceptsHtmlString()
    {
        assertThat('accepts HTML string', self::$html, hasXPath('body/h1', 'Heading'));
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription(
            'XML or HTML document with XPath "/users/user"',
            hasXPath('/users/user')
        );
        $this->assertDescription(
            'XML or HTML document with XPath "count(/users/user)" <2>',
            hasXPath('/users/user', 2)
        );
        $this->assertDescription(
            'XML or HTML document with XPath "/users/user/name"'
            . ' a string starting with "Alice"',
            hasXPath('/users/user/name', startsWith('Alice'))
        );
    }

    public function testHasAReadableMismatchDescription()
    {
        $this->assertMismatchDescription(
            'XPath returned no results',
            hasXPath('/users/name'),
            self::$doc
        );
        $this->assertMismatchDescription(
            'XPath expression result was <3F>',
            hasXPath('/users/user', 2),
            self::$doc
        );
        $this->assertMismatchDescription(
            'XPath returned ["alice", "bob", "charlie"]',
            hasXPath('/users/user/id', 'Frank'),
            self::$doc
        );
    }
}
