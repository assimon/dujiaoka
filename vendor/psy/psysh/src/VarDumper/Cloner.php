<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\VarDumper;

use Symfony\Component\VarDumper\Caster\Caster;
use Symfony\Component\VarDumper\Cloner\Stub;
use Symfony\Component\VarDumper\Cloner\VarCloner;

/**
 * A PsySH-specialized VarCloner.
 */
class Cloner extends VarCloner
{
    private $filter = 0;

    /**
     * {@inheritdoc}
     */
    public function cloneVar($var, $filter = 0)
    {
        $this->filter = $filter;

        return parent::cloneVar($var, $filter);
    }

    /**
     * {@inheritdoc}
     */
    protected function castResource(Stub $stub, $isNested)
    {
        return Caster::EXCLUDE_VERBOSE & $this->filter ? [] : parent::castResource($stub, $isNested);
    }
}
