@extends('layouts.master')
@section('css')
    <link href="{{ asset('js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="htc__blog__area bg__white ptb--120">
        <div class="container">
            <h2 class="text-center mt-3">Create Category</h2>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data"
                        id="create-post">
                        @csrf

                        <div class="form-group mb-5">
                            <label for="name">Name</label>
                            <input type="text" name='name' class="form-control" id="name" value="{{ old('name') }}">
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row" style="display: flex;justify-content: space-between">
                            <div class="col-8 col-lg-3">
                                <div class="form-group row">
                                    <label class="col" for="status">Status</label>
                                    <select id="status" name="status" class="form-control basic-single" required>
                                        <option value="1">Active</option>
                                        <option value="0">InActive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary mt-4" value="Save">

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




