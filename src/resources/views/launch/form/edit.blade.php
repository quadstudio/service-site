<form id="form-content" method="POST" action="{{ route('launches.update', $launch) }}">
    @csrf
    @method('PUT')
    @include('site::launch.form.fields')
</form>