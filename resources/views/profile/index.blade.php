@extends('layouts.main')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-2"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        
        @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    swal({
                        icon: "error",
                        title: "Oops...",
                        text: "{{ $error }}",
                    });
                });
            </script>
        @endforeach
    @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <form action="{{ route('profile.post') }}" method="POST" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        @method('PATCH')

                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="/imageUser/{{ $user->image }}" alt="profile" class="d-block rounded"
                                    id="uploadedAvatar" style="width: 10rem; height: 10rem; object-fit: cover" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-2" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input" hidden
                                            accept="image/png, image/jpeg" name="image" />
                                    </label>
                                    <p class="text-muted mb-0">Ukuran 3 x 4</p>
                                    <p class="text-muted mb-0">Allowed JPG or PNG.</p>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="mb-3 col-md-12">
                                <label for="firstName" class="form-label">Name
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="text" id="firstName" name="name"
                                    value="{{ $user->name }}" required />
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="nip" class="form-label">NIP / NRNPNSD
                                    <span class="star">*</span>
                                </label>
                                <input class="form-control" type="text" name="nip" id="nip"
                                    value="{{ $user->nip }}" required />
                            </div>

                            <div class="mb-3">
                                <label for="defaultSelect" class="form-label">Jabatan
                                    <span class="star">*</span>
                                </label>
                                <select id="defaultSelect" class="form-select" name="id_jabatan" disabled>
                                    @foreach ($jabatans as $jabatan)
                                        <option value="{{ $jabatan['id'] }}"
                                            {{ $jabatan['id'] == $user->id_jabatan ? 'selected' : '' }}>
                                            {{ $jabatan['detail'] }} {{ $jabatan['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="selectPangkat" class="form-label">Pangkat</label>
                                <select id="selectPangkat" class="form-select" name="id_pangkat" disabled>
                                    <option value="">Belum Memiliki Pangkat / Golongan</option>
                                    @foreach ($pangkats as $pangkat)
                                        <option value="{{ $pangkat['id'] }}"
                                            {{ $pangkat['id'] == $user->id_pangkat ? 'selected' : '' }}>
                                            {{ $pangkat['pangkat'] }} / {{ $pangkat['golongan'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="jabatan" class="form-label">Email</label>
                                <input class="form-control" type="text" name="email" id="jabatan"
                                    value="{{ $user->email }}" />
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="confirm-password" class="form-label">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="confirm-password" class="form-control"
                                        name="confirm-password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="confirm-password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="role" class="form-label">Role</label>
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <input type="text" class="form-control" id="basic-default-role"
                                            value="{{ $v }}" disabled />
                                    @endforeach
                                @endif
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
    </div>
@endsection
