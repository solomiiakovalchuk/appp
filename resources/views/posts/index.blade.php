@extends('layouts.main')
@section('content')
        <!-- <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ $post->image_path }}" class="card-img-top" alt="{{ $post->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->short_description }}</p>
                            <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> -->
        <x-banner />
    <section class="blog-posts">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="all-blog-posts">
              <div class="row">
              @foreach ($posts as $post)
                    <x-posts.single :post="$post"/>
                @endforeach
                <div class="col-lg-12">
                  <div class="main-button">
                    <a href="{{ route('posts.more') }}">View All Posts</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
                <x-posts.sidebar/>
        </div>
      </div>
    </section>
@endsection