@extends('layouts.main')

@section('content')
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
