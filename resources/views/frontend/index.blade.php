@extends('layouts.app')
@section('title', 'CMS')
@section('content')
 <!-- Start Bradcaump area -->
  <div class="ht__bradcaump__area bg-image--4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bradcaump__inner text-center">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->

<!-- Start Blog Area -->
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="blog-page">
                    <div class="page__header">
                        <h2>Category Archives: HTML</h2>
                    </div>
                    @foreach ($posts as $post)
                    <!-- Start Single Post -->
                    <article class="blog__post d-flex flex-wrap">
                        <div class="thumb">
                            <a href="blog-details.html">
                                @if ($post->media->count() > 0)
                                <img src="{{ asset($post->media->first()->file_name) }}" alt="blog images">
                                @else
                                <img src="/frontend/images/blog/blog-3/1.jpg" alt="blog images">
                                @endif
                            </a>
                        </div>
                        <div class="content">
                            <h5><a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a></h5>
                            <ul class="post__meta">
                                <li>Posts by : <a href="#">{{ $post->user->name }}</a>  / {{ $post->created_at->format('d-M-Y') }} <br> Category : <a href="">{{ $post->category->name }}</a></li>
                            </ul>
                            <p>{{ $post->summary }}</p>
                            <div class="blog__btn">
                                <a href="{{ route('post.show', $post->slug) }}">read more</a>
                            </div>
                        </div>
                    </article>
                    <!-- End Single Post -->
                    @endforeach
                </div>
                {!! $posts->links() !!}
            </div>
            @include('partial.frontend.sidebar')
        </div>
    </div>
</div>
<!-- End Blog Area -->


@endsection
