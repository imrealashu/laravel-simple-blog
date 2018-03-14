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
                    </h4>
                    <div class="pull-left">
                      <span style="color: #b7b7b7">Posted By</span>&nbsp;{{ $post->user->name }}
                      @auth
                        @if(Auth::user()->id === $post->user_id)
                        (you)
                        @endif
                      @endauth
                    </div>
                    <div class="pull-right">
                      <span style="color: #b7b7b7">{{\Carbon\Carbon::parse($post->created_at)->format('l jS \\of F Y h:i A')}}</span>
                    </div>
                    <div class="clearfix"></div>
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
