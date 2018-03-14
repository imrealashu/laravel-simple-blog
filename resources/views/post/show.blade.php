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
    </div>
</div>
@endsection
