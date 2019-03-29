<form id="form-content" method="POST" action="{{ route('trades.store') }}">
    @csrf
    @include('site::trade.form.fields')
</form>