<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 col-xl-4">
                    <a class="text-large text-dark"
                       href="{{ route('admin.catalogs.show', $catalog) }}">{{ $catalog->name }}</a>
                    @if(!is_null($catalog->catalog))
                        <div class="text-muted">{{ $catalog->catalog->name }}</div>
                    @endif
                </div>
                <div class="col-12 col-md-6 col-xl-7">
                    <div class="mb-2 mb-md-0 text-muted">
                        @foreach($catalog->equipments as $equipment)
                            <a class="d-block mr-2" href="{{route('admin.equipments.show', $equipment)}}">{{$equipment->name}}</a>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-md-2 col-xl-1">
                    <div class="mb-2 mb-md-0 text-secondary text-left text-md-right">
                        @if($catalog->canAddCatalog())
                            <a class="btn btn-ferroli" data-toggle="tooltip" data-placement="top"
                               title="@lang('site::messages.add') @lang('site::catalog.catalog')"
                               href="{{ route('admin.equipments.create.parent', $catalog) }}">
                                <i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-@lang('site::catalog.icon')" aria-hidden="true"></i>
                            </a>
                        @endif
                            @if($catalog->canAddEquipment())
                                <a class="btn btn-ferroli" data-toggle="tooltip" data-placement="top"
                                   title="@lang('site::messages.add') @lang('site::equipment.equipment')"
                                   href="{{ route('admin.equipments.create.parent', $catalog) }}">
                                    <i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-@lang('site::equipment.icon')" aria-hidden="true"></i>
                                </a>
                            @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>