<div class="sh-footer">

    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">
<div class="layui-card cardcon">
<div class="layui-card-body">
                    <div class="footer-wrap">
                        <div style="text-align: center">{!! config('webset.footer') !!} </div>
                        <p>Copyright @ 2018-<?php echo date('Y');?> {{ config('webset.text_logo') }} . Powered By <a href="https://github.com/assimon/dujiaoka" target="_blank" rel="nofollow noopener noreferrer">独角数卡</a></p>
                    </div>

 </div> </div>

        </div>
    </div>
</div>

</body>
</html>
<script src="/assets/layui/layui.js"></script>
<script src="/assets/style/js/jquery-3.4.1.min.js"></script>
<script src="/assets/style/js/clipboard/clipboard.min.js"></script>

<script>
    //注意：导航 依赖 element 模块，否则无法进行功能性操作
    layui.use(['element'],function () {
        var element = layui.element;
		var device = layui.device();
if(device.weixin||device.android||device.ios){
  //$('.product-img').addClass('layui-hide');
}

    });
</script>

