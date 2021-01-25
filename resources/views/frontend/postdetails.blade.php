@extends('layouts.app')
@section('title', Str::limit($post->title, 28, '....') )
@section('content')
                                    {{--
                                                <img src="/frontend/{{ get_gravatar($comment->email, 70) }}" alt="comment images">
                                @endif --}}
    <!-- Start Breadcrumb area -->
    <div class="ht__bradcaump__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Blog Details</h2>
                        <nav class="bradcaump-content">
                          <a class="breadcrumb_item" href="index.html">Home</a>
                          <span class="brd-separetor">/</span>
                          <span class="breadcrumb_item active">Blog-Details</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <div class="page-blog-details section-padding--lg bg--white">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12">
                    <div class="blog-details content">
                        <article class="blog-post-details">
                            <div class="post-thumbnail">
                                @if ($post->media->count() > 0)
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        @if($post->media->count() > 1)
                                        <ol class="carousel-indicators">
                                            @foreach($post->media as $key => $val)
                                                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="{{ ($key == 0)? 'active':'' }}"></li>
                                            @endforeach
                                        </ol>
                                        @endif
                                        <div class="carousel-inner">
                                            @foreach($post->media as $key => $media)
                                            <div class="carousel-item {{ ($key == 0)? 'active':'' }}">
                                                <img src="{{ asset($media->file_name) }}" class="d-block w-100" alt="blog images">
                                            </div>
                                            @endforeach
                                        </div>
                                        @if($post->media->count() > 1)
                                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                        @endif
                                    </div>
                                @else
                                <img src="/frontend/images/blog/big-img/1.jpg" alt="blog images">
                                @endif

                            </div>
                            <div class="post_wrapper">
                                <div class="post_header">
                                    <h2>{{ $post->title }}</h2>
                                    <div class="blog-date-categori">
                                        <ul>
                                            <li>{{ $post->created_at->format('F d, Y h:i a') }} / Category : {{ $post->category->name }}</li>
                                            <li><a href="#" title="Posts by boighor" rel="author">{{ $post->user->name }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="post_content">
                                    {!! $post->description !!}
                                </div>
                            </div>
                        </article>
                        <div class="comments_area border-top">
                            <h3 class="comment__title mt-4">{{ $post->comments->count() }} Comment{{ ($post->comments->count() > 1)? 's': '' }}</h3>
                            <ul class="comment__list">
                                @forelse ($post->comments as $comment)
                                <li>
                                    <div class="wn__comment">
                                        <div class="thumb">
                                            <img src="/frontend/images/blog/comment/1.jpeg" alt="comment images">
                                        </div>
                                        <div class="content">
                                            <div class="comnt__author d-block d-sm-flex">
                                                <span><a href="#">{{ $comment->name }}</a></span>
                                                <span>{{ $comment->created_at->format('F d, Y h:i a') }}</span>
                                                <div class="reply__btn">
                                                    <a href="#">Reply</a>
                                                </div>
                                            </div>
                                            <p>{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <p class="text-capitalize mb-4">no found comments</p>
                                @endforelse
                                {{-- <li class="comment_reply">
                                    <div class="wn__comment">
                                        <div class="thumb">
                                            <img src="/frontend/images/blog/comment/1.jpeg" alt="comment images">
                                        </div>
                                        <div class="content">
                                            <div class="comnt__author d-block d-sm-flex">
                                                <span><a href="#">admin</a> Post author</span>
                                                <span>October 6, 2014 at 9:26 am</span>
                                                <div class="reply__btn">
                                                    <a href="#">Reply</a>
                                                </div>
                                            </div>
                                            <p>Sed interdum at justo in efficitur. Vivamus gravida volutpat sodales. Fusce ornare sit</p>
                                        </div>
                                    </div>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="comment_respond">
                            <h3 class="reply_title">Leave a Comment</h3>
                            @if ($post->comment_able == 1)
                            <form class="comment__form" action="{{ route('post.store', $post->id) }}" method="POST" id="send-comment">
                                @csrf
                                <div class="input__box">
                                    <textarea name="comment" placeholder="Your comment here">{{ old('comment') }}</textarea>
                                    @error('comment')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                @guest
                                <div class="input__wrapper clearfix">
                                    <div class="input__box name one--third">
                                        <input type="text" name="name" placeholder="name" value="{{ old('name')}}">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="input__box email one--third">
                                        <input type="email" name="email" placeholder="email" value="{{ old('email')}}">
                                        @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                @endguest
                                <div class="submite__btn">
                                    <a href="{{ route('post.store', $post->id) }}" onclick="event.preventDefault();document.getElementById('send-comment').submit()">Post Comment</a>
                                </div>
                            </form>
                            @else
                            <div>
                                comment unable
                            </div>
                        @endif

                        </div>
                    </div>
                </div>
                @include('partial.frontend.sidebar')
            </div>
        </div>
    </div>
    <!-- Footer Area -->
@endsection
