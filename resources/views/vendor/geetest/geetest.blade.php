<script src="https://cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
<script src="https://static.geetest.com/static/tools/gt.js"></script>
<div id="{{ $captchaid }}"></div>
<p id="wait-{{ $captchaid }}" class="show">正在加载验证码...</p>
@define use Illuminate\Support\Facades\Config
<script>
    var geetest = function(url) {
        var handlerEmbed = function(captchaObj) {
            $("#{{ $captchaid }}").closest('form').submit(function(e) {
                var validate = captchaObj.getValidate();
                if (!validate) {
                    layer.msg('{{ Config::get('geetest.client_fail_alert')}}', {
                            icon: 5
                        })
                    e.preventDefault();
                }
                
            });
            captchaObj.appendTo("#{{ $captchaid }}");
            captchaObj.onReady(function() {
                $("#wait-{{ $captchaid }}")[0].className = "hide";
            });
            captchaObj.onSuccess(function () {$('#GeetestCaptcha').attr("placeholder",'{{ __('system.success_behavior_verification') }}')})
            if ('{{ $product }}' == 'popup') {
                //captchaObj.bindOn($('#{{ $captchaid }}').closest('form').find(':submit'));
                captchaObj.appendTo("#{{ $captchaid }}");
            }
        };
        $.ajax({
            url: url + "?t=" + (new Date()).getTime(),
            type: "get",
            dataType: "json",
            success: function(data) {
                initGeetest({
                    gt: data.gt,
                    challenge: data.challenge,
                    product: "{{ $product?$product:Config::get('geetest.product', 'float') }}",
                    offline: !data.success,
                    new_captcha: data.new_captcha,
                    lang: '{{ Config::get('geetest.lang', 'zh-cn') }}',
                    http: '{{ Config::get('geetest.protocol', 'http') }}' + '://'
                }, handlerEmbed);
            }
        });
    };
    (function() {
        geetest('{{ $url?$url:Config::get('geetest.url', 'geetest') }}');
    })();
</script>
<style>
    .hide {
        display: none;
    }
</style>
