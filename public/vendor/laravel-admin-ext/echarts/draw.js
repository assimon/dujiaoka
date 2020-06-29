let echartTheme = null;
let waterMarkCanvas = null;

function drawWaterMark(waterMarkText) {
    let waterMarkCanvas = document.createElement('canvas');
    let ctx = waterMarkCanvas.getContext('2d');
    waterMarkCanvas.width = 220;
    waterMarkCanvas.height = 200;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.globalAlpha = 0.07;
    ctx.font = '20px Microsoft Yahei';
    ctx.translate(130, 90);
    ctx.rotate(-Math.PI / 4);
    ctx.fillText(waterMarkText, 0, 0);
    return waterMarkCanvas;
}

function drawEcharts(domId, option) {

    if (waterMarkCanvas) {
        option.backgroundColor = {
            type: 'pattern',
            image: waterMarkCanvas,
            repeat: 'repeat'
        };
    }
    if (option.dataZoom) {
        option.grid.bottom = '18%';
    }
    let dom = document.getElementById(domId);
    let myChart = echarts.init(dom, echartTheme);
    myChart.showLoading();
    setTimeout(function () {
        myChart.hideLoading();
        myChart.setOption(option, true);
    }, 200);
}