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
                        <h3 class="card-title mg-b-0">All Comments</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <form action="{{ route('admin.comments.index') }}" method="GET">
                            <div class="row">
                                <div class="col-6 col-sm">
                                    <div class="form-group ">
                                        <input type="text" placeholder="Search Here" name="keywords" value="{{ old('keywords', request()->keywords) }}" class="form-control">
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
                                    <th>Image</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($comments as $comment)
                                    <tr class="text-center">
                                        @if ($comment->user != null && $comment->user->user_image != null)
                                        <td><img src="{{ asset($comment->user->user_image) }}" alt="" style="width: 60px"></td>
                                        @else
                                        <td><img src="{{ asset('assest/users/login-icon.png') }}" alt="" style="width: 60px"></td>
                                        @endif
                                        <td>{{ $comment->name }}</td>
                                        <td>{{ Str::limit($comment->comment, 30, '...')  }}</td>
                                        <td>{{ $comment->status ? 'Active' : 'InActive' }}</td>
                                        <td>{{ $comment->created_at->format('d,M-y h:i a') }}</td>
                                        <td>
                                            @permission('update_comment')
                                            <a href="{{ route('admin.comments.edit', $comment->id) }}" class="btn btn-light text-primary p-1"><i
                                                    class="fa fa-edit fa-fw"></i></a>
                                            @else
                                            <a href="#" class="btn btn-light p-1 disabled"><i class="fa fa-edit fa-fw"></i></a>
                                            @endpermission

                                            @permission('delete_comment')
                                                    <a href="" class="btn btn-light p-1 delete_comment" data-title="Delete Comment" data-description="Do You Want Delete This Comment ({{$comment->name}}) ?" data-toggle="modal" data-target="#exampleModal" data-comment="{{ $comment->id }}"><i class="fa fa-trash fa-fw text-danger"></i></a>
                                                @else
                                                    <a href="#" class="btn btn-light p-1 disabled"><i class="fa fa-trash fa-fw text-danger "></i></a>
                                                @endpermission
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="6" class="text-center"><h5 class="text-muted">No Found comments</h5></td>
                                    @endforelse
                                </tbody>
                            </table>
                            {!! $comments->links() !!}
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
        $('.delete_comment').on('click', function (){
           let idComment = $(this).data('comment');
            $('#modelDelete').attr('action', '/admin/comments/'+ idComment +'');
            $("#exampleModalLabel").text($(this).data('title'));
            $(".modal-body").text($(this).data('description'));
        });
    </script>
    @endsection
