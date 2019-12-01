<?php

namespace Encore\Admin\Widgets\Echarts;

use Encore\Admin\Admin;
use Encore\Admin\Extension;
use Illuminate\Contracts\Support\Renderable;

class Echarts extends Extension implements Renderable
{
    public $name = 'echarts';

    public $views = __DIR__ . '/../resources/views';

    public $assets = __DIR__ . '/../resources/assets';

    public $config = __DIR__ . '/../config/config.php';

    public $menu = [
        'title' => 'Echarts',
        'path' => 'echarts',
        'icon' => 'fa-bar-chart',
    ];

    /**
     * @var string
     */
    protected $view;

    /**
     * 图表标题
     * @var string
     */
    protected $title = '';

    /**
     * 图表子标题
     * @var string
     */
    protected $subtext = '';

    /**
     * @var array
     */
    protected $data;

    /**
     * 图表配置
     * @var array
     */
    protected $series;

    /**
     * 折线图是否显示阴影
     * @var bool
     */
    protected $showShadow = false;
    /**
     * 工具箱配置
     * @var array
     */
    protected $toolbox = [
        'show' => true,
        'feature' => [
            'magicType' => ['type' => ['line', 'bar', 'stack', 'tiled']],
            'restore' => [],
            'saveAsImage' => [],
        ]
    ];

    /**
     * 显示工具箱
     * @var bool
     */
    protected $showToolbox = false;

    /**
     * 缩放
     * @var bool
     */
    protected $dataZoom = false;

    /**
     * x轴倾斜角度
     * @var int
     */
    protected $xAxisRotate;

    // 全局可配置
    protected $waterMarkText;

    /**
     * 主题
     * @var string
     */
    protected $theme;

    /**
     * 图表样式
     * @var string
     */
    protected $style = 'height: 350px;width:100%';

    /**
     * @var bool
     */
    protected $boundaryGap = false;

    /**
     * 数据源
     * @var
     */
    protected $dataSource;

    /**
     * 图表类型
     * @var string
     */
    protected $seriesType = 'line';

    /**
     * 雷达图配置
     * @var array
     */
    protected $indicator = [];

    public function __construct($title = '', $subtext = '')
    {
        $this->title = $title;
        $this->subtext = $subtext;

        $this->theme = config('echarts.theme', 'shine');//walden
        $this->view = config('echarts.view', 'echarts::index');
        $this->waterMarkText = config('echarts.water_mark_text', 'Cyd622@Laravel-Admin');
    }

    /**
     * @return mixed|string
     * @throws \Throwable
     */
    public function render()
    {
        if ($this->theme) {
            Admin::headerJs("vendor/laravel-admin-ext/echarts/themes/{$this->theme}.js");
        }

        return view($this->view, $this->buildOption())->render();
    }

    /**
     * 构建参数
     * @return array
     */
    private function buildOption()
    {
        // 全部是折线的
        if (!collect($this->series)->pluck('type')->every(function ($item) {
            return $item == 'line';
        })) {
            $this->boundaryGap = true;
        }

        if (!$this->showToolbox) {
            array_set($this->toolbox, 'show', false);
        }

        $this->dataSource = $this->dataSource ?: $this->data;

        if ($this->showShadow) {
            data_set($this->series, '*.areaStyle', '{}');
        }

        return [
            'title' => $this->title,
            'style' => $this->style,
            'subtext' => $this->subtext,
            'waterMarkText' => $this->waterMarkText,
            'dataZoom' => $this->dataZoom,
            'xAxisRotate' => $this->xAxisRotate,
            'theme' => $this->theme,
            'seriesType' => $this->seriesType,
            'showToolbox' => $this->showToolbox,
            'boundaryGap' => (int)$this->boundaryGap,
            'dataSource' => json_encode($this->dataSource),
            'series' => json_encode($this->series),
            'toolbox' => json_encode($this->toolbox),
            'indicator' => json_encode($this->indicator),
            'domId' => mt_rand(1, 9999),
        ];
    }

    /**
     * 数据绑定
     * @param array $data
     * @return $this
     */
    public function bindLegend(array $data)
    {

        $this->dataSource = collect($this->data)->map(function ($item) use ($data) {
            $tmp = [];
            foreach ($data as $k => $v) {
                $tmp[$v] = $item[$k];
                //  如果没有配置图表类型,自动默认折线图 -1是第一个值是x轴的
                if (!$this->series || count($this->series) < count($data) - 1) {
                    $this->series[] = ['type' => $this->seriesType];
                }
            }
            return $tmp;
        })->toArray();
        return $this;
    }

    /**
     * 数据源
     * @param array $data
     * @return Echarts
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 设置series参数
     * @param array $series
     * @return $this
     */
    public function setSeries(array $series)
    {
        $this->series = $series;
        return $this;
    }

    /**
     * @param string $subtext
     * @return Echarts
     */
    public function setSubtext(string $subtext)
    {
        $this->subtext = $subtext;
        return $this;
    }

    /**
     * @param string $title
     * @return Echarts
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $theme
     * @return Echarts
     */
    public function setTheme(string $theme)
    {
        $themeList = [
            'chalk',
            'dark',
            'halloween',
            'infographic',
            'macarons',
            'purple-passion',
            'roma',
            'shine',
            'vintage',
            'walden',
            'westeros',
            'wonderland',
        ];
        if (in_array($theme, $themeList)) {
            $this->theme = $theme;
        }
        return $this;
    }

    /**
     * @param bool $boundaryGap
     * @return Echarts
     */
    public function setBoundaryGap(bool $boundaryGap)
    {
        $this->boundaryGap = $boundaryGap;
        return $this;
    }

    /**
     * @param bool $showToolbox
     * @return Echarts
     */
    public function setShowToolbox(bool $showToolbox)
    {
        $this->showToolbox = $showToolbox;
        return $this;
    }

    /**
     * @param array $toolbox
     * @return Echarts
     */
    public function setToolbox(array $toolbox)
    {
        $this->toolbox = $toolbox;
        return $this;
    }

    /**
     * @param bool $dataZoom
     * @return Echarts
     */
    public function setDataZoom(bool $dataZoom)
    {
        $this->dataZoom = $dataZoom;
        return $this;
    }

    /**
     * @param string $seriesType line|bar|pie|radar
     * @return Echarts
     */
    public function setSeriesType(string $seriesType)
    {
        $this->seriesType = $seriesType;
        return $this;
    }

    /**
     * @param array $indicator
     * @return Echarts
     */
    public function setIndicator(array $indicator)
    {
        $this->indicator = $indicator;
        return $this;
    }

    /**
     * @param string $style
     * @return Echarts
     */
    public function setStyle(string $style)
    {
        $this->style = $style;
        return $this;
    }

    /**
     * 设置视图
     * @param string $view
     * @return Echarts
     */
    public function setView(string $view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @param bool $showShadow
     * @return Echarts
     */
    public function setShowShadow(bool $showShadow)
    {
        $this->showShadow = $showShadow;
        return $this;
    }
}