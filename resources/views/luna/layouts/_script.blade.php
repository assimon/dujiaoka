<script>
    let tipsMsg = {
        least_one    : '{{ __('luna.least_one') }}',
        exceeds      : '{{ __('luna.exceeds') }}',
        exceeds_limit: '{{ __('luna.exceeds_limit') }}',
        mobile_order : '{{ __('luna.mobile_order') }}'
    };
</script>
<script src="/assets/luna/layui/layui.js"></script>
<script src="/assets/luna/js/jquery-3.4.1.min.js"></script>
<script src="/assets/luna/main.js"></script>
<script src="/assets/luna/layui/lay/modules/layer.js"></script>
<script>
/**
 * 全局推广码捕获脚本
 *
 * 功能：检测 URL 中的 ?aff=xxx 参数，如果存在则存储到浏览器 localStorage
 * 用途：支持用户通过推广链接访问网站的任意页面，稍后在购买页面自动应用优惠码
 *
 * 示例：用户访问 https://fk.codesome.cn/?aff=summer2024
 *      推广码 "summer2024" 会被存储到 localStorage，关闭浏览器后仍然有效
 */
(function() {
    // 获取 URL 查询参数
    const urlParams = new URLSearchParams(window.location.search);
    const affCode = urlParams.get('aff');

    // 如果 URL 包含 aff 参数
    if (affCode) {
        try {
            // 存储到 localStorage（覆盖旧值）
            localStorage.setItem('affCode', affCode);
            console.log('[Affiliate] 推广码已保存:', affCode);
        } catch (e) {
            // localStorage 可能在隐私模式下不可用
            console.warn('[Affiliate] 无法保存推广码到 localStorage:', e);
        }
    }
})();
</script>
