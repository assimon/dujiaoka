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

class Project extends Node
{
    /**
     * @param string $directory
     */
    public function __construct($directory)
    {
        $this->init();
        $this->setProjectSourceDirectory($directory);
    }

    private function init()
    {
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" ?><phpunit xmlns="http://schema.phpunit.de/coverage/1.0"><build/><project/></phpunit>');

        $this->setContextNode(
            $dom->getElementsByTagNameNS(
                'http://schema.phpunit.de/coverage/1.0',
                'project'
            )->item(0)
        );
    }

    private function setProjectSourceDirectory($name)
    {
        $this->getContextNode()->setAttribute('source', $name);
    }

    /**
     * @return string
     */
    public function getProjectSourceDirectory()
    {
        return $this->getContextNode()->getAttribute('source');
    }

    /**
     * @return BuildInformation
     */
    public function getBuildInformation()
    {
        $buildNode = $this->getDom()->getElementsByTagNameNS(
            'http://schema.phpunit.de/coverage/1.0',
            'build'
        )->item(0);

        if (!$buildNode) {
            $buildNode = $this->getDom()->documentElement->appendChild(
                $this->getDom()->createElementNS(
                    'http://schema.phpunit.de/coverage/1.0',
                    'build'
                )
            );
        }

        return new BuildInformation($buildNode);
    }

    public function getTests()
    {
        $testsNode = $this->getContextNode()->getElementsByTagNameNS(
            'http://schema.phpunit.de/coverage/1.0',
            'tests'
        )->item(0);

        if (!$testsNode) {
            $testsNode = $this->getContextNode()->appendChild(
                $this->getDom()->createElementNS(
                    'http://schema.phpunit.de/coverage/1.0',
                    'tests'
                )
            );
        }

        return new Tests($testsNode);
    }

    public function asDom()
    {
        return $this->getDom();
    }
}
