<header class="page-header-one">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <h1 class="uppercase mb-0">{!! $h1 !!}</h1>
            </div>
            <div class="col-md-12 col-lg-6">
                <ol class="breadcrumb">
                    @foreach ($breadcrumbs as $breadcrumb)
                        @if (!empty($breadcrumb['url']))
                            <li><a href="{{ $breadcrumb['url'] }}">{!! $breadcrumb['name'] !!}</a></li>
                        @else
                            <li class="active">{!! $breadcrumb['name'] !!}</li>
                        @endif
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</header>