@extends('layouts.app')
@section('content')
    <!-- Start Our Blog Area -->
    <section class="blog-details-wrap ptb--120 bg__white">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="blog-details-left-sidebar">
                        <div class="blog-details-top">
                            <h2>{{ $page->title }}</h2>
                            <!-- Start Blog Pra -->
                            <div class="blog-details-pra">
                                <p>{!! $page->description !!}</p>
                            </div>
                            <!-- End Blog Pra -->
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- End Our Blog Area -->
@endsection
