@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    @if (Session::has('success'))
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ Session('success') }}
        </div>
    @endif
    <div class="row mb-3">
        <div class="col-lg-7 notif">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Profil User</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        @if (auth()->user()->avatar)
                            <img src="{{ asset('') }}/avatar/{{ auth()->user()->avatar }}"
                                class="img-thumbnail rounded-circle" style="max-width: 20%" id="avatar">
                        @else
                            <img src="https://ui-avatars.com/api/?background=ff1493&color=fff&size=128&rounded=true&name={{ auth()->user()->name }}"
                                class="rounded-circle" style="max-width: 20%" id="avatar">
                        @endif
                        <br>
                        <form action="{{ route('delete.avatar') }}" method="post" id="form-delete-avatar">
                            @csrf
                            @method('PUT')
                            <a href="#" class="text-danger"
                                onclick="document.getElementById('form-delete-avatar').submit(); return false;">Hapus
                                foto</a>
                        </form>
                    </div>
                    <form action="{{ route('user.profile.update', auth()->user()->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row mt-3">
                            <label for="avatar" class="col-sm-2 col-form-label">Foto</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                                    name="avatar" onchange="loadFile(event)">
                                @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="name" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ auth()->user()->name }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">E-mail</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ auth()->user()->email }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item">Diverifikasi pada
                                {{ Carbon\Carbon::parse(auth()->user()->email_verified_at)->diffForhumans() ?? '-' }}
                            </li>
                            <li class="list-group-item">Bergabung sejak
                                {{ Carbon\Carbon::parse(auth()->user()->created_at)->diffForhumans() }}</li>
                            <li class="list-group-item">Terakhir diperbarui pada
                                {{ Carbon\Carbon::parse(auth()->user()->updated_at)->diffForhumans() }}</li>
                        </ul>
                        <button class="btn btn-block btn-success mt-3" type="submit">
                            <i class="fas fa-save"></i>
                            Perbarui Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Ganti Password</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('update.password') }}" id="form">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="old-password">Password Lama</label>
                            <input id="old-password" type="password"
                                class="form-control @error('current_password') is-invalid @enderror" name="current_password"
                                required>

                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Ulangi Password Baru</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required>
                        </div>
                        <button class="btn btn-block btn-warning" type="submit">
                            <i class="fas fa-save"></i>
                            Perbarui Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $('#form').on('submit', function(e) {
            $('#cover-spin').show(0);
        });

        var loadFile = function(event) {
            var output = document.getElementById('avatar');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
@endpush
