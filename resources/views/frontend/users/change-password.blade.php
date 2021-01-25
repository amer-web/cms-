@extends('layouts.app')
@section('title', 'Change Password')
@section('content')

    <!-- Start BLog Area -->
    <div class="htc__blog__area bg__white ptb--120">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="main-content-label mg-b-5 font-weight-bold">
                                    Change Password
                                </div>
                                <form action="{{ route('updatePassword') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="bg-gray-200 p-4">
                                                <div class="form-group">
                                                    <input class="form-control" type="password" name="old_password" placeholder="Enter your Current Password" type="text">
                                                    @error('old_password')
                                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" type="password" name="new_password" placeholder="Enter your New password" type="password">
                                                    @error('new_password')
                                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" type="password" name="new_password_confirmation" placeholder="Enter your New Confirm password" type="password">
                                                </div>
                                                <input class="btn btn-primary" type="submit" value="Update Password">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    @include('partial.frontend.userdashboard.sidebar')
                </div>
            </div>
        </div>
    </div>
    <!-- End BLog Area -->
@endsection
