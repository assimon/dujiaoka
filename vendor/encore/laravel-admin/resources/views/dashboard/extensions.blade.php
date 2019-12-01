<style>
    .ext-icon {
        color: rgba(0,0,0,0.5);
        margin-left: 10px;
    }
    .installed {
        color: #00a65a;
        margin-right: 10px;
    }
</style>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Available extensions</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <ul class="products-list product-list-in-box">

            @foreach($extensions as $extension)
            <li class="item">
                <div class="product-img">
                    <i class="fa fa-{{$extension['icon']}} fa-2x ext-icon"></i>
                </div>
                <div class="product-info">
                    <a href="{{ $extension['link'] }}" target="_blank" class="product-title">
                        {{ $extension['name'] }}
                    </a>
                    @if($extension['installed'])
                        <span class="pull-right installed"><i class="fa fa-check"></i></span>
                    @endif
                </div>
            </li>
            @endforeach

            <!-- /.item -->
        </ul>
    </div>
    <!-- /.box-body -->
    <div class="box-footer text-center">
        <a href="https://github.com/laravel-admin-extensions" target="_blank" class="uppercase">View All Extensions</a>
    </div>
    <!-- /.box-footer -->
</div>