<div id="container_{{ $domId }}" style="{{ $style }}"></div>
<script type="text/javascript">
option_{{ $domId }} = {
    title: {
        text: '{{ $title }}',
        subtext: '{{ $subtext }}',
        x: '4%'
    },
 @if($seriesType == 'line' || $seriesType == 'bar')
    tooltip: {
        trigger: 'axis',
        axisPointer: {
            type: 'cross',
        }
    },
  @else
    tooltip: {},
  @endif
  @if($seriesType != 'radar')
    toolbox: {!! $toolbox !!},
  @else
    radar: {
        name: {
            textStyle: {
                color: '#fff',
                backgroundColor: '#999',
                borderRadius: 3,
                padding: [5, 5]
            }
        },
        center: ['50%','60%'],
        indicator: {!! $indicator !!}
    },
 @endif
@if($seriesType == 'line' || $seriesType == 'bar')
    legend: {@unless($showToolbox)right: '5%'@endunless},
@else
    legend: {
     orient: 'vertical',
     left: '5%',
     top:'15%'
    },
 @endif

    grid: {
        right: '4%',
        bottom: '10%',
    },
@if($dataSource != 'null')
    dataset: {
        source: {!! $dataSource !!}
    },
@endif
 @if($dataZoom && ($seriesType == 'line' || $seriesType == 'bar'))
    dataZoom: [
        {
            show: true,
            realtime: true,
            start: 0,
            end: 80,
            handleIcon: 'path://M306.1,413c0,2.2-1.8,4-4,4h-59.8c-2.2,0-4-1.8-4-4V200.8c0-2.2,1.8-4,4-4h59.8c2.2,0,4,1.8,4,4V413z',
            handleSize: '120%',
        },
        {
            type: 'inside',
            realtime: true
        }
    ],
@endif
@if($seriesType == 'line' || $seriesType == 'bar')
    xAxis: {
        type: 'category',
        boundaryGap: {{ $boundaryGap }},
        @if($xAxisRotate)
        axisLabel: {
            interval: 0,
            rotate: {{ $xAxisRotate }}
        },
        @endif
        axisTick: {
            alignWithLabel: true
        }
    },
    yAxis: {
        splitLine: {
            lineStyle: {
                color: ['red', 'blue','green'],
                opacity: 0.10,
            }
        }
    },
@endif
    series: {!! $series !!}
};

@if($waterMarkText)
waterMarkCanvas=drawWaterMark('{{ $waterMarkText }}');
@endif
echartTheme='{{ $theme }}';
drawEcharts("container_{{ $domId }}",option_{{ $domId }});
</script>