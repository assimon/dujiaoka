<?php

namespace Mockery\Generator\StringManipulation\Pass;

use Mockery\Generator\MockConfiguration;

class ConstantsPass implements Pass
{
    public function apply($code, MockConfiguration $config)
    {
        $cm = $config->getConstantsMap();
        if (empty($cm)) {
            return $code;
        }

        if (!isset($cm[$config->getName()])) {
            return $code;
        }

        $cm = $cm[$config->getName()];

        $constantsCode = '';
        foreach ($cm as $constant => $value) {
            $constantsCode .= sprintf("\n    const %s = '%s';\n", $constant, $value);
        }

        $i = strrpos($code, '}');
        $code = substr_replace($code, $constantsCode, $i);
        $code .= "}\n";

        return $code;
    }
}
