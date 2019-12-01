Use Echarts in laravel-admin
======

## Screenshot

![ATUBAe.md.jpg](https://s2.ax1x.com/2019/04/10/ATUBAe.jpg)
## Installation

```bash
composer require cyd622/laravel-admin-ext-echarts

php artisan vendor:publish --tag=echarts
```

## Configuration

Open `config/echarts.php`, set configurations .

```php

    [
        'view' => 'echarts::index',
        'water_mark_text' => 'Cyd622@Laravel-Admin',
        'theme' => 'shine',
    ];

```

> * `view` set the view
> * `water_mark_text` set the watermark. if value is `null` or `''` will not use watermark
> * `theme` set the echarts theme

## Usage

Add following codes in your controller :
```php
public function index(Content $content)
{
	$json = '[{"count_date":"03-28","fans_num":5906,"article_num":363,"forward_num":27928,"comment_num":9123,"like_num":35632},{"count_date":"03-29","fans_num":9565,"article_num":361,"forward_num":16755,"comment_num":7193,"like_num":36540}]';
	
	$jsonArr = json_decode($json, 1);
	// bindData
	$head = [
	    'count_date' => '日期',
	    'fans_num' => '粉丝',
	    'comment_num' => '评论',
	    'article_num' => '文章',
	    'forward_num' => '转发',
	    'like_num' => '点赞',
	];
	$echarts = (new Echarts('柱状图', '数据来自新浪云大数据平台'))
	            ->setData($jsonArr)
	            ->bindLegend($head);
	            
	return $content
	            ->header('Echarts demo')
	            ->description('百度echarts图表展示')
	            ->body(new Box('折线图', $echarts));

}
```


For more usage, please refer to the official [documentation](https://www.echartsjs.com/tutorial.html) of echartsjs.


License
------------
Licensed under [The MIT License (MIT)](LICENSE).