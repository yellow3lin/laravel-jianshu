@extends('layout.main')
@section('content')
        <div class="col-sm-8 blog-main">
            <div class="blog-post">
                @foreach($notices as $notice)
                <p class="blog-post-meta">{{$notice->title}}</p>

                <p>{!! $notice->content !!}</p>
                    @endforeach
            </div>
        </div><!-- /.blog-main -->
@endsection