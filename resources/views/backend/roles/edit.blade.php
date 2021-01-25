@extends('layouts.master')

@section('content')
    <div class="htc__blog__area bg__white ptb--120">
        <div class="container">
            <h2 class="text-center mt-3">Edit Role({{ $role->name }})</h2>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Name</label>
                            @if ($role->name != 'admin' && $role->name != 'user')
                            <input type="text" name='name' class="form-control" id="name" value="{{ old('name', $role->name) }}">
                            @else
                            <input type="text" name='name' class="form-control" id="name" value="{{ old('name', $role->name) }}" disabled>
                            @endif
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Display Name</label>
                            <input type="text" name='display_name' class="form-control" id="display_name" value="{{ old('display_name', $role->display_name) }}">
                            @error('display_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Description</label>
                            <input type="text" name='description' class="form-control" id="description" value="{{ old('description', $role->description) }}">
                            @error('description')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @if ($role->name != 'admin' && $role->name != 'user')
                        @php
                            $models = ['post', 'comment', 'category', 'page','message', 'user', 'role'];
                            $actions = ['read', 'create', 'update', 'delete'];
                        @endphp
                        <div class="panel panel-primary tabs-style-2">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs main-nav-line row">
                                        @foreach ($models as $index => $model)
                                        <li class="col-md-3 col-lg-2 col-sm-3 col-4 px-0"><a href="#tab{{ $index }}" class="text-capitalize nav-link {{ $index == 0 ? 'active' : '' }}" data-toggle="tab">{{ $model }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    @foreach ($models as $index => $model)
                                    <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="tab{{ $index }}">
                                        @foreach ($actions as $action)
                                        <div class="form-group">
                                            <input type="checkbox" name="permission[]" id="{{ $action . '_' . $model }}" value="{{ $action . '_' . $model }}" {{ ($role->hasPermission($action . '_' . $model)) ? 'checked' : '' }}>
                                            <label for="{{ $action . '_' . $model }}">{{ $action }} {{ $model }}</label>
                                         </div>
                                        @endforeach
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                            @error('permission')
                            <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif

                        <input type="submit" class="btn btn-primary mt-2 mb-3" value="Save">
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection






