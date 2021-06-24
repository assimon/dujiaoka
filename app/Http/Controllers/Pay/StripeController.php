<?php

namespace App\Http\Controllers\Pay;

use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
use URL;

class StripeController extends PayController
{

    public function gateway(string $payway, string $orderSN)
    {


        // 加载网关
        $this->loadGateWay($orderSN, $payway);
        //构造要请求的参数数组，无需改动
        switch ($payway) {
            case 'wx':
            case 'alipay':
            default:
                try {
                    \Stripe\Stripe::setApiKey($this->payGateway->merchant_id);
                    $amount = bcmul($this->order->actual_price, 100, 0);
                    $price = $this->order->actual_price;
                    $usd = bcmul($this->getUsdCurrency($this->order->actual_price), 100, 2);
                    $orderid = $this->order->order_sn;
                    $pk = $this->payGateway->merchant_id;
                    $return_url = site_url() . $this->payGateway->pay_handleroute . '/return_url/?orderid=' . $this->order->order_sn;
                    $html = "<html class=\"js cssanimations\">
<head lang=\"en\">
    <meta charset=\"UTF-8\">
    <title>收银台</title>
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta name=\"format-detection\" content=\"telephone=no\">
    <meta name=\"renderer\" content=\"webkit\">
    <meta http-equiv=\"Cache-Control\" content=\"no-siteapp\">
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/amazeui@2.7.2/dist/css/amazeui.min.css\">
    <script src=\"https://cdn.jsdelivr.net/npm/jquery@2.1.4/dist/jquery.min.js\"></script>
    <script src=\"https://cdn.jsdelivr.net/npm/jquery.qrcode@1.0.3/jquery.qrcode.min.js\"></script>
    <script src=\"https://cdn.jsdelivr.net/npm/amazeui@2.7.2/dist/js/amazeui.min.js\"></script>
    <script src=\"https://js.stripe.com/v3/\"></script>
    <style>
        @media only screen and (min-width: 641px) {
            .am-offcanvas {
                display: block;
                position: static;
                background: none;
            }

            .am-offcanvas-bar {
                position: static;
                width: auto;
                background: none;
                -webkit-transform: translate3d(0, 0, 0);
                -ms-transform: translate3d(0, 0, 0);
                transform: translate3d(0, 0, 0);
            }

            .am-offcanvas-bar:after {
                content: none;
            }
        }

        @media only screen and (max-width: 640px) {
            .am-offcanvas-bar .am-nav > li > a {
                color: #ccc;
                border-radius: 0;
                border-top: 1px solid rgba(0, 0, 0, .3);
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, .05)
            }

            .am-offcanvas-bar .am-nav > li > a:hover {
                background: #404040;
                color: #fff
            }

            .am-offcanvas-bar .am-nav > li.am-nav-header {
                color: #777;
                background: #404040;
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, .05);
                text-shadow: 0 1px 0 rgba(0, 0, 0, .5);
                border-top: 1px solid rgba(0, 0, 0, .3);
                font-weight: 400;
                font-size: 75%
            }

            .am-offcanvas-bar .am-nav > li.am-active > a {
                background: #1a1a1a;
                color: #fff;
                box-shadow: inset 0 1px 3px rgba(0, 0, 0, .3)
            }

            .am-offcanvas-bar .am-nav > li + li {
                margin-top: 0;
            }
        }

        .my-head {
            margin-top: 40px;
            text-align: center;
        }

        .am-tab-panel {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .my-footer {
            border-top: 1px solid #eeeeee;
            padding: 10px 0;
            margin-top: 10px;
            text-align: center;
        }

        .panel-title {
            display: inline;
            font-weight: bold;
        }

        .display-table {
            display: table;
        }

        .display-tr {
            display: table-row;
        }

        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 61%;
        }

        .StripeElement {
            box-sizing: border-box;

            height: 40px;

            padding: 10px 12px;

            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;

            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
        .form-row {
            width: 70%;
            float: left;
        }
        .wrapper {
            width: 670px;
            margin: 0 auto;
        }
        label {
            font-weight: 500;
            font-size: 14px;
            display: block;
            margin-bottom: 8px;
        }
        .button {
            border: none;
            border-radius: 4px;
            outline: none;
            text-decoration: none;
            color: #fff;
            background: #32325d;
            white-space: nowrap;
            display: inline-block;
            height: 40px;
            line-height: 40px;
            padding: 0 14px;
            box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.025em;
            text-decoration: none;
            -webkit-transition: all 150ms ease;
            transition: all 150ms ease;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<header class=\"am-g my-head\">
    <div class=\"am-u-sm-12 am-article\">
        <h1 class=\"am-article-title\">收银台</h1>
    </div>
</header>
<hr class=\"am-article-divider\">
<div class=\"am-container\">
    <h2>付款信息
        <div class=\"am-topbar-right\">¥{$price}</div>
    </h2>
    <p><small>订单编号：$orderid</small></p>
    <div class=\"am-tabs\" data-am-tabs=\"\">
        <ul class=\"am-tabs-nav am-nav am-nav-tabs\">
            <li class=\"am-active\"><a href=\"#alipay\">Alipay 支付宝</a></li>
            <li class=\"request-wechat-pay\"><a href=\"#wcpay\">微信支付</a></li>
            <li class=\"request-card-pay\"><a href=\"#cardpay\">银行卡支付</a></li>
        </ul>
        <div class=\"am-tabs-bd am-tabs-bd-ofv\"
             style=\"touch-action: pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">
            <div class=\"am-tab-panel am-active\" id=\"alipay\">
                <a class=\"am-btn am-btn-lg am-btn-warning am-btn-primary\" id=\"alipaybtn\" href=\"#\">进入支付宝付款</a>
                <p></p>
            </div>
            <div class=\"am-tab-panel am-fade\" id=\"wcpay\">
                <div class=\"text-align:center; margin:0 auto; width:60%\">
                    <div class=\"wcpay-qrcode\" style=\"text-align: center; \" data-requested=\"0\">
                        正在加载中...
                    </div>
                </div>
            </div>
            <div class=\"am-tab-panel am-fade\" id=\"cardpay\">
                <div class=\"text-align:center; margin:0 auto; width:60%\">
                <div class=\"wrapper cardpay_content\" style=\"max-width:500px\">
                <div class=\"am-alert am-alert-danger\" style=\"display:none\">支付失败，请更换卡片或检查输入信息</div>
                    <form action=\"/pay/stripe/charge\" method=\"post\" id=\"payment-form\">
                        <div class=\"form-row\">
                            <label for=\"card-element\">
                                <p class='am-alert am-alert-secondary'>借记卡或信用卡</p>
                            </label>
                            <div id=\"card-element\">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <!-- Used to display form errors. -->
                            <div id=\"card-errors\" role=\"alert\"></div>
                        </div>
                            <div class=\"form-row\">
                            <button class=\"button\">支付</button>
                        </div>

                    </form>
                </div>
                 </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    var stripe = Stripe('$pk');
    var source = '';
    // Create a Stripe client.

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '\"Helvetica Neue\", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.on('change', function (event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        $(\".button\").attr(\"disabled\",\"true\");
        $(\".button\").html(\"请稍后\");
        stripe.createToken(card).then(function (result) {
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                stripeTokenHandler(result.token);
            }
        });
    });

    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        var hiddenInput1 = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        hiddenInput1.setAttribute('type', 'hidden');
        hiddenInput1.setAttribute('name', 'orderid');
        hiddenInput1.setAttribute('value', '$orderid');
        form.appendChild(hiddenInput);
        form.appendChild(hiddenInput1);
        // Submit the form
        //form.submit();
        $.ajax({
            url: '/pay/stripe/charge/?orderid=$orderid&stripeToken=' + token.id,
            type: 'GET',
            success: function (result) {
                if (result == \"success\") {
                    $(\".cardpay_content\").html(\"\");
                    $(\".cardpay_content\").html(\"<p class='am-alert am-alert-success'>支付成功，正在跳转页面</p>\");
                    window.setTimeout(function () {
                        location.href = \"/detail-order-sn/$orderid\"
                    }, 800);
                } else {
                    $(\".am-alert\").show();
                    $(\".button\").removeAttr(\"disabled\");
                    $(\".button\").html(\"支付\");
                    setTimeout(\" $('.am-alert').hide();\", 3000);
                }
            }
        });
    }

    (function () {
        stripe.createSource({
            type: 'alipay',
            amount: $amount,
            currency: 'cny',
            // 这里你需要渲染出一些用户的信息，不然后期没法知道是谁在付钱
            owner: {
                name: '$orderid',
            },
            redirect: {
                return_url: '$return_url',
            },
        }).then(function (result) {
            $(\"#alipaybtn\").attr(\"href\", result.source.redirect.url);
        });
    })();

    function paymentcheck() {
        $.ajax({
            url: '/pay/stripe/check/?orderid=$orderid&source=' + source,
            type: 'GET',
            success: function (result) {
                if (result == \"success\") {
                    $(\".wcpay-qrcode\").html(\"\");
                    $(\".wcpay-qrcode\").html(\"<p class='am-alert am-alert-success'>支付成功，正在跳转页面</p>\");
                    window.setTimeout(function () {
                        location.href = \"/detail-order-sn/$orderid\"
                    }, 800);
                } else {
                    setTimeout(\"paymentcheck()\", 1000);
                }
            }
        });
    }

    $(\".request-wechat-pay\").click(function () {
        if ($(\".wcpay-qrcode\").data(\"requested\") == 0) {
            stripe.createSource({
                type: 'wechat',
                amount: $usd,
                currency: 'usd',
                owner: {
                    name: '$orderid'
                },
            }).then(function (result) {
                if (result.source.id) {
                    $(\".wcpay-qrcode\").html(\"<p class='am-alert am-alert-success'>打开微信 - 扫一扫</p>\");
                    $(\".wcpay-qrcode\").qrcode(result.source.wechat.qr_code_url);
                    $(\".wcpay-qrcode\").data(\"requested\", 1);
                    $(\".wcpay-qrcode\").data(\"sid\", result.source.id);
                    $(\".wcpay-qrcode\").data(\"scs\", result.source.client_secret);
                    source = result.source.id;
                    setTimeout(\"paymentcheck()\", 3000);
                } else {
                    alert(\"微信支付加载失败\");
                    $(\".wcpay-qrcode\").html(\"<p class='am-alert am-alert-danger'>加载失败，请刷新页面。</p>\");
                }
                // handle result.error or result.source
            });
        }
    });
</script>
</body>
</html>";

                    return $html;
                } catch (\Exception $e) {
                    throw new RuleValidationException(__('dujiaoka.prompt.abnormal_payment_channel') . $e->getMessage());
                }
                break;
        }
    }

    public function returnUrl(Request $request)
    {

        $data = $request->all();
        $cacheord = $this->orderService->detailOrderSN($data['orderid']);
        if (!$cacheord) {
            return redirect(url('detail-order-sn', ['orderSN' => $data['orderid']]));
        }
        $payGateway = $this->payService->detail($cacheord->pay_id);
        \Stripe\Stripe::setApiKey($payGateway -> merchant_pem);
        $source_object = \Stripe\Source::retrieve($data['source']);
        //die($source_object);
        if ($source_object->status == 'chargeable') {
            \Stripe\Charge::create([
                'amount' => $source_object->amount,
                'currency' => $source_object->currency,
                'source' => $data['source'],
            ]);
            if ($source_object->owner->name == $data['orderid']) {
                $this->orderProcessService->completedOrder($data['orderid'], $source_object->amount / 100, $source_object->id);
            }
        }
        return redirect(url('detail-order-sn', ['orderSN' => $data['orderid']]));
    }

    public function check(Request $request)
    {

        $data = $request->all();
        $cacheord = $this->orderService->detailOrderSN($data['orderid']);
        if (!$cacheord) {
            //可能已异步回调成功，跳转
            return 'fail';
        } else {
            $payGateway = $this->payService->detail($cacheord->pay_id);
            \Stripe\Stripe::setApiKey($payGateway -> merchant_pem);
            $source_object = \Stripe\Source::retrieve($data['source']);
            if ($source_object->status == 'chargeable') {
                \Stripe\Charge::create([
                    'amount' => $source_object->amount,
                    'currency' => $source_object->currency,
                    'source' => $data['source'],
                ]);
            }
            if ($source_object->status == 'consumed' && $source_object->owner->name == $data['orderid']) {
                $this->orderProcessService->completedOrder($data['orderid'], $cacheord->actual_price, $source_object->id);
                return 'success';
            } else {
                return 'fail';
            }
        }

    }

    public function charge(Request $request)
    {
        $data = $request->all();
        $cacheord = $this->orderService->detailOrderSN($data['orderid']);
        if (!$cacheord) {
            //可能已异步回调成功，跳转
            return 'fail';
        } else {
            try {
                $payGateway = $this->payService->detail($cacheord->pay_id);
                \Stripe\Stripe::setApiKey($payGateway -> merchant_pem);
                $result = \Stripe\Charge::create([
                    'amount' => bcmul($this->getUsdCurrency($cacheord->actual_price), 100,2),
                    'currency' => 'usd',
                    'source' => $data['stripeToken'],
                ]);
                if ($result->status == 'succeeded') {
                    $this->orderProcessService->completedOrder($data['orderid'], $cacheord->actual_price, $data['stripeToken']);
                    return 'success';
                }
                return $result;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }

    /**
     * 根据RMB获取美元
     * @param $cny
     * @return float|int
     * @throws \Exception
     */
    public function getUsdCurrency($cny)
    {
        $client = new Client();
        $res = $client->get('https://m.cmbchina.com/api/rate/getfxrate');
        $fxrate = json_decode($res->getBody(), true);
        if (!isset($fxrate['data'])) {
            throw new \Exception('汇率接口异常');
        }
        $dfFxrate = 0.13;
        foreach ($fxrate['data'] as $item) {
            if ($item['ZCcyNbr'] == "美元") {
                $dfFxrate = bcdiv(100, $item['ZRtcOfr'], 2);
                break;
            }
        }
        return bcmul($cny , $dfFxrate , 2);
    }


}
