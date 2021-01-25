@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <!-- Start BLog Area -->
    <div class="htc__blog__area bg__white ptb--120">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Post</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($comments as $comment)
                                    <tr>
                                        <td>{{ $comment->name }}</td>
                                        <td><a href="{{ route('post.show', $comment->post->slug) }}">{{ $comment->post->title }}</a> </td>
                                        <td>{{ ($comment->status == 0)? 'InActive' : 'Active' }}</td>
                                        <td>
                                            <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-light"><i class="fa fa-edit fa-lg fa-fw text-primary"></i></a>
                                            <a href="" class="btn btn-light" onclick="event.preventDefault(); if(confirm('Are You Sure Delete comment ?')){document.getElementById('form-delete-{{ $comment->id }}').submit()} else false"><i class="fa fa-trash fa-lg fa-fw text-danger"></i></a>
                                            <form action="{{ route('comments.destroy',  $comment->id ) }}" method="POST" id="form-delete-{{ $comment->id }}" style="display: none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr style="text-align: center">
                                        <td colspan="4">No Found Comment</td>
                                    </tr>
                                @endforelse


                            </tbody>
                        </table>
                        <div style="display: flex; justify-content: center">
                            {!! $comments->links() !!}
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
