@extends('layouts.main')

@section('content')
    <div id="comment-alert" class="alert alert-success alert-dismissible fade show position-fixed" role="alert" style="display: none; top: 120px; right:10px; z-index: 100000; max-width: 90%;">
        Comment created successfully!
    </div>

    <section class="blog-posts grid-system">
      <div class="container">
        <div class="row">
          <!-- Post content on the left -->
          <div class="col-lg-8">
            <div class="all-blog-posts">
              <div class="row">
                <div class="col-lg-12">
                    <x-posts.details :post="$post" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <x-comments.lists :comments="$post->comments" />
            <x-comments.form :post="$post" />
          </div>
        </div>
      </div>
    </section>
@endsection
