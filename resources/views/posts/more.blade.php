@extends('layouts.main')
@section('content')
    <section class="blog-posts grid-system">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @if (isset($filterTitle))
                        <h1>{{ $filterTitle }}</h1>
                    @endif
                    <div class="mt-2 all-blog-posts">
                        <div class="row">
                            @foreach ($posts as $post)
                                <x-posts.single-small :post="$post" />
                            @endforeach
                            <div class="col-lg-12">
                                <div class="pagination-wrapper">
                                    {{ $posts->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <x-posts.sidebar :tags="$tags" :recentPosts="$recentPosts"/>
            </div>
        </div>
    </section>
@endsection
