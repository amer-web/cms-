@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/fileinput/css/fileinput.min.css') }}">
    <link href="{{ asset('js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="htc__blog__area bg__white ptb--120">
        <div class="container">
            <h2 class="text-center mt-3">Create Post</h2>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data"
                        id="create-post">
                        @csrf

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name='title' class="form-control" id="title" value="{{ old('title') }}">
                            @error('title')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Summary</label>
                            <input type="text" name='summary' class="form-control" id="summary" value="{{ old('summary') }}">
                            @error('summary')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name='description' id="description">{{ old('description') }}</textarea>
                            @error('description')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row" style="display: flex;justify-content: space-between">
                            <div class="col-8 col-lg-3">
                                <div class="form-group row">
                                    <label class="col" for="category">Category</label>
                                    <select id="category" name="category_id" class="form-control basic-single" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-8 col-lg-3">
                                <div class="form-group row">
                                    <label class="col" for="comment_allow">Comment Allow</label>
                                    <select id="comment_allow" name="comment_able" class="form-control basic-single" required>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
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
                        <div class="form-group">
                            <label for="post_media">Images Post</label>

                            <div class="file-loading">
                                <input id="post_media" name="post_media[]" type="file" multiple>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary mb-4" value="Save">

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/plugins/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/plugins/fileinput/js/plugins/piexif.min.js') }}"></script>
    <script src="{{ asset('js/plugins/fileinput/js/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('js/plugins/fileinput/js/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('js/plugins/fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('js/plugins/fileinput/js/locales/LANG.js') }}"></script>
    <script src="{{ asset('js/plugins/fileinput/themes/fa/theme.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.min.js') }}"></script>
    <script>tinymce.init({
        selector:'textarea',
        height: 270,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste imagetools wordcount'
        ],
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        automatic_uploads: true,
        file_picker_types: 'image',
        file_picker_callback: function (cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.onchange = function () {
      var file = this.files[0];
      var reader = new FileReader();
      reader.onload = function () {
        var id = 'blobid' + (new Date()).getTime();
        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
        var base64 = reader.result.split(',')[1];
        var blobInfo = blobCache.create(id, file, base64);
        blobCache.add(blobInfo);
        cb(blobInfo.blobUri(), { title: file.name });
      };
      reader.readAsDataURL(file);
    };

    input.click();
  },


        });</script>

    <script>
        $(function() {
            $("#post_media").fileinput({
                theme: 'fa',
                maxFileCount: 5,
                allowedFileTypes: ['image']
            });
            $('.basic-single').select2({
            });
        });

    </script>
@endsection




