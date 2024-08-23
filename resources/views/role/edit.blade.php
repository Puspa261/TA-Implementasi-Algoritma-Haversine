@extends('layouts.main')
@section('content')
    <div class="container-xxl  container-p-y">
        <div class="d-flex align-items-center py-2">
            <a href="{{ route('role.index') }}" class="btn btn-icon back">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mx-2 mt-3">Role</h4>
        </div>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Role</h5>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mx-4 mb-0">
                            <strong>Whoops!</strong> There were some problems with your
                            input.<br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">
                        <form action="{{ route('role.update', $role->id) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Nama
                                    <span class="star">*</span>
                                </label>
                                <input type="text" class="form-control" id="basic-default-fullname" name="name" value="{{ $role->name }}" required/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-detail">Hak Akses
                                    <span class="star">*</span>
                                </label>
                                <div class="col-sm-12 col-md-7">
                                    @foreach ($permission as $value)
                                        <div class="form-check mt-1">
                                            {{-- <label class="mt-1">{{ Form::checkbox('permission[]', $value->name, false, ['class' => 'name']) }}
                                                {{ $value->name }}</label> --}}
                                                <input class="form-check-input" type="checkbox" name="permission[]"
                                                value="{{ $value->name }}" id="permission{{ $value->name }}"
                                                {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission{{ $value->name }}">
                                                {{ $value->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a type="button" class="btn btn-primary px-4" href="{{ route('role.index') }}">Back</a>
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
