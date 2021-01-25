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
                        <h3 class="card-title mg-b-0">All Categories</h3>
                        @permission('create_category')
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary "><i
                                class="fa fa-plus fa-fw"></i> New Category</a>
                        @else
                        <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus fa-fw"></i> New Category</a>
                        @endpermission
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0 text-lg-nowrap">
                            <thead>
                                <tr class="text-center">
                                    <th>Name</th>
                                    <th>Posts Count</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)

                                    <tr class="text-center">
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->posts->count() }}</td>
                                        <td>{{ ($category->status == 1)? 'Active' : 'InActive'}}</td>
                                        <td>{{ $category->created_at->format('D-m-y, h:i a') }}</td>
                                        <td>
                                            @permission('update_category')
                                            <a href="{{ route('admin.categories.edit', $category->slug) }}" class="btn btn-light text-primary p-1"><i
                                                    class="fa fa-edit fa-fw"></i></a>
                                            @else
                                                <a href="#" class="btn btn-light p-1 text-primary disabled"><i class="fa fa-edit fa-fw"></i></a>
                                            @endpermission
                                            @permission('delete_category')
                                                <a href="" class="btn btn-light p-1 delete_category" data-title="Delete Category" data-description="Do You Want Delete This Category ({{$category->name}}) ?" data-toggle="modal" data-target="#exampleModal" data-comment="{{ $category->id }}"><i class="fa fa-trash fa-fw text-danger"></i></a>
                                            @else
                                            <a href="#" onclick="event.preventDefault();document.getElementById('form-delete_{{ $category->id }}').submit()" class="btn btn-light p-1 disabled">
                                                <i class="fa fa-trash fa-fw text-danger "></i></a>
                                            @endpermission
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                        {!! $categories->links() !!}
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
     $('.delete_category').on('click', function (){
         let idCategory = $(this).data('comment');
         $('#modelDelete').attr('action', '/admin/categories/'+ idCategory +'');
         $("#exampleModalLabel").text($(this).data('title'));
         $(".modal-body").text($(this).data('description'));
     });
</script>
@endsection
