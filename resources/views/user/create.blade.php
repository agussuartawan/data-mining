@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12 notif">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Tambah User</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.store') }}" id="form">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">E-mail</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Ulangi Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>
                        <a class="btn btn-danger" href="{{ route('user.index') }}">
                            <i class="fas fa-times"></i>
                            Batal
                        </a>
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-plus"></i>
                            Simpan
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
    </script>
@endpush
