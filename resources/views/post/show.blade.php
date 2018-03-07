@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4><a href="{{ url('post/show/' . $post->slug) }}">{{ $post->title }}</a></h4>
            <p>
                {!! $post->description !!}
            </p>
            <comments :post-id="{{ $post->id }}" :comment-data="{{ $post->comments }}" @auth :auth-user="{{ auth()->user() }}" @endauth></comments>
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
