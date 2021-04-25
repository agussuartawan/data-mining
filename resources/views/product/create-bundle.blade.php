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
            <div class="shadow-sm mb-4 bg-light table-responsive rounded">
                <div class="card-header bg-primary text-white">
                    Pilih Produk
                    <div class="spinner-border float-right" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                <div class="card-body">
                    <form>
                        <div class="row">
                                <div class="col-lg-4">
                                    <select class="form-control" name="product_id" id="select-product">
                                        @foreach($allProducts as $product)
                                            <option value="{{$product->id}}">{{$product->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <input type="number" class="form-control" name="qty" placeholder="Qty">
                                </div>
                                <div class="col-lg-3">
                                    <input type="number" class="form-control" name="price" placeholder="Harga">
                                </div>
                                <div class="col-lg-2">
                                    <button class="btn btn-primary btn-tambah mt-1">
                                        Tambah
                                    </button>
                                </div>
                        </div>
                    </form>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered" id="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th style="width: 40%;">Nama</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
    <script type="text/javascript">
        $(document).ready(function(){
            $('#select-product').select2({
                placeholder: "Pilih Produk",
                allowClear: true,
                theme: "classic"
            });
        });
    </script>
@endpush

@push('styles')
    <style type="text/css">
        .select2-selection__rendered {
            line-height: 41px !important;
        }

        .select2-selection {
            height: 41px !important;
        }

        .select2-selection__arrow {
            height: 40px !important;
        }
    </style>
@endpush