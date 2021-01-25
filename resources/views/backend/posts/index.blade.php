@extends('layouts.master')
@section('css')
<link href="{{ asset('js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row row-sm">
        <!--div-->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">All POSTS</h3>
                        @permission('create_post')
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary "><i
                                class="fa fa-plus fa-fw"></i> New Post</a>
                        @else
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary disabled"><i
                            class="fa fa-plus fa-fw"></i> New Post</a>
                        @endpermission
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <form action="{{ route('admin.posts.index') }}" method="GET">
                            <div class="row">
                                <div class="col-6 col-sm">
                                    <div class="form-group ">
                                        <input type="text" placeholder="Search Here" name="keywords" value="{{ old('keywords', request()->keywords) }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6 col-sm">
                                    <div class="form-group ">
                                        <select name="category_id" id="" class="form-control form-select">
                                            <option value="">---</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ isset(request()->category_id) && request()->category_id == $category->id ? 'selected':'' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-sm">
                                    <div class="form-group ">
                                        <select name="status" id="" class="form-control form-select">
                                            <option value="">---</option>
                                            <option value="1" {{ isset(request()->status) && request()->status == 1 ? 'selected':'' }}>Active</option>
                                            <option value="0" {{ isset(request()->status) && request()->status == 0 ? 'selected':'' }}>InActive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-sm">
                                    <div class="form-group ">
                                        <select name="paginate" id="" class="form-control form-select">
                                            <option value="10" {{ isset(request()->paginate) && request()->paginate == 10 ? 'selected':'' }}>10</option>
                                            <option value="20" {{ isset(request()->paginate) && request()->paginate == 20 ? 'selected':'' }}>20</option>
                                            <option value="50" {{ isset(request()->paginate) && request()->paginate == 50 ? 'selected':'' }}>50</option>
                                            <option value="100" {{ isset(request()->paginate) && request()->status == 100 ? 'selected':'' }}>100</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-sm">
                                    <div class="form-group ">
                                       <input type="submit" value="Search" class="btn btn-outline-primary">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0 text-lg-nowrap ">
                            <thead>
                                <tr class="text-center">
                                    <th>Title</th>
                                    <th>Comments</th>
                                    <th>Status</th>
                                    <th>Category</th>
                                    <th>User</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($posts as $post)

                                    <tr class="text-center">
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->comments->count() }}</td>
                                        <td>{{ $post->status }}</td>
                                        <td>{{ $post->category->name }}</td>
                                        <td>{{ $post->user->username }}</td>
                                        <td>{{ $post->created_at->format('D,m-y h:i a') }}</td>
                                        <td class="">
                                            @permission('update_post')
                                            <a href="{{ route('admin.posts.edit', $post->slug) }}" class="btn btn-light p-1"><i class="fa fa-edit fa-fw text-primary"></i></a>
                                            @else
                                            <a href="#" class="btn btn-light text-primary disabled p-1"><i class="fa fa-edit fa-fw"></i></a>
                                            @endpermission

                                            @permission('delete_post')
                                                <a href="" class="btn btn-light p-1 delete_post" data-title="Delete Post" data-description="Do You Want Delete This Post ({{$post->title}}) ?" data-toggle="modal" data-target="#exampleModal" data-comment="{{ $post->id }}"><i class="fa fa-trash fa-fw text-danger"></i></a>
                                            @else
                                                <a href="#" class="btn btn-light p-1 disabled"><i class="fa fa-trash fa-fw text-danger"></i></a>
                                            @endpermission
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                        {!! $posts->links() !!}
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
    </div>
@endsection
@section('js')
<script src="{{ asset('js/plugins/select2/js/select2.min.js') }}"></script>
<script>
     $('.form-select').select2({
        });
     $('.delete_post').on('click', function (){
         let idPost = $(this).data('comment');
         $('#modelDelete').attr('action', '/admin/posts/'+ idPost +'');
         $("#exampleModalLabel").text($(this).data('title'));
         $(".modal-body").text($(this).data('description'));
     });
</script>
@endsection
