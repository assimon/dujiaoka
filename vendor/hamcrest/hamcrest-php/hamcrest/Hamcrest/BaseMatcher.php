<?php
namespace Hamcrest;

/*
 Copyright (c) 2009 hamcrest.org
 */

/**
 * BaseClass for all Matcher implementations.
 *
 * @see Hamcrest\Matcher
 */
abstract class BaseMatcher implements Matcher
{

    public function describeMismatch($item, Description $description)
    {
        $description->appendText('was ')->appendValue($item);
    }

    public function __toString()
    {
        return StringDescription::toString($this);
    }
}
