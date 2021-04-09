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
                <input type="text" class="form-control" id="kode" placeholder="Contoh AB001 untuk Absolut Blue" name="kode">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                <label for="nama-jual" class="font-weight-bold">Harga Jual</label>
                <input type="number" class="form-control" id="harga-jual" name="harga_jual">
                </div>
            </div>
        </div>
        <div class="form-group">
          <label for="nama" class="font-weight-bold">*Nama Produk Bundle</label>
          <input type="text" class="form-control" id="nama" name="nama">
        </div>

        <table class="table table-responsive">
            <thead>
                <tr>
                    <th width="50%">Produk</th>
                    <th width="20%">Qty</th>
                    <th width="20%">Harga</th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>
                        <button class="btn btn-sm btn-primary"><i class="fas fa-plus"></i>Tambah Data</button>
                    </th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>
                        <div class="form-group">
                            <select class="select2-single-placeholder form-control" name="product_id" id="select2SinglePlaceholder">
                                @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control" name="qty">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="qty">
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
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

            $('.select2-single-placeholder').select2({
                placeholder: "Pilih Produk",
                allowClear: true
            }); 
		});
	</script>
    <livewire:scripts />
@endpush

@push('styles')
    <style>
        .select2-selection__rendered {
            line-height: 32px !important;
        }

        .select2-selection {
            height: 39px !important;
        }
    </style>
    <livewire:styles />
@endpush