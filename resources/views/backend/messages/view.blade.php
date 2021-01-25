@extends('layouts.master')
@section('content')
    <div class="row row-sm">
        <!--div-->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">Message ( {{ $message->title }} )</h3>
                        <a href="{{ route('admin.messages.index') }}" class="btn btn-primary ">Back</a>
                    </div>
                </div>
                <div class="form-group row align-items-center pl-4 mt-4">
                    <label  class="col-sm-2 col-form-label">From : </label>
                    <div class="col-sm-10">
                        <h5 class="my-0">{{ $message->name }}</h5>
                    </div>
                </div>
                <div class="form-group row align-items-center pl-4">
                    <label  class="col-sm-2 col-form-label">Email : </label>
                    <div class="col-sm-10">
                        <h6 class="my-0">{{ $message->email }}</h6>
                    </div>
                </div>
                <div class="form-group row align-items-center pl-4">
                    <label  class="col-sm-2 col-form-label">Title : </label>
                    <div class="col-sm-10">
                        <h6 class="my-0">{{ $message->title }}</h6>
                    </div>
                </div>
                <div class="form-group row align-items-center pl-4">
                    <label  class="col-sm-2 col-form-label">Message : </label>
                    <div class="col-sm-10">
                        <p class="my-0">{{ $message->message }}</p>
                    </div>
                </div>
                <div class="form-group row align-items-center pl-4">
                    <label  class="col-sm-2 col-form-label">Created At : </label>
                    <div class="col-sm-10">
                        <p class="my-0">{{ $message->created_at->format('d-m-y, h:i a') }}</p>
                    </div>
                </div>
            </div><!-- bd -->
        </div>
    </div>
@endsection
