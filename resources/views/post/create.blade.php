@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <create-post dusk="create-post-component" @if(isset($post)) :post-data="{{ $post }}" @endif></create-post>
        </div>
    </div>
</div>
@endsection
