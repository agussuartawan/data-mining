@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>

    </div>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="row mb-3">
                <div class="col-lg-6">
                    <a class="btn btn-sm btn-danger" href="{{ url()->previous() }}">
                        <i class="fas fa-chevron-left"></i>
                        Kembali
                    </a>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Detail Produk Bundel</h5>
                </div>
                <div class="card-body">
                    <div class="border p-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <h6>
                                    <strong>{{ $bundle->bundle_name }}</strong>
                                </h6>
                                <h6>Support <strong>{{ round($bundle->support* 100, 1) }}%</strong></h6>
                                <h6>Confidence <strong>{{ round($bundle->confidence* 100, 1) }}%</strong></h6>
                                <h6>Support & Confidence <strong>{{ round($bundle->support_x_confidence * 100, 1) }}%</strong></h6>
                                <h6>Tanggal <strong>{{ $bundle->date }}</strong></h6>
                                <h6>Diproses sejak <strong>{{ $bundle->created_at->diffForHumans() }}</strong></h6>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-bordered rs-table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Produk</th>
                                        <th width="20%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bundle->product as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>
                                                <p @if($product->pivot->keterangan == "Slow Moving") class="badge badge-danger" @else class="badge badge-success" @endif>
                                                    {{ $product->pivot->keterangan }}
                                                </p>
                                            </td>
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