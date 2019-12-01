# 自定义图表

`laravel-admin 1.5`已经移除了所有的图表组件，如果要在页面中加入图表组件，可以参考下面的流程

用`chartjs`举例，首先要下载[chartjs](http://chartjs.org/)，放到public目录下面，比如放在`public/vendor/chartjs`目录

然后在`app/Admin/bootstrap.php`引入组件：
```php
use Encore\Admin\Facades\Admin;

Admin::js('/vendor/chartjs/dist/Chart.min.js');

```

新建视图文件 `resources/views/admin/charts/bar.blade.php`

```php
<canvas id="myChart" width="400" height="400"></canvas>
<script>

$(function () {
   var ctx = document.getElementById("myChart").getContext('2d');
   var myChart = new Chart(ctx, {
       type: 'bar',
       data: {
           labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
           datasets: [{
               label: '# of Votes',
               data: [12, 19, 3, 5, 2, 3],
               backgroundColor: [
                   'rgba(255, 99, 132, 0.2)',
                   'rgba(54, 162, 235, 0.2)',
                   'rgba(255, 206, 86, 0.2)',
                   'rgba(75, 192, 192, 0.2)',
                   'rgba(153, 102, 255, 0.2)',
                   'rgba(255, 159, 64, 0.2)'
               ],
               borderColor: [
                   'rgba(255,99,132,1)',
                   'rgba(54, 162, 235, 1)',
                   'rgba(255, 206, 86, 1)',
                   'rgba(75, 192, 192, 1)',
                   'rgba(153, 102, 255, 1)',
                   'rgba(255, 159, 64, 1)'
               ],
               borderWidth: 1
           }]
       },
       options: {
           scales: {
               yAxes: [{
                   ticks: {
                       beginAtZero:true
                   }
               }]
           }
       }
   }); 
});
</script>
```

然后就可以在页面的任何地方引入这个图表视图了：

```php
public function index()
{
    return Admin::content(function (Content $content) {

        $content->header('chart');
        $content->description('.....');
        
        $content->body(view('admin.charts.bar'));
    });
}

```

按照上面的方式可以引入任意图表库，多图表页面的布局，参考[视图布局](/zh/layout.md)