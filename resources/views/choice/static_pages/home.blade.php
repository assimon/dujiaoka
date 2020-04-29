@extends('choice.layouts.default')
@section('notice')
    @include('choice.layouts._notice')
@endsection
@section('content')
<div id="layerad" style="display: none;">{!! config('webset.layerad') !!}</div>
    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">下单</div>

                <div class="layui-card-body">
                    <div class="layui-row">
                        <div class="layui-col-md3 layui-hide-xs">
                            <div class="layui-card">
                                <div class="layui-card-body">
                                    <img id='pd_img' width="100%" height="100%" style='display:none'>
                                </div>
                                <div class="layui-card-body">
                                    <img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate(Request::url())) !!}" width="100%" height="100%">
                                    <p style="text-align: center">手机扫码购买</p>

                                </div>
                            </div>
                        </div>


                        <!-- 商品详细区 -->
                        <div class="layui-col-md8  layui-col-xs12" >
                            <div class="layui-card">
                                <div class="layui-card-header">
                                    <span style="font-size: 16px;" id='pd_name'>商品选购</span>
                                        <span class="layui-badge layui-bg-green" id='pd_auto' style='display:none'>自动发货</span>
                                        <span class="layui-badge layui-bg-orange" id='pd_recharge' style='display:none'>代充</span>
                                    <span class="layui-badge layui-bg-blue" id='pd_instock' style='display:none'>库存</span>
                                </div>
                                <div class="layui-card-body">
                                    <form class="layui-form layui-form-pane" action="{{ url('postOrder') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="product-info" id='product-price' style='display:none'>
                                            <span style="color:#6c6c6c">价格：</span>
                                            <span class="product-price">¥ </span>
                                            <span class="product-price-cost-price">¥ </span>
                                        </div>


                                            <div class="product-info" id='wholesale' style='display:none'>
                                                <span style="color:#F40;font-size: 18px;font-weight: 400"><i class="layui-icon layui-icon-praise"></i>批发优惠：</span>
                                                <div id='wholesale_price'></div>
                                            </div>

										<div class="layui-form-item">
                                            <label class="layui-form-label">商品分类</label>
                                            <div class="layui-input-block">
                                            	<select name="tid" id="tid"  lay-filter="tid" required lay-verify='required'>
													<option value=''>请选择分类</option>

												</select>
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">商品</label>
                                            <div class="layui-input-block">
                                            	<select  name="pid" id="productlist" lay-filter="productlist" required lay-verify='required'>

												</select>
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">邮箱</label>
                                            <div class="layui-input-block">
                                                <input type="email" name="account" value=""  required lay-verify="required|email" placeholder="接收卡密或通知" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                        <div class="other-item">

												</div>




                                        <div class="layui-form-item">
                                            <label class="layui-form-label">查询密码</label>
                                            <div class="layui-input-block">
                                                <input type="password" name="search_pwd" value=""  required lay-verify="required" placeholder="为防止撞库攻击，请设置一个查询订单的密码" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>



                                        <div class="layui-form-item">
                                            <label class="layui-form-label">优惠码</label>
                                            <div class="layui-input-block">
                                                <input type="text" name="coupon_code"   placeholder="您有优惠码吗？" value="" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>

                                        <div class="layui-form-item">
                                            <label class="layui-form-label">支付方式</label>
                                            <div class="layui-input-block">
                                            	<select lay-verify="payway" id="paywaylist" name="payway" required lay-verify='required'>

												</select>
                                            </div>
                                        </div>

                                        <div class="layui-form-item">
                                            <label class="layui-form-label">数量</label>
                                            <div class="layui-input-inline">
                                                <input type="number" name="order_number" required  lay-verify="required|order_number" placeholder="" value="1" autocomplete="off" class="layui-input">
                                            </div>

                                        </div>
									<div class="layui-form-item">
										<label class="layui-form-label">验证码</label>
										<div>
											<div style="float:left;width:20%;">
                                                <input type="text" name="verify_img" value=""  required lay-verify="required" placeholder="验证码" autocomplete="off" class="layui-input">
                                            </div>
                                            <div class="buy-captcha layui-word-aux">
                                                <img class="captcha-img" height="36"  src="{{ captcha_src('buy') }}" onclick="refresh()">
                                            </div>
										</div>
                                            <script>
                                                function refresh(){
                                                    $('img[class="captcha-img"]').attr('src','{{ captcha_src('buy') }}'+Math.random());
                                                }
                                            </script>
                                        </div>

                                        <div class="layui-form-item">
                                            <div class="layui-input-block">
                                                <button class="layui-btn" id='buy' lay-submit lay-filter="postOrder">立即下单</button>
                                                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>



            </div>

        </div>
    </div>

    <div class="layui-row">

        <!-- 介绍区 -->
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-xs12" >
            <div class="layui-card cardcon">
                <div class="layui-card-header">商品介绍</div>
                <div class="layui-card-body">
                    <div class="product-content">

                    </div>

                </div>
            </div>
        </div>

    </div>
