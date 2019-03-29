<form id="form-content" method="POST" action="{{ route('launches.store') }}">
    @csrf
    @include('site::launch.form.fields')
</form>