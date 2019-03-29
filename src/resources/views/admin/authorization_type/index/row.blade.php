<div class="items-col col-12" id="authorization_type-{{$authorization_type->id}}">

    <div class="card mb-2">
        <div class="card-body">

            <a class="text-big" href="{{route('admin.authorization-types.edit', $authorization_type)}}">
                {{$authorization_type->name}} {{$authorization_type->brand->name}}
            </a>
            <div class="text-muted">
                @bool(['bool' => $authorization_type->enabled, 'enabled' => true])@endbool
            </div>
        </div>
    </div>

</div>
