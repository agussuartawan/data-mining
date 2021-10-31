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
                <div class="col-lg-6">
                    <a class="btn btn-sm btn-danger" href="{{ route('transaction.data', 'latest') }}">
                        <i class="fas fa-chevron-left"></i>
                        Kembali
                    </a>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Detail Penjualan</h5>
                </div>
                <div class="card-body">
                    <div class="border border-secondary p-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <h6>Transaksi {{ $transaction->no_invoice }}</h6>
                                <h6>Tanggal {{ $transaction->date }}</h6>
                                <h6>Ditambahkan sejak {{ $transaction->created_at->diffForHumans() }}</h6>
                            </div>
                            <div class="col-lg-6 text-right">
                                <h3 class="font-weight-bold">Rp. {{ currency($transaction->grand_total) }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-bordered rs-table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaction->product as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->pivot->qty }}</td>
                                            <td>{{ currency($product->pivot->price) }}</td>
                                            <td>{{ currency($product->pivot->subtotal) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
       
    </script>
@endpush

@push('styles')
    <style type="text/css">
        table.rs-table-bordered{
            border:1px solid #000000;
            margin-top:20px;
        }
        table.rs-table-bordered > thead > tr > th{
               border:1px solid #000000;
        }
        table.rs-table-bordered > tbody > tr > td{
            border:1px solid #000000;
        }
    </style>
@endpush
