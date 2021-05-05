@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-edit"></i> &nbsp; Edit Produk</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('product.update', $product->id) }}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="kode" class="font-weight-bold">*Kode Produk</label>
                    <input type="text" class="form-control" id="kode" name="kode" value="{{ $product->kode }}">
                </div>
                <div class="form-group">
                    <label for="nama" class="font-weight-bold">*Nama Produk</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $product->nama }}">
                </div>
                <div class="form-group">
                    <label for="jenis" class="font-weight-bold">Jenis Produk</label>
                    <select class="form-control custom-select mb-3" id="jenis" name="jenis_id" name="jenis_id">
                        @foreach ($jenis as $j)
                            <option value="{{ $j->id }}" {{ $product->jenis_id == $j->id ? 'selected' : '' }}>
                                {{ $j->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipe" class="font-weight-bold">Tipe Produk</label>
                    <select class="form-control custom-select mb-3" id="tipe" name="tipe">
                        <option value="Single">Single</option>
                        <option value="Bundle">Bundle</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga-beli" class="font-weight-bold">Harga Beli</label>
                    <input type="number" class="form-control" id="harga-beli" name="harga_beli"
                        value="{{ $product->harga_beli }}">
                </div>
                <div class="form-group">
                    <label for="nama-jual" class="font-weight-bold">Harga Jual</label>
                    <input type="number" class="form-control" id="harga-jual" name="harga_jual"
                        value="{{ $product->harga_jual }}">
                </div>
                <a href="{{ route('product.index', 0) }}" class="btn btn-outline-danger">Batal</a>
                <button type="submit" class="btn btn-outline-warning" id="btn-simpan">Edit</button>
            </form>
        </div>
    </div>
@endsection
