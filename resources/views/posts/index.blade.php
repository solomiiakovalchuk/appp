@extends('layouts.main')
@section('content')
    <x-banner :sliderPosts="$sliderPosts"/>
    <section class="blog-posts">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="all-blog-posts">
                        <div class="row">
                            @foreach ($posts as $post)
                                <x-posts.single :post="$post" />
                            @endforeach
                            <div class="col-lg-12">
                                <div class="main-button">
                                    <a href="{{ route('posts.more') }}">View All Posts</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <x-posts.sidebar :tags="$tags" :recentPosts="$recentPosts" />
            </div>
        </div>
    </section>
@endsection