@stop

@section('tpljs')
<script>
		var instock = 0
		//一般直接写在一个js文件中
		layui.use(['jquery', 'form','layer','laytpl','element'], function() {
	var $ = layui.jquery;
	var layer = layui.layer;
	var laytpl = layui.laytpl;
	var element = layui.element;
	var form = layui.form;
	var device = layui.device();
	$.ajax({
				url: '{{ url("/api/payways") }}',
				type: 'GET',
				beforeSend: function () {
				},
				success: function (res) {
					if (res.code == '1') {
					var html = "";
					var list = res.data.payways;
					for (var i = 0, j = list.length; i < j; i++) {
						html += '<option value='+list[i].value+'>'+list[i].name+'</option>';
						}
						$('#paywaylist').html("<option value=''>请选择支付方式</option>" + html);
							form.render('select');

				}else{
					layer.msg(res.msg,{icon:2,time:5000});
				}},
				error:function(){
					layer.msg('获取支付方式失败',{icon:2,time:5000});
				}


	});
            $.ajax({
                url: '{{ url("/api/typelist") }}',
                type: 'GET',
                beforeSend: function () {
                },
                success: function (res) {
                    if (res.code == '1') {
                        var html = "";
                        var list = res.data.typelist;
                        for (var i = 0, j = list.length; i < j; i++) {
                            var mypassword = list[i].password;
                            var type = 0;
                            if(mypassword.length>0){
                                type = 1;
                            }
                            html += '<option value='+list[i].id+' data-type="'+type+'">'+list[i].name+'</option>';
                        }
                        $('#tid').html("<option value=''>请选择分类</option>" + html);
                        form.render('select');

                    }else{
                        layer.msg(res.msg,{icon:2,time:5000});
                    }},
                error:function(){
                    layer.msg('获取商品失败',{icon:2,time:5000});
                }


            })
form.on('select(tid)', function(data){
		if (data.value == 0) return;
		var ispassword = $(data.elem).find('option:selected').data('type');
		if(ispassword>0){
			var html = '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;"><div class="layui-input-inline"><input type="password" id="grouppassword" name="grouppassword" lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input"> </div></div>';
			layer.open({
				type: 1
				,title: false //不显示标题栏
				,closeBtn: true
				,area: '300px;'
				,shade: 0.8
				,id: 'group_password' //设定一个id，防止重复弹出
				,btn: ['提交','放弃']
				,btnAlign: 'c'
				,moveType: 1 //拖拽模式，0或者1
				,content: html
				,yes: function(layero){
					var grouppassword = $("#grouppassword").val();
					if(grouppassword.length>0){
						//远程请求验证
						$.ajax({
							url: '{{ url("/api/productlist") }}',
							type: 'POST',
							dataType: 'json',
							data: {'tid': data.value,'password':grouppassword,'_token':$("input[name='_token']").val()},
							beforeSend: function () {
							},
							success: function (res) {
								if (res.code == '1') {
									var html = "";
									var list = res.data.products;
									for (var i = 0, j = list.length; i < j; i++) {
										var mypassword = list[i].password;
										var type = 0;
										if(mypassword.length>0){
											type = 1;
										}
										html += '<option value='+list[i].id+' data-type="'+type+'">'+list[i].name+'</option>';
									}
									$('#productlist').html("<option value=\"0\">请选择商品</option>" + html);
									$('.product-price').hide();
									$('.product-price-cost-price').hide();
									$('#pd_name').html('商品选购');
									$('#pd_instock').hide();
									$("#pd_recharge").hide();
									$("#pd_auto").hide();
									$("#product-price").hide();
									$("#wholesale").hide();
									$("#pd_img").hide();
									$('.product-content').html('');
									$("#addons").remove();
									form.render('select');
									layer.closeAll();
								} else {
									layer.msg(res.msg,{icon:2,time:5000});
								}
							},
						});
					}else{
						layer.msg("请输入密码",{icon:2,time:5000});
					}
				}
				,btn2: function(index, layero){
					$(data.elem).find("option").eq(0).val("0");
					$(data.elem).find("option").eq(0).attr("selected",true);
					$('#productlist').html("");
					$("#addons").remove();
					form.render('select');
					$(data.elem).find("option").eq(0).attr("selected",false);
				}
				,cancel: function(){
					$(data.elem).find("option").eq(0).val("0");
					$(data.elem).find("option").eq(0).attr("selected",true);
					$('#productlist').html("");
					$("#addons").remove();
					form.render('select');
					$(data.elem).find("option").eq(0).attr("selected",false);
				}
			});
		}else{
			//远程请求验证
			$.ajax({
				url: '{{ url("/api/productlist") }}',
				type: 'POST',
				dataType: 'json',
				data: {'tid': data.value,'_token':$("input[name='_token']").val()},
				beforeSend: function () {
				},
				success: function (res) {
					if (res.code == '1') {
						var html = "";
						var list = res.data.products;
						for (var i = 0, j = list.length; i < j; i++) {
							var mypassword = list[i].password;
							var type = 0;
							if(mypassword.length>0){
								type = 1;
							}
							html += '<option value='+list[i].id+' data-type="'+type+'">'+list[i].name+'</option>';
						}
						$('#productlist').html("<option value=''>请选择商品</option>" + html);
						$('.product-price').hide();
						$('.product-price-cost-price').hide();
						$('#pd_name').html('商品选购');
						$('#pd_instock').hide();
						$("#pd_recharge").hide();
						$("#pd_auto").hide();
						$("#product-price").hide();
						$("#wholesale").hide();
						$("#pd_img").hide();
						$('.product-content').html('');
						$("#addons").remove();
						form.render('select');
					} else {
						layer.msg(res.msg,{icon:2,time:5000});
						$(data.elem).find("option").eq(0).val("0");
						$(data.elem).find("option").eq(0).attr("selected",true);
						$('#productlist').html("");
						$("#addons").remove();
						form.render('select');
						$(data.elem).find("option").eq(0).attr("selected",false);
					}
				},

			});
		}
	});
	form.on('select(productlist)', function(data){
		if (data.value == 0) return;
		var ispassword = $(data.elem).find('option:selected').data('type');
		if(ispassword>0){
			var html = '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;"><div class="layui-input-inline"><input type="password" id="productpassword" name="productpassword" lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input"> </div></div>';
			layer.open({
				type: 1
				,title: false //不显示标题栏
				,closeBtn: true
				,area: '300px;'
				,shade: 0.8
				,id: 'product_password' //设定一个id，防止重复弹出
				,btn: ['提交','放弃']
				,btnAlign: 'c'
				,moveType: 1 //拖拽模式，0或者1
				,content: html
				,yes: function(layero){
					var productpassword = $("#productpassword").val();
					if(productpassword.length>0){
						//远程请求验证
						$.ajax({
							url: '{{ url("/api/proudctinfo") }}',
							type: 'POST',
							dataType: 'json',
							data: {'pid': data.value,'password':productpassword,'_token':$("input[name='_token']").val()},
							beforeSend: function () {
							},
							success: function (res) {
								if (res.code == '1') {
						var product = res.data;
						var html =""
						$('.product-price').html(product.actual_price);
						$('.product-price-cost-price').html(product.cost_price);
						$('.product-price').show(product.actual_price);
						$('.product-price-cost-price').show(product.cost_price);
						instock=product.in_stock
						$('#pd_name').html(product.pd_name);
						$('#pd_instock').html('库存'+instock);
						$("#pd_instock").show();
						$("#product-price").show();
						$("#pd_img").attr('src',product.pd_picture);
						$("#pd_img").show();
						$('.product-content').html(product.pd_info);
						$("#addons").remove();
						if(product.pd_type==2){
							$("#pd_recharge").show()
							$("#pd_auto").hide()
						}
						if(product.pd_type==1){
							$("#pd_auto").show()
							$("#pd_recharge").hide()
						}
						if(product.buy_prompt!==null){
            layer.open({
                type: 1,
                shade: false,
                skin: 'layui-layer-lan', //加上边框
                area: ['60%', '50%'], //宽高
                title: '购买提示',
                content: '<div class="buy-prompt">'+product.buy_prompt+'<div>'
            });}
						var list = product.other_ipu;
						if(list!==null){
							var addons = '<div id="addons">';
							for (var i = 0, j = list.length; i < j; i++) {
								addons += `<div class="layui-form-item">
                                            <label class="layui-form-label">`+list[i]['desc']+`</label>
                                            <div class="layui-input-block">
                                            <input type="text" name="`+list[i]['field']+`" `;

                                if(list[i]['rule']===true){
                                	addons+=`required="" lay-verify="required"`;
                                }
                                addons +=` placeholder="`+list[i]['desc']+`" value="" autocomplete="off" class="layui-input">
                                                        </div>
                                                    </div>`;
							}
						$('.other-item').html(addons);
						}
						var wholesale = product.wholesale_price;
						if(wholesale!==null){
							var wholesale_price = '';
							for (var i = 0, j =wholesale.length; i < j; i++) {
								wholesale_price += `<p class="ws-price">购买数量`+wholesale[i].number+`个或以上,每个： <span class="layui-badge layui-bg-orange">`+wholesale[i].price+`￥</span></p>`
							}
							$('#wholesale_price').html(wholesale_price);
							$('#wholesale').show();
						}

						form.render();
									layer.closeAll();
								} else {
									layer.msg(res.msg,{icon:2,time:5000});
								}
							}
						});

					}else{
						layer.msg("请输入密码",{icon:2,time:5000});
					}
				}
				,btn2: function(index, layero){
					$(data.elem).find("option").eq(0).val("0");
					$(data.elem).find("option").eq(0).attr("selected",true);
					$('#price').val('');
					$('#qty').val('');
					$('#prodcut_description').html('');
					$("#addons").remove();
					$('#number').val('1');
					form.render('select');
					$(data.elem).find("option").eq(0).attr("selected",false);
				}
				,cancel: function(){
					$(data.elem).find("option").eq(0).val("0");
					$(data.elem).find("option").eq(0).attr("selected",true);
					$('#price').val('');
					$('#qty').val('');
					$('#prodcut_description').html('');
					$("#addons").remove();
					$('#number').val('1');
					form.render('select');
					$(data.elem).find("option").eq(0).attr("selected",false);
				}
			});
		}else{
			$.ajax({
				url: '{{ url("/api/proudctinfo") }}',
				type: 'POST',
				dataType: 'json',
				data: {'pid': data.value,'_token':$("input[name='_token']").val()},
				beforeSend: function () {
				},
				success: function (res) {
					if (res.code == '1') {
						var product = res.data;
						var html =""
						$('.product-price').html(product.actual_price);
						$('.product-price-cost-price').html(product.cost_price);
						$('.product-price').show(product.actual_price);
						$('.product-price-cost-price').show(product.cost_price);
						instock=product.in_stock
						$('#pd_name').html(product.pd_name);
						$('#pd_instock').html('库存'+instock);
						$("#pd_instock").show();
						$("#product-price").show();
						$("#pd_img").attr('src',product.pd_picture);
						$("#pd_img").show();
						$('.product-content').html(product.pd_info);
						$("#addons").remove();
						if(product.pd_type==2){
							$("#pd_recharge").show()
							$("#pd_auto").hide()
						}
						if(product.pd_type==1){
							$("#pd_auto").show()
							$("#pd_recharge").hide()
						}
						if(product.buy_prompt!==null){
            layer.open({
                type: 1,
                shade: false,
                skin: 'layui-layer-lan', //加上边框
                area: ['60%', '50%'], //宽高
                title: '购买提示',
                content: '<div class="buy-prompt">'+product.buy_prompt+'<div>'
            });}
						var list = product.other_ipu;
						if(list!==null){
							var addons = '<div id="addons">';
							for (var i = 0, j = list.length; i < j; i++) {
								addons += `<div class="layui-form-item">
                                            <label class="layui-form-label">`+list[i]['desc']+`</label>
                                            <div class="layui-input-block">
                                            <input type="text" name="`+list[i]['field']+`" `;

                                if(list[i]['rule']===true){
                                	addons+=`required="" lay-verify="required"`;
                                }
                                addons +=` placeholder="`+list[i]['desc']+`" value="" autocomplete="off" class="layui-input">
                                                        </div>
                                                    </div>`;
							}
						$('.other-item').html(addons);
						}
						var wholesale = product.wholesale_price;
						if(wholesale!==null){
							var wholesale_price = '';
							for (var i = 0, j =wholesale.length; i < j; i++) {
								console.log(wholesale[i])
								wholesale_price += `<p class="ws-price">购买数量`+wholesale[i].number+`个或以上,每个： <span class="layui-badge layui-bg-orange">`+wholesale[i].price+`￥</span></p>`
							}
							$('#wholesale_price').html(wholesale_price);
							$('#wholesale').show();
						}

						form.render();
					} else {
						layer.msg(res.msg,{icon:2,time:5000});
						$(data.elem).find("option").eq(0).val("0");
						$(data.elem).find("option").eq(0).attr("selected",true);
						$('#price').val('');
						$('#qty').val('');
						$('#number').val('1');
						$('#prodcut_description').html('');
						$("#addons").remove();
						form.render('select');
						$(data.elem).find("option").eq(0).attr("selected",false);
					}
				}
			});
		}
	});
            form.verify({
                order_number: function (value, item) {
                    if (value == 0) return '购买数量不能为0'
                    if (value > instock) return '购买数量大于库存'
                }
            })
    var layerad = $("#layerad").html();
	if(typeof(layerad)!="undefined"){
		if(layerad.length>0){
			layer.open({
				type: 1
				,title: false
				,closeBtn: false
				,area: '300px;'
				,shade: 0.8
				,id: 'AD'
				,btn: [ '关闭']
				,btnAlign: 'c'
				,moveType: 1 //拖拽模式，0或者1
				,content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">'+layerad+'</div>'
			});
		}
	}
            form.on('submit(postOrder)', function(data){

                if (data.field.tid == '') {
                    layer.msg('请选择商品分类', {
                        icon: 5
                    })
                    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
                }
                if (data.field.productlist == '') {
                    layer.msg('请选择商品', {
                        icon: 5
                    })
                    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
                }
                	if (data.field.payway == '') {
                    layer.msg('请选择支付方式', {
                        icon: 5
                    })
                    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
                }
            });

		})
</script>
    @stop
