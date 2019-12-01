<?php

namespace Encore\Admin\Widgets\Echarts\Http\Controllers;

use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Echarts\Echarts;
use Illuminate\Routing\Controller;

class EchartsController extends Controller
{
    public function index(Content $content)
    {
        $json = '[{"count_date":"03-28","fans_num":5906,"article_num":363,"forward_num":27928,"comment_num":9123,"like_num":35632},{"count_date":"03-29","fans_num":9565,"article_num":361,"forward_num":16755,"comment_num":7193,"like_num":36540},{"count_date":"03-30","fans_num":6621,"article_num":318,"forward_num":40891,"comment_num":8432,"like_num":64795},{"count_date":"03-31","fans_num":8083,"article_num":256,"forward_num":11448,"comment_num":5803,"like_num":38447},{"count_date":"04-01","fans_num":9119,"article_num":373,"forward_num":45100,"comment_num":19948,"like_num":98335},{"count_date":"04-02","fans_num":9640,"article_num":289,"forward_num":26539,"comment_num":8971,"like_num":44315},{"count_date":"04-03","fans_num":9186,"article_num":271,"forward_num":10874,"comment_num":5997,"like_num":35411}]';

        $jsonArr = json_decode($json, 1);

        $head = [
            'count_date' => '日期',
            'fans_num' => '粉丝',
            'comment_num' => '评论',
            'article_num' => '文章',
            'forward_num' => '转发',
            'like_num' => '点赞',
        ];

        $echarts = (new Echarts('折线图', '我是堆叠方式'))
            ->setData($jsonArr)
            ->bindLegend($head)
            ->setShowShadow(1)
            ->setSeries([
                ['type' => 'line', 'stack' => '总量'],
                ['type' => 'line', 'stack' => '总量'],
                ['type' => 'line', 'stack' => '总量'],
                ['type' => 'line', 'stack' => '总量'],
                ['type' => 'line', 'stack' => '总量'],
            ]);

        $echarts2 = (new Echarts('柱状图', '数据来自新浪云大数据平台'))
            ->setSeriesType('bar')
            ->setData($jsonArr)
            ->bindLegend($head)
            ->setDataZoom(1)
            ->setShowToolbox(1);


        $names = '[{"name":"李花平","value":68900},{"name":"鲍奚汤·马","value":35082},{"name":"成李·苏","value":94194},{"name":"孙计","value":84937},{"name":"滕和伏","value":59329},{"name":"黄孟","value":76689},{"name":"汪苗云","value":46175},{"name":"谈谈褚","value":71813}]';

        $echarts3 = (new Echarts('饼形图'))
            ->setData(json_decode($names, 1))
            ->setSeries([
                ['type' => 'pie', 'name' => '姓名',],
            ])
            ->setSeriesType('pie');

        $echarts4 = (new Echarts('雷达图'))
            ->setIndicator([
                ['name' => '销售', 'max' => 100],
                ['name' => '管理', 'max' => 100],
                ['name' => '信息', 'max' => 100],
                ['name' => '客服', 'max' => 100],
                ['name' => '研发', 'max' => 100],
            ])
            ->setSeries([
                ['type' => 'radar',
                    'data' => [
                        [
                            'value' => [99, 86.4, 65.2, 82.5, 87],
                            'name' => 2017,
                        ],
                        [
                            'value' => [75, 76, 98, 72.4, 53.9],
                            'name' => 2016,
                        ]
                    ],
                ],

            ])
            ->setSeriesType('radar');

        $box = new Box('折线图', $echarts);
        $box2 = new Box('柱状图', $echarts2);
        $box3 = new Box('饼形图', $echarts3);
        $box4 = new Box('雷达图', $echarts4);

        return $content
            ->header('Echarts demo')
            ->description('百度echarts图表展示')
            ->row(function (Row $row) use ($box, $box2, $box3, $box4) {

                $row->column(6, function (Column $column) use ($box) {
                    $column->append($box);
                });

                $row->column(6, function (Column $column) use ($box2) {
                    $column->append($box2);
                });

                $row->column(6, function (Column $column) use ($box3) {
                    $column->append($box3);
                });

                $row->column(6, function (Column $column) use ($box4) {
                    $column->append($box4);
                });

            });
    }
}