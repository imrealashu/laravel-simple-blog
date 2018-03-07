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
                        {{-- {{ $post->description }} --}}
                    </p>
                </div>
            @endforeach
            @if(count($posts) !== 0)
              {{ $posts->links() }}
            @endif
        </div>
        <aside class="col-md-4 blog-sidebar">
          {{-- <div class="p-3 mb-3 bg-light rounded">
            <h4 class="font-italic">About</h4>
            <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
          </div>

          <div class="p-3">
            <h4 class="font-italic">Archives</h4>
            <ol class="list-unstyled mb-0">
              <li><a href="#">March 2014</a></li>
              <li><a href="#">February 2014</a></li>
              <li><a href="#">January 2014</a></li>
              <li><a href="#">December 2013</a></li>
              <li><a href="#">November 2013</a></li>
              <li><a href="#">October 2013</a></li>
              <li><a href="#">September 2013</a></li>
              <li><a href="#">August 2013</a></li>
              <li><a href="#">July 2013</a></li>
              <li><a href="#">June 2013</a></li>
              <li><a href="#">May 2013</a></li>
              <li><a href="#">April 2013</a></li>
            </ol>
          </div> --}}
        </aside>
    </div>
</div>
@endsection
