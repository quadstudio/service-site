@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        @admin()
                        a
                        @elseadmin()
                        u
                        @endadmin
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
