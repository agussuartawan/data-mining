@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Input Kriteria</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('bundle.create') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group input-group-sm">
                                    <label>Masukan nilai support</label>
                                    <input type="text" name="support" class="form-control" required="required">
                                </div>
                                <div class="form-group input-group-sm">
                                    <label>Masukan nilai confidence</label>
                                    <input type="text" name="confidence" class="form-control" required="required">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="label">Pilih data transaksi</label>
                                <div class="input-group input-group-sm mb-3">
                                  <input type="text" class="form-control" placeholder="Cari data transaksi">
                                  <div class="input-group-append">
                                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">
                            Proses
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Hasil</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-striped table-hover" id="dataTableHover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama Bundel</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="15%">Aksi</th></th>
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

@endsection

@push('scripts')
    <script>
       $('#dataTableHover').DataTable({
            searching: false,
            paging: false, 
            info: false
        });
    </script>
@endpush
