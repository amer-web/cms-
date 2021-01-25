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
                        <h3 class="card-title mg-b-0">All Roles</h3>
                        @permission('create_role')
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary "><i
                                class="fa fa-plus fa-fw"></i> New Role</a>
                        @else
                        <a href="#" class="btn btn-primary disabled"><i
                            class="fa fa-plus fa-fw"></i> New Role</a>
                        @endpermission
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0 text-lg-nowrap ">
                            <thead>
                                <tr class="text-center">
                                    <th>Name</th>
                                    <th>Display Name</th>
                                    <th>Description</th>
                                    <th>Nu Users</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $role)
                                    <tr class="text-center">
                                        <td class="text-capitalize">{{ $role->name }}</td>
                                        <td class="text-capitalize">{{ $role->display_name }}</td>
                                        <td class="text-capitalize">{{ $role->description }}</td>
                                        <td class="text-capitalize">{{ $role->users_count }}</td>
                                        <td>
                                            @permission('update_role')
                                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-light p-1"><i
                                                    class="fa fa-edit fa-fw text-primary"></i></a>
                                            @else
                                            <a href="#" class="btn btn-light p-1 disabled"><i
                                                class="fa fa-edit fa-fw text-primary"></i></a>
                                            @endpermission
                                            @if ( $role->name != 'user' &&  $role->name != 'admin' )
                                            @permission('delete_role')
                                                <a href="" class="btn btn-light p-1 delete_role" data-title="Delete Role" data-description="Do You Want Delete This Role ({{$role->name}}) ?" data-toggle="modal" data-target="#exampleModal" data-comment="{{ $role->id }}"><i class="fa fa-trash fa-fw text-danger"></i></a>
                                            @else
                                                <a href="#" class="btn btn-light p-1 disabled"><i class="fa fa-trash fa-fw text-danger"></i></a>
                                            @endpermission
                                            @endif
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>

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
     $('.delete_role').on('click', function (){
         let idRole = $(this).data('comment');
         $('#modelDelete').attr('action', '/admin/roles/'+ idRole +'');
         $("#exampleModalLabel").text($(this).data('title'));
         $(".modal-body").text($(this).data('description'));
     });
</script>
@endsection
