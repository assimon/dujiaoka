@php
    // 检查是否有筛选条件
    $hasFilters = !empty($filters['start_date']) || !empty($filters['end_date']) || !empty($filters['order_sn']) || !empty($filters['goods_id']);
    $filterLabel = $hasFilters ? ' (筛选结果)' : '';
@endphp

<div class="row">
    <!-- 统计卡片 -->
    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['order_count'] }}</h3>
                <p>订单数量{{ $filterLabel }}</p>
            </div>
            <div class="icon">
                <i class="feather icon-shopping-cart"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($stats['total_amount'], 2) }}</h3>
                <p>订单总金额 (元){{ $filterLabel }}</p>
            </div>
            <div class="icon">
                <i class="feather icon-dollar-sign"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ number_format($stats['discount_amount'], 2) }}</h3>
                <p>折扣总金额 (元){{ $filterLabel }}</p>
            </div>
            <div class="icon">
                <i class="feather icon-tag"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ count($stats['goods_list']) }}</h3>
                <p>涉及商品数{{ $filterLabel }}</p>
            </div>
            <div class="icon">
                <i class="feather icon-package"></i>
            </div>
        </div>
    </div>
</div>

<!-- 推广码信息 -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">推广码信息</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 150px;">推广码</th>
                <td>{{ $affiliateCode->code }}</td>
            </tr>
            <tr>
                <th>折扣类型</th>
                <td>
                    @if($affiliateCode->discount_type == 1)
                        固定金额减免
                    @else
                        百分比折扣
                    @endif
                </td>
            </tr>
            <tr>
                <th>折扣值</th>
                <td>
                    @if($affiliateCode->discount_type == 1)
                        {{ $affiliateCode->discount_value }} 元
                    @else
                        {{ $affiliateCode->discount_value }} %
                    @endif
                </td>
            </tr>
            <tr>
                <th>使用次数</th>
                <td>{{ $affiliateCode->use_count }}</td>
            </tr>
            <tr>
                <th>状态</th>
                <td>
                    @if($affiliateCode->is_open == 1)
                        <span class="badge badge-success">启用</span>
                    @else
                        <span class="badge badge-danger">禁用</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>备注</th>
                <td>{{ $affiliateCode->remark ?: '-' }}</td>
            </tr>
        </table>
    </div>
</div>

<!-- 筛选条件 -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">筛选查询</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="" class="form-inline">
            <div class="form-group mr-3 mb-2">
                <label class="mr-2">开始日期</label>
                <input type="date" name="start_date" class="form-control form-control-sm"
                       value="{{ $filters['start_date'] ?? '' }}">
            </div>
            <div class="form-group mr-3 mb-2">
                <label class="mr-2">结束日期</label>
                <input type="date" name="end_date" class="form-control form-control-sm"
                       value="{{ $filters['end_date'] ?? '' }}">
            </div>
            <div class="form-group mr-3 mb-2">
                <label class="mr-2">订单号</label>
                <input type="text" name="order_sn" class="form-control form-control-sm"
                       placeholder="订单号搜索" value="{{ $filters['order_sn'] ?? '' }}">
            </div>
            <div class="form-group mr-3 mb-2">
                <label class="mr-2">商品</label>
                <select name="goods_id" class="form-control form-control-sm">
                    <option value="">全部商品</option>
                    @foreach($goodsList as $gid => $gname)
                        <option value="{{ $gid }}" {{ ($filters['goods_id'] ?? '') == $gid ? 'selected' : '' }}>
                            {{ $gname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-2">
                <button type="submit" class="btn btn-primary btn-sm mr-2">
                    <i class="feather icon-search"></i> 查询
                </button>
                <a href="{{ request()->url() }}" class="btn btn-secondary btn-sm">
                    <i class="feather icon-refresh-cw"></i> 重置
                </a>
            </div>
        </form>
    </div>
</div>

<!-- 涉及商品 -->
@if(count($stats['goods_list']) > 0)
<div class="card">
    <div class="card-header">
        <h3 class="card-title">涉及商品 (当前筛选结果)</h3>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-horizontal flex-wrap">
            @foreach($stats['goods_list'] as $goodsName)
                <li class="list-group-item">{{ $goodsName }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<!-- 订单明细 -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">订单明细</h3>
    </div>
    <div class="card-body">
        @if($orders->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>订单号</th>
                    <th>商品名称</th>
                    <th>订单总价</th>
                    <th>折扣金额</th>
                    <th>实付金额</th>
                    <th>下单时间</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_sn }}</td>
                    <td>{{ $order->goods->gd_name ?? '-' }}</td>
                    <td>{{ number_format($order->total_price, 2) }}</td>
                    <td>{{ number_format($order->affiliate_discount_price, 2) }}</td>
                    <td>{{ number_format($order->actual_price, 2) }}</td>
                    <td>{{ $order->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center text-muted py-4">
            <i class="feather icon-inbox" style="font-size: 48px;"></i>
            <p class="mt-2">暂无订单数据</p>
        </div>
        @endif
    </div>
</div>

<style>
.small-box {
    border-radius: 0.25rem;
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    display: block;
    margin-bottom: 20px;
    position: relative;
}
.small-box > .inner {
    padding: 10px;
}
.small-box h3 {
    font-size: 2.2rem;
    font-weight: 700;
    margin: 0 0 10px 0;
    padding: 0;
    white-space: nowrap;
}
.small-box p {
    font-size: 1rem;
    margin-bottom: 0;
}
.small-box > .icon {
    color: rgba(0,0,0,.15);
    z-index: 0;
    font-size: 70px;
    position: absolute;
    right: 15px;
    top: 15px;
    transition: all .3s linear;
}
.bg-info {
    background-color: #17a2b8 !important;
    color: #fff;
}
.bg-success {
    background-color: #28a745 !important;
    color: #fff;
}
.bg-warning {
    background-color: #ffc107 !important;
    color: #212529;
}
.bg-secondary {
    background-color: #6c757d !important;
    color: #fff;
}
</style>
