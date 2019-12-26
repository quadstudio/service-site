<div class="card mb-2" id="digift-bonus">
    <div class="card-body">
        <h5 class="card-title">@lang('site::digift_bonus.header.digift_bonus')</h5>
        @alert()@endalert()
        @if($bonusable->digiftBonus()->exists())
            @include('site::admin.digift_bonus.show')
        @else
            @can('digiftBonus', $bonusable)
                @include('site::admin.digift_bonus.create')
            @endcan
            @cannot('digiftBonus', $bonusable)
            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">@lang('site::messages.attention')</h4>
                <p>{{$bonusable->bonusCreateMessage()}}</p>
            </div>
            @endcannot
        @endif
    </div>
</div>