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

use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Node\AbstractNode;
use SebastianBergmann\CodeCoverage\Node\Directory as DirectoryNode;
use SebastianBergmann\CodeCoverage\Node\File as FileNode;
use SebastianBergmann\CodeCoverage\RuntimeException;
use SebastianBergmann\CodeCoverage\Version;
use SebastianBergmann\Environment\Runtime;

class Facade
{
    /**
     * @var string
     */
    private $target;

    /**
     * @var Project
     */
    private $project;

    /**
     * @var string
     */
    private $phpUnitVersion;

    /**
     * @param string $version
     */
    public function __construct($version)
    {
        $this->phpUnitVersion = $version;
    }

    /**
     * @param CodeCoverage $coverage
     * @param string       $target
     *
     * @throws RuntimeException
     */
    public function process(CodeCoverage $coverage, $target)
    {
        if (substr($target, -1, 1) != DIRECTORY_SEPARATOR) {
            $target .= DIRECTORY_SEPARATOR;
        }

        $this->target = $target;
        $this->initTargetDirectory($target);

        $report = $coverage->getReport();

        $this->project = new Project(
            $coverage->getReport()->getName()
        );

        $this->setBuildInformation();
        $this->processTests($coverage->getTests());
        $this->processDirectory($report, $this->project);

        $this->saveDocument($this->project->asDom(), 'index');
    }

    private function setBuildInformation()
    {
        $buildNode = $this->project->getBuildInformation();
        $buildNode->setRuntimeInformation(new Runtime());
        $buildNode->setBuildTime(\DateTime::createFromFormat('U', $_SERVER['REQUEST_TIME']));
        $buildNode->setGeneratorVersions($this->phpUnitVersion, Version::id());
    }

    /**
     * @param string $directory
     */
    protected function initTargetDirectory($directory)
    {
        if (file_exists($directory)) {
            if (!is_dir($directory)) {
                throw new RuntimeException(
                    "'$directory' exists but is not a directory."
                );
            }

            if (!is_writable($directory)) {
                throw new RuntimeException(
                    "'$directory' exists but is not writable."
                );
            }
        } elseif (!@mkdir($directory, 0777, true)) {
            throw new RuntimeException(
                "'$directory' could not be created."
            );
        }
    }

    private function processDirectory(DirectoryNode $directory, Node $context)
    {
        $dirname = $directory->getName();
        if ($this->project->getProjectSourceDirectory() === $dirname) {
            $dirname = '/';
        }
        $dirObject = $context->addDirectory($dirname);

        $this->setTotals($directory, $dirObject->getTotals());

        foreach ($directory->getDirectories() as $node) {
            $this->processDirectory($node, $dirObject);
        }

        foreach ($directory->getFiles() as $node) {
            $this->processFile($node, $dirObject);
        }
    }

    private function processFile(FileNode $file, Directory $context)
    {
        $fileObject = $context->addFile(
            $file->getName(),
            $file->getId() . '.xml'
        );

        $this->setTotals($file, $fileObject->getTotals());

        $path = substr(
            $file->getPath(),
            strlen($this->project->getProjectSourceDirectory())
        );
        $fileReport = new Report($path);

        $this->setTotals($file, $fileReport->getTotals());

        foreach ($file->getClassesAndTraits() as $unit) {
            $this->processUnit($unit, $fileReport);
        }

        foreach ($file->getFunctions() as $function) {
            $this->processFunction($function, $fileReport);
        }

        foreach ($file->getCoverageData() as $line => $tests) {
            if (!is_array($tests) || count($tests) === 0) {
                continue;
            }

            $coverage = $fileReport->getLineCoverage($line);

            foreach ($tests as $test) {
                $coverage->addTest($test);
            }

            $coverage->finalize();
        }

        $fileReport->getSource()->setSourceCode(
            file_get_contents($file->getPath())
        );

        $this->saveDocument($fileReport->asDom(), $file->getId());
    }

    private function processUnit($unit, Report $report)
    {
        if (isset($unit['className'])) {
            $unitObject = $report->getClassObject($unit['className']);
        } else {
            $unitObject = $report->getTraitObject($unit['traitName']);
        }

        $unitObject->setLines(
            $unit['startLine'],
            $unit['executableLines'],
            $unit['executedLines']
        );

        $unitObject->setCrap($unit['crap']);

        $unitObject->setPackage(
            $unit['package']['fullPackage'],
            $unit['package']['package'],
            $unit['package']['subpackage'],
            $unit['package']['category']
        );

        $unitObject->setNamespace($unit['package']['namespace']);

        foreach ($unit['methods'] as $method) {
            $methodObject = $unitObject->addMethod($method['methodName']);
            $methodObject->setSignature($method['signature']);
            $methodObject->setLines($method['startLine'], $method['endLine']);
            $methodObject->setCrap($method['crap']);
            $methodObject->setTotals(
                $method['executableLines'],
                $method['executedLines'],
                $method['coverage']
            );
        }
    }

    private function processFunction($function, Report $report)
    {
        $functionObject = $report->getFunctionObject($function['functionName']);

        $functionObject->setSignature($function['signature']);
        $functionObject->setLines($function['startLine']);
        $functionObject->setCrap($function['crap']);
        $functionObject->setTotals($function['executableLines'], $function['executedLines'], $function['coverage']);
    }

    private function processTests(array $tests)
    {
        $testsObject = $this->project->getTests();

        foreach ($tests as $test => $result) {
            if ($test == 'UNCOVERED_FILES_FROM_WHITELIST') {
                continue;
            }

            $testsObject->addTest($test, $result);
        }
    }

    private function setTotals(AbstractNode $node, Totals $totals)
    {
        $loc = $node->getLinesOfCode();

        $totals->setNumLines(
            $loc['loc'],
            $loc['cloc'],
            $loc['ncloc'],
            $node->getNumExecutableLines(),
            $node->getNumExecutedLines()
        );

        $totals->setNumClasses(
            $node->getNumClasses(),
            $node->getNumTestedClasses()
        );

        $totals->setNumTraits(
            $node->getNumTraits(),
            $node->getNumTestedTraits()
        );

        $totals->setNumMethods(
            $node->getNumMethods(),
            $node->getNumTestedMethods()
        );

        $totals->setNumFunctions(
            $node->getNumFunctions(),
            $node->getNumTestedFunctions()
        );
    }

    /**
     * @return string
     */
    protected function getTargetDirectory()
    {
        return $this->target;
    }

    protected function saveDocument(\DOMDocument $document, $name)
    {
        $filename = sprintf('%s/%s.xml', $this->getTargetDirectory(), $name);

        $document->formatOutput       = true;
        $document->preserveWhiteSpace = false;
        $this->initTargetDirectory(dirname($filename));

        $document->save($filename);
    }
}
