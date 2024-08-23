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
                        <h5 class="mb-0">Detail Role</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Name</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                value="{{ $role->name }}" disabled />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Permission</label>
                            @if (!empty($rolePermissions))
                                <form>
                                    @foreach ($rolePermissions as $permission)
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox"
                                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} readonly>
                                            <label class="form-check-label">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                </form>
                            @else
                                <p>No permissions found for this role.</p>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between">
                            <a type="button" class="btn btn-primary px-4" href="{{ route('role.index') }}">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var checkboxes = document.querySelectorAll('.form-check-input');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('click', function(event) {
                    event.preventDefault();
                });
            });
        });
    </script>
@endsection
