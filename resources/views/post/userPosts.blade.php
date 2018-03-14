@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(count($posts) === 0)
              <p class="text-center mt-5">Oops! No Posts to display.</p>
            @endif
            @foreach($posts as $post)
                <div>
                    <h4>
                      <a href="{{ url('post/show/' . $post->slug) }}">{{ $post->title }}</a>
                      @auth
                        @if(Auth::user()->id === $post->user_id)
                        <operations :post-data="{{$post}}"></operations>
                        @endif
                      @endauth
                    </h4>
                      <span style="color: #b7b7b7">{{\Carbon\Carbon::parse($post->created_at)->format('l jS \\of F Y h:i A')}}</span>
                    <p>
                        {{ \Illuminate\Support\Str::words(strip_tags($post->description), 50,'...')  }}
                    </p>
                </div>
            @endforeach
            @if(count($posts) !== 0)
              {{ $posts->links() }}
            @endif
        </div>
    </div>
</div>
@endsection
