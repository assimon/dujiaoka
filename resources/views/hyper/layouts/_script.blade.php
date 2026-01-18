<script src="/assets/hyper/js/jquery-3.4.1.min.js"></script>
<script src="/assets/hyper/js/vendor.min.js"></script>
<script src="/assets/hyper/js/app.min.js"></script>
<script src="/assets/hyper/js/hyper.js?v=215115"></script>
<script>
/**
 * 全局推广码捕获脚本
 *
 * 功能：检测 URL 中的 ?aff=xxx 参数，如果存在则存储到浏览器 localStorage
 * 用途：支持用户通过推广链接访问网站的任意页面，稍后在购买页面自动应用优惠码
 */
(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const affCode = urlParams.get('aff');
    if (affCode) {
        try {
            localStorage.setItem('affCode', affCode);
            console.log('[Affiliate] 推广码已保存:', affCode);
        } catch (e) {
            console.warn('[Affiliate] 无法保存推广码到 localStorage:', e);
        }
    }
})();
</script>