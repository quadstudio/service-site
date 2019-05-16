<form id="form-content" method="POST" action="{{ route('engineers.store', ['certificate_type_id' => $certificate_type_id]) }}">
    @csrf
    @include('site::engineer.form.fields')
</form>