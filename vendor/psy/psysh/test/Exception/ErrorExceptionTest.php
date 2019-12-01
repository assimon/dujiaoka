<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Exception;

use Psy\Exception\ErrorException;

class ErrorExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testInstance()
    {
        $e = new ErrorException();

        $this->assertInstanceOf('Psy\Exception\Exception', $e);
        $this->assertInstanceOf('ErrorException', $e);
        $this->assertInstanceOf('Psy\Exception\ErrorException', $e);
    }

    public function testMessage()
    {
        $e = new ErrorException('foo');

        $this->assertContains('foo', $e->getMessage());
        $this->assertSame('foo', $e->getRawMessage());
    }

    /**
     * @dataProvider getLevels
     */
    public function testErrorLevels($level, $type)
    {
        $e = new ErrorException('foo', 0, $level);
        $this->assertContains('PHP ' . $type, $e->getMessage());
    }

    /**
     * @dataProvider getLevels
     */
    public function testThrowException($level, $type)
    {
        try {
            ErrorException::throwException($level, '{whot}', '{file}', '13');
        } catch (ErrorException $e) {
            $this->assertContains('PHP ' . $type, $e->getMessage());
            $this->assertContains('{whot}', $e->getMessage());
            $this->assertContains('in {file}', $e->getMessage());
            $this->assertContains('on line 13', $e->getMessage());
        }
    }

    public function getLevels()
    {
        return [
            [E_WARNING,           'Warning'],
            [E_CORE_WARNING,      'Warning'],
            [E_COMPILE_WARNING,   'Warning'],
            [E_USER_WARNING,      'Warning'],
            [E_STRICT,            'Strict error'],
            [E_DEPRECATED,        'Deprecated'],
            [E_USER_DEPRECATED,   'Deprecated'],
            [E_RECOVERABLE_ERROR, 'Recoverable fatal error'],
            [0,                   'Error'],
        ];
    }

    /**
     * @dataProvider getUserLevels
     */
    public function testThrowExceptionAsErrorHandler($level, $type)
    {
        \set_error_handler(['Psy\Exception\ErrorException', 'throwException']);
        try {
            \trigger_error('{whot}', $level);
        } catch (ErrorException $e) {
            $this->assertContains('PHP ' . $type, $e->getMessage());
            $this->assertContains('{whot}', $e->getMessage());
        }
        \restore_error_handler();
    }

    public function getUserLevels()
    {
        return [
            [E_USER_ERROR,      'Error'],
            [E_USER_WARNING,    'Warning'],
            [E_USER_NOTICE,     'Notice'],
            [E_USER_DEPRECATED, 'Deprecated'],
        ];
    }

    public function testIgnoreExecutionLoopFilename()
    {
        $e = new ErrorException('{{message}}', 0, 1, '/fake/path/to/Psy/ExecutionLoop.php');
        $this->assertEmpty($e->getFile());

        $e = new ErrorException('{{message}}', 0, 1, 'c:\fake\path\to\Psy\ExecutionLoop.php');
        $this->assertEmpty($e->getFile());

        $e = new ErrorException('{{message}}', 0, 1, '/fake/path/to/Psy/File.php');
        $this->assertNotEmpty($e->getFile());
    }

    public function testFromError()
    {
        if (\version_compare(PHP_VERSION, '7.0.0', '<')) {
            $this->markTestSkipped();
        }

        $error = new \Error('{{message}}', 0);
        $exception = ErrorException::fromError($error);

        $this->assertContains('PHP Error:  {{message}}', $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
        $this->assertEquals($error->getFile(), $exception->getFile());
        $this->assertSame($exception->getPrevious(), $error);
    }
}
