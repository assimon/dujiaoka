<?php

namespace Encore\Admin\Grid\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid;
use Illuminate\Support\Collection;

class FixColumns
{
    /**
     * @var Grid
     */
    protected $grid;

    /**
     * @var int
     */
    protected $head;

    /**
     * @var int
     */
    protected $tail;

    /**
     * @var Collection
     */
    protected $left;

    /**
     * @var Collection
     */
    protected $right;

    /**
     * @var string
     */
    protected $view = 'admin::grid.fixed-table';

    /**
     * FixColumns constructor.
     *
     * @param Grid $grid
     * @param int  $head
     * @param int  $tail
     */
    public function __construct(Grid $grid, $head, $tail = -1)
    {
        $this->grid = $grid;
        $this->head = $head;
        $this->tail = $tail;

        $this->left = Collection::make();
        $this->right = Collection::make();
    }

    /**
     * @return Collection
     */
    public function leftColumns()
    {
        return $this->left;
    }

    /**
     * @return Collection
     */
    public function rightColumns()
    {
        return $this->right;
    }

    /**
     * @return \Closure
     */
    public function apply()
    {
        $this->grid->setView($this->view);

        return function (Grid $grid) {
            if ($this->head > 0) {
                $this->left = $grid->visibleColumns()->slice(0, $this->head);
            }

            if ($this->tail < 0) {
                $this->right = $grid->visibleColumns()->slice($this->tail);
            }

            $this->addStyle()->addScript();
        };
    }

    /**
     * @return $this
     */
    protected function addScript()
    {
        $allName = $this->grid->getSelectAllName();
        $rowName = $this->grid->getGridRowName();

        $selected = trans('admin.grid_items_selected');

        $script = <<<SCRIPT

(function () {
    var theadHeight = $('.table-main thead tr').outerHeight();
    $('.table-fixed thead tr').outerHeight(theadHeight);
    
    var tfootHeight = $('.table-main tfoot tr').outerHeight();
    $('.table-fixed tfoot tr').outerHeight(tfootHeight);
    
    $('.table-main tbody tr').each(function(i, obj) {
        var height = $(obj).outerHeight();

        $('.table-fixed-left tbody tr').eq(i).outerHeight(height);
        $('.table-fixed-right tbody tr').eq(i).outerHeight(height);
    });
    
    if ($('.table-main').width() >= $('.table-main').prop('scrollWidth')) {
        $('.table-fixed').hide();
    }
    
    $('.table-wrap tbody tr').on('mouseover', function () {
        var index = $(this).index();
        
        $('.table-main tbody tr').eq(index).addClass('active');
        $('.table-fixed-left tbody tr').eq(index).addClass('active');
        $('.table-fixed-right tbody tr').eq(index).addClass('active');
    });
    
    $('.table-wrap tbody tr').on('mouseout', function () {
        var index = $(this).index();
        
        $('.table-main tbody tr').eq(index).removeClass('active');
        $('.table-fixed-left tbody tr').eq(index).removeClass('active');
        $('.table-fixed-right tbody tr').eq(index).removeClass('active');
    });
    
    $('.{$rowName}-checkbox').iCheck({checkboxClass:'icheckbox_minimal-blue'}).on('ifChanged', function () {
    
        var id = $(this).data('id');
        var index = $(this).closest('tr').index();
    
        if (this.checked) {
            \$.admin.grid.select(id);
            $('.table-main tbody tr').eq(index).css('background-color', '#ffffd5');
            $('.table-fixed-left tbody tr').eq(index).css('background-color', '#ffffd5');
            $('.table-fixed-right tbody tr').eq(index).css('background-color', '#ffffd5');
        } else {
            \$.admin.grid.unselect(id);
            $('.table-main tbody tr').eq(index).css('background-color', '');
            $('.table-fixed-left tbody tr').eq(index).css('background-color', '');
            $('.table-fixed-right tbody tr').eq(index).css('background-color', '');
        }
    }).on('ifClicked', function () {
    
        var id = $(this).data('id');
        
        if (this.checked) {
            $.admin.grid.unselect(id);
        } else {
            $.admin.grid.select(id);
        }
        
        var selected = $.admin.grid.selected().length;
        
        if (selected > 0) {
            $('.{$allName}-btn').show();
        } else {
            $('.{$allName}-btn').hide();
        }
        
        $('.{$allName}-btn .selected').html("{$selected}".replace('{n}', selected));
    });
})();

SCRIPT;

        Admin::script($script, true);

        return $this;
    }

    /**
     * @return $this
     */
    protected function addStyle()
    {
        $style = <<<'STYLE'
.tables-container {
    position:relative;
}

.tables-container table {
    margin-bottom: 0px !important;
}

.tables-container table th, .tables-container table td {
    white-space:nowrap;
}

.table-wrap table tr .active {
    background': #f5f5f5;
}

.table-main {
    overflow-x: auto;
    width: 100%;
}

.table-fixed {
    position:absolute;
	top: 0px;
	background:#ffffff;
	z-index:10;
}

.table-fixed-left {
	left:0;
	box-shadow: 7px 0 5px -5px rgba(0,0,0,.12);
}

.table-fixed-right {
	right:0;
	box-shadow: -5px 0 5px -5px rgba(0,0,0,.12);
}
STYLE;

        Admin::style($style);

        return $this;
    }
}
