@if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <p><i class="icon mr-2 fa fa-check"></i> {!! session('success') !!}</p>
    </div>
@endif
@if(session('info'))
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <p><i class="icon mr-2 fa fa-info"></i> {!! session('info') !!}</p>
    </div>
@endif
@if(session('warning'))
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <p><i class="icon mr-2 fa fa-exclamation"></i> {!! session('warning') !!}</p>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <p><i class="icon mr-2 fa fa-close"></i> {!! session('error') !!}</p>
    </div>
@endif