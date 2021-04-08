@extends('layouts.main')
@section('content')
  <div class="row mb-3">
    <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-header py-3">
            @if(Session::has('success'))
              <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                {{Session('success')}}
              </div>
            @endif
            <div class="row">
              <div class="col-lg-6">
                <div class="form-inline">
                    <label class="label">Jenis Produk :</label>&nbsp;
                    <select class="custom-select custom-select-sm form-control form-control-sm" id="jenis">
                      <option value="0" {{ $selected == 0 ? "selected" : "" }}>Semua</option>
                      @foreach($jenis as $j)
                        <option value="{{$j->id}}" {{ $selected == $j->id ? "selected" : "" }}>{{$j->nama}}</option>
                      @endforeach
                    </select>
                </div>
              </div>
              <div class="col-lg-6">
                <a href="{{route('product.create')}}" class="btn btn-sm btn-primary float-right">
                  <i class="fas fa-plus"></i>
                  Tambah Produk
                </a>
              </div>
            </div>
          </div>
          <div class="table-responsive p-3">
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
              <thead class="thead-light">
                <tr>
                  <th width="15%">Kode</th>
                  <th>Nama Produk</th>
                  <th width="15%">Stok</th>
                  <th width="20%">Jenis</th>
                  <th width="15%">###</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $product)
                  <tr>
                    <td><a href="">{{$product->kode}}</a></td>
                    <td><a href="">{{$product->nama}}</a></td>
                    <td>{{$product->stok}}</td>
                    <td><a href="">{{$product->jenis->nama}}</a></td></td>
                    <td>
                      <a href="#" class="badge badge-info">edit</a>
                      <a href="#" class="badge badge-danger">hapus</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </div>
@endsection

@push('scripts')
  <script>
    // Page level custom scripts
    $(document).ready(function () {

      $('#dataTableHover').DataTable(); // ID From dataTable with Hover

      $('#jenis').on('change', function(){
          var id = $('#jenis').val();
          window.location.href = '{{url("product")}}/'+id;
      });

    });
  </script>
@endpush