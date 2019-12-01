# FAQ

1. 支付宝支付成功，但是对返回数据验签老是失败。

   绝大部分问题都是配置问题，首先请确认 **正确填写了支付宝公钥（注意不是应用公钥）**。

   如果还没解决，请参考 github 的 issue：[https://github.com/yansongda/pay/issues/73](https://github.com/yansongda/pay/issues/73)

   如果仍然没解决，请检查您所使用的框架是否对 get/post 数据进行了增加，请自行处理好 Nginx/Apache 对框架的 URL 重写问题
  
2. 我是做 API 的，怎样可以不用 send 出 Response 中的内容？

   返回的 Response 中，`$response->getContent()` 可获取内容，RedirectResponse 中，`$response->getTargetUrl()` 可获取跳转链接，JsonResponse 中，`$response->getContent()` 可获取Json。

3. cURL error 60: SSL certificate problem: unable to get local issuer certificate

   服务器环境配置问题。

   请参考 [https://github.com/yansongda/pay/issues/16](https://github.com/yansongda/pay/issues/16)

4. 是否支持其他支付平台？比如：银联、京东。

   由于使用限制，暂不支持。

   **欢迎 PR！**

5. 支付宝是否支持 AES 等加密方式？

   因为支付宝推荐 RSA2 ，所以不推荐也不支持除 **RSA2** 以外的任何加密方式！
