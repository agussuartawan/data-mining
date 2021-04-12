@extends('layouts.main')
@section('content')

<div class="card mb-4">
  <div class="row">
    <div class="col-lg-6">
      <div class="card-body">
        <div class="shadow-sm bg-light table-responsive rounded">
          <div class="card-header bg-info text-white">
            {{$product->kode}} | {{$product->nama}}
          </div>
          <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <div class="row">
                  <div class="col-2"><span>Jenis</span></div>
                  <div class="col-10">:&nbsp;&nbsp;{{$product->jenis->nama}}</div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-2"><span>Stok</span></div>
                  <div class="col-10">:&nbsp;&nbsp;{{$product->stok}}</div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-2"><span>Harga Jual</span></div>
                  <div class="col-10">:&nbsp;&nbsp;{{$product->harga_jual}}</div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-2"><span>Harga Beli</span></div>
                  <div class="col-10">:&nbsp;&nbsp;{{$product->harga_beli}}</div>
                </div>
              </li>
          </ul>
        </div>
        <div class="card-body">
          <a href="{{route('product.index', 0)}}" class="card-link">Kembali</a>
          <a href="{{route('product.edit', $product->id)}}" class="card-link">Edit</a>
        </div>
      </div>
    </div>
  </div>
</div>
  
@endsection