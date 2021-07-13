<script src="https://cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
<script src="https://static.geetest.com/static/tools/gt.js"></script>
<div id="{{ $captchaid }}"></div>
<p id="wait-{{ $captchaid }}" class="show">loading...</p>
<!-- wcccc -->
@define use Illuminate\Support\Facades\Config
<script>
    var geetest = function(url) {
        var handlerEmbed = function(captchaObj) {
            $("#{{ $captchaid }}").closest('form').submit(function(e) {
                var validate = captchaObj.getValidate();
                if (!validate) {
                    layer.msg('{{ __('dujiaoka.please_complete_the_behavior_verification_correctly')}}', {
                        icon: 5
                    })
                    e.preventDefault();
                }

            });
            captchaObj.appendTo("#{{ $captchaid }}");
            captchaObj.onReady(function() {
                $("#wait-{{ $captchaid }}")[0].className = "hide";
            });
            captchaObj.onSuccess(function () {$('#GeetestCaptcha').attr("placeholder",'{{ __('dujiaoka.success_behavior_verification') }}')})
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
                    product: "{{ 'popup' }}",
                    offline: !data.success,
                    new_captcha: data.new_captcha,
                    lang: '{{ dujiaoka_config_get('language') ?? 'zh_CN' }}',
                    http: '{{ (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://" }}' + '://'
                }, handlerEmbed);
            }
        });
    };
    (function() {
        geetest('{{ '/check-geetest' }}');
    })();
</script>
<style>
    .hide {
        display: none;
    }
</style>
