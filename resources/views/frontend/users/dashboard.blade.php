@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <!-- Start BLog Area -->
    <div class="htc__blog__area bg__white ptb--120">
        <div class="container">
            <h5 class="text-muted mb-3">My posts</h5>
            <div class="row">
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Comments</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($posts as $post)
                                    <tr>
                                        <td><a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a></td>
                                        <td>{{ $post->comments_count }}</td>
                                        <td>{{ $post->status }}</td>
                                        <td>
                                            <a href="{{ route('dashboard.edit', $post->id) }}" class="btn btn-light"><i class="fa fa-edit text-primary fa-fw fa-lg"></i></a>
                                            <a href="" class="btn btn-light" onclick="event.preventDefault(); if(confirm('Are You Sure Delete Post ?')){document.getElementById('form-delete-{{ $post->id }}').submit()} else false"><i class="fa fa-trash fa-lg text-danger"></i></a>
                                            <form action="{{ route('dashboard.destroy',  $post->id ) }}" method="POST" id="form-delete-{{ $post->id }}" style="display: none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center font-weight-bold text-muted">No Found Posts</td>
                                    </tr>
                                @endforelse


                            </tbody>
                        </table>
                        <div style="display: flex; justify-content: center">
                            {!! $posts->links() !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    @include('partial.frontend.userdashboard.sidebar')
                </div>
            </div>
        </div>
    </div>
    <!-- End BLog Area -->
@endsection
