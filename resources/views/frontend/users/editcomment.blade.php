@extends('layouts.app')
@section('title', 'Edit Comment')
@section('style')
    <link href="{{ asset('js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="htc__blog__area bg__white ptb--120">
        <div class="container">
            <h2 style="margin-bottom: 30px">Edit Comment ({{ $comment->name }})</h2>
            <div class="row">
                <div class="col-md-9">
                    <form method="POST" action="{{ route('comments.update', $comment->id) }}" id="create-post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="description">Comment</label>
                            <textarea class="form-control" name='comment' style="height: 120px; resize: none">{!!  old('comment', $comment->comment) !!}</textarea>
                            @error('comment')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row" style="display: flex;">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control basic-single" required>
                                        <option value="1" {{ 1 == $comment->status ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ 0 == $comment->status ? 'selected' : '' }}>InActive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Save">

                    </form>
                </div>
                <div class="col-md-3">
                    @include('partial.frontend.userdashboard.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/plugins/select2/js/select2.min.js') }}"></script>

    <script>
        $(function() {
            $('.basic-single').select2({});
        });

    </script>
@endsection
