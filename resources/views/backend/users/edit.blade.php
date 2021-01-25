@extends('layouts.master')
@section('css')
    <link href="{{ asset('js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="htc__blog__area bg__white ptb--120">
        <div class="container">
            <h2 class="text-center mt-3">Edit User ({{ $userEdit->username }})</h2>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.users.update', $userEdit->id) }}" id="create-post">
                        @csrf
                        @method('PUT')
                            <div class="col-8 col-lg-3">
                                <div class="form-group row">
                                    <label class="col" for="status">Status</label>
                                    <select id="status" name="status" class="form-control basic-single" required>
                                        <option value="1" {{ $userEdit->status == 'Active' ? 'selected': '' }}>Active</option>
                                        <option value="0" {{ $userEdit->status == 'InActive' ? 'selected': '' }}>InActive</option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label class="col" for="role">Role</label>
                                    <select id="status" name="role[]" class="form-control basic-single" required>
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}" {{($userEdit->hasRole($role->name))? 'selected' : ''}}>{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <input type="submit" class="btn btn-primary" value="Update">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/plugins/select2/js/select2.min.js') }}"></script>

    <script>
        $(function() {
            $('.basic-single').select2({
            });
        });

    </script>
@endsection




