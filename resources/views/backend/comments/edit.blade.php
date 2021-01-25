@extends('layouts.master')
@section('css')
    <link href="{{ asset('js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="htc__blog__area bg__white ptb--120">
        <div class="container">
            <h2 class="text-center mt-3">Edit comment ({{ $commentEdit->name }})</h2>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.comments.update', $commentEdit->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="" class="text-muted mb-2 mt-4">Comment</label>
                            <textarea name="comment" id="" cols="30" rows="10"
                                class="form-control">{{ $commentEdit->comment }}</textarea>
                        </div>
                        <div class="col-8 col-lg-3">
                            <div class="form-group row">
                                <label class="col" for="status">Status</label>
                                <select id="status" name="status" class="form-control basic-single" required>
                                    <option value="1" {{ $commentEdit->status == 'Active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0" {{ $commentEdit->status == 'InActive' ? 'selected' : '' }}>InActive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Update">
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/plugins/select2/js/select2.min.js') }}"></script>

    <script>
        $(function() {
            $('.basic-single').select2({});
        });

    </script>
@endsection
