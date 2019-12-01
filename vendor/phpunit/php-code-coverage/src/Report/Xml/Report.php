<?php
/*
 * This file is part of the php-code-coverage package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianBergmann\CodeCoverage\Report\Xml;

class Report extends File
{
    public function __construct($name)
    {
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" ?><phpunit xmlns="http://schema.phpunit.de/coverage/1.0"><file /></phpunit>');

        $contextNode = $dom->getElementsByTagNameNS(
            'http://schema.phpunit.de/coverage/1.0',
            'file'
        )->item(0);

        parent::__construct($contextNode);
        $this->setName($name);
    }

    private function setName($name)
    {
        $this->getContextNode()->setAttribute('name', basename($name));
        $this->getContextNode()->setAttribute('path', dirname($name));
    }

    public function asDom()
    {
        return $this->getDomDocument();
    }

    public function getFunctionObject($name)
    {
        $node = $this->getContextNode()->appendChild(
            $this->getDomDocument()->createElementNS(
                'http://schema.phpunit.de/coverage/1.0',
                'function'
            )
        );

        return new Method($node, $name);
    }

    public function getClassObject($name)
    {
        return $this->getUnitObject('class', $name);
    }

    public function getTraitObject($name)
    {
        return $this->getUnitObject('trait', $name);
    }

    private function getUnitObject($tagName, $name)
    {
        $node = $this->getContextNode()->appendChild(
            $this->getDomDocument()->createElementNS(
                'http://schema.phpunit.de/coverage/1.0',
                $tagName
            )
        );

        return new Unit($node, $name);
    }

    public function getSource()
    {
        $source = $this->getContextNode()->getElementsByTagNameNS(
            'http://schema.phpunit.de/coverage/1.0',
            'source'
        )->item(0);

        if (!$source) {
            $source = $this->getContextNode()->appendChild(
                $this->getDomDocument()->createElementNS(
                    'http://schema.phpunit.de/coverage/1.0',
                    'source'
                )
            );
        }

        return new Source($source);
    }
}
