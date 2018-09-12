<div class="items-col col-12">

    <div class="card mb-4">
        <div class="card-body">

            <div class="item-content">

                <div class="item-content-about">
                    <div class="item-content-user text-muted small mb-2">{{$address->type->name}}</div>
                    <h5 class="item-content-name mb-1">
                        <a href="javascript:void(0)">{{$address->name}}</a>
                    </h5>
                    <hr class="border-light">
                    <div>
                        <img style="width: 30px;" class="img-fluid border" src="{{ asset($address->country->flag) }}"
                             alt="">
                        {{$address->full}}
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>