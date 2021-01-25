
<!-- new design -->
<div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
    <div class="wn__sidebar">
        <!-- Start Single Widget -->
        <aside class="widget search_widget">
            <h3 class="widget-title">Search</h3>
            <form action="#">
                <div class="form-input">
                    <input type="text" placeholder="Search...">
                    <button><i class="fa fa-search"></i></button>
                </div>
            </form>
        </aside>
        <!-- End Single Widget -->
        <!-- Start Single Widget -->
        <aside class="widget recent_widget">
            <h3 class="widget-title">Recent</h3>
            <div class="recent-posts">
                <ul>
                    @foreach ($latest_posts as $latest_post)
                        <li>
                            <div class="post-wrapper d-flex">
                                <div class="thumb" style="width: 50px; height: 51px;">
                                    @if ($latest_post->media->count() > 0)
                                     <a href="{{ route('post.show', $latest_post->slug) }}"><img src="{{ asset($latest_post->media->first()->file_name) }}" alt="blog images"></a>
                                    @else
                                     <a href="{{ route('post.show', $latest_post->slug) }}"><img src="/frontend/images/blog/sm-img/1.jpg" alt="blog images"></a>
                                    @endif
                                </div>
                                <div class="content">
                                    <h4><a href="{{ route('post.show', $latest_post->slug) }}">{{ Str::limit( $latest_post->title , 18, '...') }}</a></h4>
                                    <p>{{ $latest_post->created_at->format('M d, Y h:i a') }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
        <!-- End Single Widget -->
        <!-- Start Single Widget -->
        <aside class="widget comment_widget">
            <h3 class="widget-title">Comments</h3>
            <ul>
                @foreach($latest_comments as $latest_comment)
                <li>
                    <div class="post-wrapper">
                        <div class="thumb">
                            <img src="/frontend/images/blog/comment/1.jpeg" alt="Comment images">
                        </div>
                        <div class="content">
                            <p>{{$latest_comment->name}} says:</p>
                            <a href="{{route('post.show', $latest_comment->post->slug)}}">{{Str::limit($latest_comment->comment, 25, '...')}}</a>
                        </div>
                    </div>
                </li>
                @endforeach

            </ul>
        </aside>
        <!-- End Single Widget -->
        <!-- Start Single Widget -->
        <aside class="widget category_widget">
            <h3 class="widget-title">Categories</h3>
            <ul>
                @foreach ($categories as $category)
                <li><a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </aside>
        <!-- End Single Widget -->
        <!-- Start Single Widget -->
        <aside class="widget archives_widget">
            <h3 class="widget-title">Archives</h3>
            <ul>
                @foreach ($archives as $archive)
                <li><a href="{{ route('post.archive_show', ['date' => $archive->month, 'year' => $archive->year]) }}">{{ date('M', mktime(0, 0, 0, $archive->month))  . ' ' . $archive->year }}</a></li>
                @endforeach

            </ul>
        </aside>
        <!-- End Single Widget -->
    </div>
</div>
