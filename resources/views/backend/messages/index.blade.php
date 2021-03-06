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
                        <h3 class="card-title mg-b-0">All Messages</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <form action="{{ route('admin.messages.index') }}" method="GET">
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
                                            <option value="1" {{ isset(request()->status) && request()->status == 1 ? 'selected':'' }}>Read</option>
                                            <option value="0" {{ isset(request()->status) && request()->status == 0 ? 'selected':'' }}>New</option>
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
                                    <th>From</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($messages as $message)

                                    <tr class="text-center">
                                        <td class="text-capitalize">{{ $message->name }}</td>
                                        <td>{{ $message->title }}</td>
                                        <td>{{ $message->status }}</td>
                                        <td>{{ $message->created_at->format('D,m-y h:i a') }}</td>
                                        <td>
                                            <a href="{{ route('admin.messages.show', $message->id) }}" class=""><i
                                                    class="fa fa-eye fa-fw"></i></a>
                                            @permission('delete_message')
                                            <a href="" class="btn btn-light p-1 delete_message" data-title="Delete Message" data-description="Do You Want Delete This Message ({{$message->title}}) ?" data-toggle="modal" data-target="#exampleModal" data-comment="{{ $message->id }}"><i class="fa fa-trash fa-fw text-danger"></i></a>
                                            @else
                                            <a href="#" class="btn btn-light p-1 disabled">
                                                <i class="fa fa-trash fa-fw text-danger"></i></a>
                                            @endpermission
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                        {!! $messages->links() !!}
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
     $('.delete_message').on('click', function (){
         let idMessage = $(this).data('comment');
         $('#modelDelete').attr('action', '/admin/messages/'+ idMessage +'');
         $("#exampleModalLabel").text($(this).data('title'));
         $(".modal-body").text($(this).data('description'));
     });
</script>
@endsection
