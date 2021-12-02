@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12">
            @if (Session::has('success'))
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ Session('success') }}
                </div>
            @endif
            <div class="row mb-3">
                <div class="col-lg-12">
                    <a class="btn btn-sm btn-primary" href="{{ route('transaction.create') }}">
                        <i class="fas fa-cloud-download-alt"></i>
                        Import
                    </a>
                    <a href="{{ route('transaction.filelist') }}">Lihat data file yang telah di-import</a>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Data Penjualan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-striped table-bordered rs-table-bordered" id="dataTableHover">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th>No Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $index => $transaction)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $transaction->no_invoice }}</td>
                                        <td>{{ Carbon\Carbon::parse($transaction->date)->isoFormat('DD MMMM Y') }}</td>
                                        <td>Rp. {{ currency($transaction->grand_total) }}</td>
                                        <td><a href="{{ route('transaction.show', $transaction->id) }}"
                                                class="badge badge-info">detail</a></td>
                                    </tr>
                                @endforeach
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
            pageLength: 5,
            lengthMenu: [5, 10, 25, 100]
        });
    </script>
@endpush
