<form id="form-content" method="POST" action="{{ route('engineers.store') }}">
    @csrf
    @include('site::engineer.form.fields')
</form>