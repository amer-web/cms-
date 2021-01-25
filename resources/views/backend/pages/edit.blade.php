@extends('layouts.master')
@section('css')
    <link href="{{ asset('js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="htc__blog__area bg__white ptb--120">
        <div class="container">
            <h2 class="text-center mt-3">Edit Page ({{ $pageEdit->title }})</h2>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.pages.update', $pageEdit->id) }}" enctype="multipart/form-data"
                        id="create-post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Name Page</label>
                            <input type="text" name='title' class="form-control" id="title" value="{{ old('title', $pageEdit->title) }}">
                            @error('title')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name='description' id="description">{!! old('description', $pageEdit->description) !!}</textarea>
                            @error('description')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row" style="display: flex;justify-content: space-between">
                            <div class="col-8 col-lg-3">
                                <div class="form-group row">
                                    <label class="col" for="status">Status</label>
                                    <select id="status" name="status" class="form-control basic-single" required>
                                        <option value="1" {{ $pageEdit->status == 'Active' ? 'selected': '' }}>Active</option>
                                        <option value="0" {{ $pageEdit->status == 'InActive' ? 'selected': '' }}>InActive</option>
                                    </select>
                                </div>
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
    <script src="{{ asset('js/plugins/tinymce.min.js') }}"></script>
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
            $('.basic-single').select2({
            });
        });

    </script>
@endsection




