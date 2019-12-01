<?php
namespace JakubOnderka\PhpConsoleColor;

class InvalidStyleException extends \Exception
{
    public function __construct($styleName)
    {
        parent::__construct("Invalid style $styleName.");
    }
}