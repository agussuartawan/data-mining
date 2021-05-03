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
          <div class="col-lg-6">
            <div class="form-group">
              <label for="kode" class="font-weight-bold">*Kode Produk</label>
              <input type="text" class="form-control @error('kode') is-invalid @enderror" 
              id="kode" placeholder="Contoh AB001 untuk Absolut Blue" name="kode" value="{{old('kode')}}">
              @error('kode')
              <div class="invalid-feedback">
                {{$message}}
              </div>
              @enderror
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="nama" class="font-weight-bold">*Nama Produk</label>
              <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{old('nama')}}">
              @error('nama')
              <div class="invalid-feedback">
                {{$message}}
              </div>
              @enderror
            </div>
          </div>
        </div>        
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="jenis" class="font-weight-bold">Group Produk</label>
                <select class="form-control custom-select mb-3" id="jenis" name="group_id">
                  @foreach($group as $j)
                  <option value="{{$j->id}}">{{$j->nama}}</option>
                  @endforeach
                </select>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="tipe" class="font-weight-bold">Tipe Produk</label>
              <select class="form-control custom-select mb-3" id="tipe" name="tipe">
                  <option value="Single">Single</option>
                </select>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="harga-beli" class="font-weight-bold">Harga Beli</label>
              <input type="number" class="form-control" id="harga-beli" name="harga_beli">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="nama-jual" class="font-weight-bold">Harga Jual</label>
              <input type="number" class="form-control" id="harga-jual" name="harga_jual">
            </div>
          </div>
        </div>
        
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
		$(document).ready(function() {
			$('#btn-simpan').click(function(event) {
				event.preventDefault();
				$('#redirect_to').val('index');
				$('form').submit();
			});

			$('#btn-simpan-baru').click(function(event) {
				event.preventDefault();
				$('#redirect_to').val('create');
				$('form').submit();
			});
		});
	</script>
@endpush