<form id="form-content" method="POST" action="{{ route('trades.update', $trade) }}">
    @csrf
    @method('PUT')
    @include('site::trade.form.fields')
</form>