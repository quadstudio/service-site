<div class="row row-hover py-2 border-bottom">
    <div class="col-sm-2">
        <b class="d-sm-none d-inline-block">@lang('site::member.region_id'): </b>
        {{$member->region->name}}
    </div>
    <div class="col-sm-2">
        <b class="d-sm-none d-inline-block">@lang('site::member.city'): </b>
        {{$member->city}}
    </div>
    <div class="col-sm-2">
        <b class="d-sm-none d-inline-block">@lang('site::member.type_id'): </b>
        {{$member->type->name}}
    </div>
    <div class="col-sm-2">
        <b class="d-sm-none d-inline-block">@lang('site::member.header.date_from_to'): </b>
        <div>@lang('site::member.date_from')&nbsp;&nbsp;&nbsp;{{$member->date_from()}}</div>
        <div>@lang('site::member.date_to')&nbsp;{{$member->date_to()}}</div>
    </div>
    <div class="col-sm-4">
        <b class="d-sm-none d-inline-block">@lang('site::member.name'): </b>
        {{$member->name}}
    </div>
</div>