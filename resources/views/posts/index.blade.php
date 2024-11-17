@extends('layouts.main')
@section('content')
    <x-banner :sliderPosts="$sliderPosts"/>
    <section class="blog-posts">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="all-blog-posts">
                        <div class="row" id="postsContainer">
                            @foreach ($posts as $post)
                                <x-posts.single :post="$post" />
                            @endforeach
                        </div>
                        <div class="col-lg-12">
                            <div class="main-button">
                                <a href="{{ route('posts.more') }}">{{ __('post.view_all_posts') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <x-posts.sidebar :tags="$tags" :categories="$categories" :recentPosts="$recentPosts" />
            </div>
        </div>
    </section>
@endsection
