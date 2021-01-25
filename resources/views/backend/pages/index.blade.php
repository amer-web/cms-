@extends('layouts.master')
@section('content')
    <div class="row row-sm">
        <!--div-->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">All Pages</h3>
                        @permission('create_page')
                        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary "><i
                                class="fa fa-plus fa-fw"></i> New Page</a>
                        @else
                        <a href=#" class="btn btn-primary disabled"><i class="fa fa-plus fa-fw"></i> New Page</a>
                        @endpermission
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0 text-lg-nowrap ">
                            <thead>
                                <tr class="text-center">
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>User Created</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pages as $page)

                                    <tr class="text-center">
                                        <td>{{ $page->title }}</td>
                                        <td>{{ $page->status }}</td>
                                        <td>{{ $page->user->username }}</td>
                                        <td>{{ $page->created_at->format('D,m-y h:i a') }}</td>
                                        <td>
                                            @permission('update_page')
                                            <a href="{{ route('admin.pages.edit', $page->slug) }}" class="btn btn-light text-primary p-1"><i
                                                    class="fa fa-edit fa-fw"></i></a>
                                            @else
                                            <a href="#" class="btn btn-light text-primary p-1 disabled"><i class="fa fa-edit fa-fw"></i></a>
                                            @endpermission

                                            @permission('delete_page')
                                                <a href="" class="btn btn-light p-1 delete_page" data-title="Delete Page" data-description="Do You Want Delete This Page ({{$page->title}}) ?" data-toggle="modal" data-target="#exampleModal" data-comment="{{ $page->id }}"><i class="fa fa-trash fa-fw text-danger"></i></a>
                                            @else
                                                <a href="#" class="btn btn-light p-1 disabled"><i class="fa fa-trash fa-fw text-danger"></i></a>
                                            @endpermission
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                        {!! $pages->links() !!}
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
    </div>
@endsection
@section('js')
    <script>
    $('.delete_page').on('click', function (){
    let idPage = $(this).data('comment');
    $('#modelDelete').attr('action', '/admin/pages/'+ idPage +'');
    $("#exampleModalLabel").text($(this).data('title'));
    $(".modal-body").text($(this).data('description'));
    });
    </script>
@endsection

