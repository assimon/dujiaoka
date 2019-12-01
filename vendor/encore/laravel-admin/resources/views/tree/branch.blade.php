<li class="dd-item" data-id="{{ $branch[$keyName] }}">
    <div class="dd-handle">
        {!! $branchCallback($branch) !!}
        <span class="pull-right dd-nodrag">
            <a href="{{ url("$path/$branch[$keyName]/edit") }}"><i class="fa fa-edit"></i></a>
            <a href="javascript:void(0);" data-id="{{ $branch[$keyName] }}" class="tree_branch_delete"><i class="fa fa-trash"></i></a>
        </span>
    </div>
    @if(isset($branch['children']))
    <ol class="dd-list">
        @foreach($branch['children'] as $branch)
            @include($branchView, $branch)
        @endforeach
    </ol>
    @endif
</li>