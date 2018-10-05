<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body py-1">
            <div class="row">
                <div class="col-12 col-md-4 col-xl-4">
                    <div class="small text-muted">@lang('site::user.header.user')</div>
                    <a target="_blank" href="{{route('admin.users.show', $user)}}">{{ $user->name }}</a>
                    <div class="text-muted">{{ $user->address()->region->name }}
                        / {{ $user->address()->locality }}</div>
                </div>
                <div class="col-12 col-md-8 col-xl-8">
                    @foreach($user->contragents()->whereHas('repairs', function($repair){
                        $repair->whereStatusId(5);
                    })->get() as $contragent)
                        <div class="row">
                            <div class="col-12">
                                <div class="small text-muted">@lang('site::contragent.name')</div>
                                <a target="_blank" href="{{route('admin.contragents.show', $contragent)}}">{{$contragent->name}}</a>
                            </div>
                            <div class="col-12">
                                @foreach($contragent->repairs()->whereStatusId(5)->whereNull('act_id')->get() as $repair)
                                    <div class="row border-top border-sm-top-0" id="act-repair-{{$repair->id}}">
                                        <div class="col-sm-3">
                                            <div class="custom-control custom-checkbox d-inline-block">
                                                <input type="checkbox"
                                                       @if(!$repair->check())
                                                       disabled
                                                       @endif
                                                       name="repair[{{$user->id}}][{{$repair->contragent_id}}][]"
                                                       value="{{$repair->id}}"
                                                       class="custom-control-input @if($repair->check()) is-valid @endif"
                                                       id="repair-check-{{$repair->id}}">
                                                <label class="custom-control-label"
                                                       for="repair-check-{{$repair->id}}">№ {{$repair->id}}</label>
                                                <a href="{{route('admin.repairs.show', $repair)}}"><i
                                                            class="ml-1 fa fa-external-link"></i></a>

                                            </div>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="row">

                                                <div data-toggle="tooltip" data-placement="top"
                                                     title="@lang('site::repair.cost_distance')"
                                                     class="col-sm-4 text-right">
                                                    {{Site::format($repair->cost_distance())}} <i
                                                            class="fa fa-@lang('site::repair.icons.road')"></i>
                                                </div>
                                                <div data-toggle="tooltip" data-placement="top"
                                                     title="@lang('site::repair.cost_difficulty')"
                                                     class="col-sm-4 text-right">
                                                    {{Site::format($repair->cost_difficulty())}} <i
                                                            class="fa fa-@lang('site::repair.icons.work')"></i>
                                                </div>
                                                <div class="col-sm-4 text-right @if(!$repair->checkParts()) text-danger @else text-success @endif">
                                        <span data-toggle="tooltip" data-placement="top"
                                              title="@lang('site::repair.cost_parts')">
                                            {{Site::format($repair->cost_parts())}} <i
                                                    class="fa fa-@lang('site::repair.icons.parts')"></i>
                                        </span>

                                                    <span data-toggle="tooltip" data-placement="top"
                                                          title="@lang('site::repair.contragent_id')"
                                                          class="d-block d-sm-inline-block ml-2 @if(!$repair->checkContragent()) text-danger @else text-success @endif">
                                            <i class="fa fa-@lang('site::contragent.icon')"></i>
                                        </span>
                                                </div>


                                            </div>
                                        </div>


                                    </div>
                                @endforeach
                            </div>
                        </div>

                    @endforeach

                    {{--{{$repair->created_at()}}--}}
                </div>
            </div>

        </div>
    </div>
</div>