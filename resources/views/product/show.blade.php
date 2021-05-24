@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Produk</h1>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <a href="{{ route('product.index', 0) }}" class="btn btn-danger mb-4" id="btn-cancle">
                <i class="fas fa-chevron-left"></i>
                Kembali
            </a>
        </div>
        <div class="col-lg-6">
            <form class="form-inline float-right" method="post" action="{{ route('product.destroy', $product->id) }}">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <a href="{{ $product->tipe == 'Single' ? route('product.edit', $product->id) : route('product.edit.bundle', $product->id) }}"
                    class="btn btn-info"> <i class="fas fa-edit"></i> Edit</a> &nbsp;
                <a href="#" class="btn btn-danger btn-delete" title="{{ $product->nama }}"> <i class="fas fa-trash"></i>
                    Hapus</a>
            </form>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="m-0 font-weight-bold text-info"><i class="fas fa-info-circle"></i> &nbsp; {{ $title }}</h5>
        </div>
        <div class="card-body">
            <div class="shadow-sm bg-light rounded">
                <div class="card-header bg-info text-white">
                    {{ $product->kode }} | {{ $product->nama }}
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2"><span>Group</span></div>
                            <div class="col-10">:&nbsp;&nbsp;{{ $product->group->nama }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2"><span>Tipe</span></div>
                            <div class="col-10">:&nbsp;&nbsp;{{ $product->tipe }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2"><span>Stok</span></div>
                            <div class="col-10">:&nbsp;&nbsp;{{ $product->stok }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2"><span>Harga Jual</span></div>
                            <div class="col-10">:&nbsp;&nbsp;{{ currency($product->harga_jual) }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2"><span>Harga Beli</span></div>
                            <div class="col-10">:&nbsp;&nbsp;{{ currency($product->harga_beli) }}</div>
                        </div>
                    </li>
                </ul>
            </div>

            @if ($product->tipe == 'Bundle')
                <table class="table table-bordered mt-2">
                    <thead class="bg-info text-white">
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->product_bundle as $bundle)
                            <tr>
                                <td>{{ $bundle->product_nama($bundle->product) }}</td>
                                <td>{{ $bundle->qty }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('body').on('click', '.btn-delete', function(event) {
                event.preventDefault();
                var title = $(this).attr('title');
                var choice = confirm('Yakin menghapus produk ' + title + '?');
                if (choice) {
                    $(this).closest('form').submit();
                }
            });
        });

    </script>
@endpush
