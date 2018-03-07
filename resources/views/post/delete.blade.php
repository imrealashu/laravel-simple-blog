@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            Are you sure want to delete this?
            <form method="DELETE" action="{{ url('/post/delete' . $post->slug) }}">

            </form>
        </div>
        <div class="col-md-4">
            {{-- <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection
