@extends('layouts.main')
@section('content')
  <div class="row mb-3">
    <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-header py-3">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-inline">
                    <label class="label">Jenis Produk :</label>&nbsp;
                    <select class="custom-select custom-select-sm form-control form-control-sm" id="jenis">
                      @foreach($jenis as $j)
                        <option value="{{$j->id}}" {{ $selected == $j->id ? "selected" : "" }}>{{$j->nama}}</option>
                      @endforeach
                    </select>
                </div>
              </div>
              <div class="col-lg-6">
                <button class="btn btn-sm btn-primary float-right">
                  <i class="fas fa-plus"></i>
                  Tambah Produk
                </button>
              </div>
            </div>
          </div>
          <div class="table-responsive p-3">
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
              <thead class="thead-light">
                <tr>
                  <th>Kode</th>
                  <th>Jenis</th>
                  <th>Nama Produk</th>
                  <th>Stok</th>
                  <th>###</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $product)
                  <tr>
                    <td>{{$product->kode}}</td>
                    <td>{{$product->jenis->nama}}</td>
                    <td>{{$product->nama}}</td>
                    <td>{{$product->stok}}</td>
                    <td></td>
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