@extends('layouts.main')
@section('content')
  <div class="card mb-4">
    <div class="card-body">
    	@if(Session::has('success'))
	      <div class="alert alert-info alert-dismissible" role="alert">
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	        {{Session('success')}}
	      </div>
	    @endif
      <form method="post" action="{{route('product.store')}}">
      	@csrf

        <div class="row">
          <div class="col-lg-4">
            <div class="shadow-sm mb-4 bg-light table-responsive rounded">
              <div class="card-header bg-primary text-white">
                  Identitas Produk
              </div>
      
              <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="kode" class="font-weight-bold">*Kode Produk</label>
                            <input type="text" class="form-control" id="kode" placeholder="Contoh AB001 untuk Absolut Blue" name="kode">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                          <label for="nama" class="font-weight-bold">*Nama Produk Bundle</label>
                          <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                        <label for="nama-jual" class="font-weight-bold">Harga Jual</label>
                        <input type="number" class="form-control" id="harga-jual" name="harga_jual">
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-8">
            @livewire('products')
          </div> 

        </div>
        <hr>
        <input type="hidden" name="redirect_to" id="redirect_to">
        <a href="{{route('product.index',0)}}" class="btn btn-outline-danger">Batal</a>
        <button type="submit" class="btn btn-outline-primary" id="btn-simpan">Simpan</button>
        <button type="submit" class="btn btn-outline-primary" id="btn-simpan-baru">Simpan & Baru</button>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
    @livewireScripts
@endpush

@push('styles')
    @livewireStyles
@endpush