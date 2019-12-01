<?php

namespace Encore\Admin\Grid\Filter;

class StartsWith extends Like
{
    protected $exprFormat = '{value}%';
}
