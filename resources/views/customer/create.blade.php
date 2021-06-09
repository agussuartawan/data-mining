@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <a href="{{ route('customer.index') }}" class="btn btn-danger mb-4" id="btn-cancle">
        <i class="fas fa-chevron-left"></i>
        Kembali
    </a>
    <div class="card mb-4">
        <div class="card-header">
            @if (Session::has('success'))
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ Session('success') }}
                </div>
            @endif
            <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-square"></i> &nbsp; Pelanggan Baru</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('customer.store') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">*Nama Pelanggan</label>
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="jenis" class="font-weight-bold">Alamat</label>
                            <textarea class="form-control" name="address" id="address" cols="30"
                                rows="5">{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">E-mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="phone" class="font-weight-bold">Telp</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <input type="hidden" name="redirect_to" id="redirect_to">
                <button type="submit" class="btn btn-outline-primary" id="btn-simpan">Simpan</button>
            </form>
        </div>
    </div>
@endsection
