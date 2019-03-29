<div class="items-col col-12" id="authorization_brand-{{$authorization_brand->id}}">

    <div class="card mb-2">
        <div class="card-body">

            <div class="item-content">

                <div class="item-content-about">
                    <a href="{{route('admin.authorization-brands.edit', $authorization_brand)}}">{{$authorization_brand->name}} </a>
                </div>
            </div>

        </div>
    </div>

</div>
