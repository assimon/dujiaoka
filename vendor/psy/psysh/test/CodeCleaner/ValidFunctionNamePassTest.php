<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\CodeCleaner;

use Psy\CodeCleaner\ValidFunctionNamePass;

class ValidFunctionNamePassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        $this->setPass(new ValidFunctionNamePass());
    }

    /**
     * @dataProvider getInvalidFunctions
     * @expectedException \Psy\Exception\FatalErrorException
     */
    public function testProcessInvalidFunctionCallsAndDeclarations($code)
    {
        $this->parseAndTraverse($code);
    }

    public function getInvalidFunctions()
    {
        return [
            // function declarations
            ['function array_merge() {}'],
            ['function Array_Merge() {}'],
            ['
                function psy_test_codecleaner_validfunctionnamepass_alpha() {}
                function psy_test_codecleaner_validfunctionnamepass_alpha() {}
            '],
            ['
                namespace Psy\\Test\\CodeCleaner\\ValidFunctionNamePass {
                    function beta() {}
                }
                namespace Psy\\Test\\CodeCleaner\\ValidFunctionNamePass {
                    function beta() {}
                }
            '],

            // function calls
            ['psy_test_codecleaner_validfunctionnamepass_gamma()'],
            ['
                namespace Psy\\Test\\CodeCleaner\\ValidFunctionNamePass {
                    delta();
                }
            '],

            // recursion
            ['function a() { a(); } function a() {}'],
        ];
    }

    /**
     * @dataProvider getValidFunctions
     */
    public function testProcessValidFunctionCallsAndDeclarations($code)
    {
        $this->parseAndTraverse($code);
        $this->assertTrue(true);
    }

    public function getValidFunctions()
    {
        return [
            ['function psy_test_codecleaner_validfunctionnamepass_epsilon() {}'],
            ['
                namespace Psy\\Test\\CodeCleaner\\ValidFunctionNamePass {
                    function zeta() {}
                }
            '],
            ['
                namespace {
                    function psy_test_codecleaner_validfunctionnamepass_eta() {}
                }
                namespace Psy\\Test\\CodeCleaner\\ValidFunctionNamePass {
                    function psy_test_codecleaner_validfunctionnamepass_eta() {}
                }
            '],
            ['
                namespace Psy\\Test\\CodeCleaner\\ValidFunctionNamePass {
                    function psy_test_codecleaner_validfunctionnamepass_eta() {}
                }
                namespace {
                    function psy_test_codecleaner_validfunctionnamepass_eta() {}
                }
            '],
            ['
                namespace Psy\\Test\\CodeCleaner\\ValidFunctionNamePass {
                    function array_merge() {}
                }
            '],

            // function calls
            ['array_merge();'],
            ['
                namespace Psy\\Test\\CodeCleaner\\ValidFunctionNamePass {
                    function theta() {}
                }
                namespace Psy\\Test\\CodeCleaner\\ValidFunctionNamePass {
                    theta();
                }
            '],
            // closures
            ['$test = function(){};$test()'],
            ['
                namespace Psy\\Test\\CodeCleaner\\ValidFunctionNamePass {
                    function theta() {}
                }
                namespace {
                    Psy\\Test\\CodeCleaner\\ValidFunctionNamePass\\theta();
                }
            '],

            // recursion
            ['function a() { a(); }'],

            // conditionally defined functions
            ['
                function a() {}
                if (false) {
                    function a() {}
                }
            '],
            ['
                function a() {}
                if (true) {
                    function a() {}
                } else if (false) {
                    function a() {}
                } else {
                    function a() {}
                }
            '],
            // ewww
            ['
                function a() {}
                if (true):
                    function a() {}
                elseif (false):
                    function a() {}
                else:
                    function a() {}
                endif;
            '],
            ['
                function a() {}
                while (false) { function a() {} }
            '],
            ['
                function a() {}
                do { function a() {} } while (false);
            '],
            ['
                function a() {}
                switch (1) {
                    case 0:
                        function a() {}
                        break;
                    case 1:
                        function a() {}
                        break;
                    case 2:
                        function a() {}
                        break;
                }
            '],
        ];
    }
}
