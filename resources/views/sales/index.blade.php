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
                {{-- <div class="col-lg-6">
                    <div class="form-inline">
                        <label class="label">Bulan </label>&nbsp;
                        <select class="custom-select custom-select-sm form-control form-control-sm" id="jenis">
                            <option value="0">Semua</option>
                            @for ($i = 0; $i < count($month); $i++)
                                <option value="{{ $i+1 }}" >
                                    {{ $month[$i] }}</option>
                            @endfor
                        </select>
                    </div>
                </div> --}}
                <div class="col-lg-12">
                    <a class="btn btn-warning btn-filter" href="#" data-toggle="modal" data-target="#modal-filter">
                        <i class="fas fa-filter"></i>
                        Filter
                    </a>
                    <a class="btn btn-primary" href="{{ route('sales.create') }}">
                        <i class="fas fa-plus"></i>
                        Tambah
                    </a>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-glass-martini-alt"></i> &nbsp; Data
                        Penjualan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-striped table-hover" id="dataTableHover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="1%">#</th>
                                    <th width="15%">No Transaksi</th>
                                    <th>Nama Pelanggan</th>
                                    <th width="20%">Tanggal</th>
                                    <th width="10%">Total</th>
                                    <th width="15%">###</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $index => $sale)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a class="card-link"
                                                href="{{ route('sales.show', $sale->id) }}">{{ $sale->no_invoice }}</a>
                                        </td>
                                        <td><a class="card-link"
                                                href="{{ route('customer.show', $sale->customer_id) }}">{{ $sale->customer->name }}</a>
                                        </td>
                                        <td>{{ $sale->date }}</td>
                                        <td>{{ currency($sale->grand_total) }}</td>
                                        <td>
                                            <form class="form-inline" method="post"
                                                action="{{ route('sales.destroy', $sale->id) }}">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="{{ route('sales.edit', $sale->id) }}"
                                                    class="badge badge-info">edit</a>&nbsp;
                                                <a href="#" class="badge badge-danger btn-delete"
                                                    title="{{ $sale->no_invoice }}" data-toggle="modal"
                                                    data-target="#modal-alert">hapus</a>
                                            </form>
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
    {{-- Modal Alert --}}
    @include('partials.modal-alert')
    <!-- Modal -->
    <div class="modal fade" id="modal-filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-fw fa-filter"></i>Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-alert-body">
                    <div class="form-group">
                        <label>Bulan</label>
                        <select class="form-control">
                            @for($i = 0; $i < count($month); $i++)
                                <option value="{{ $i + 1 }}">{{ $month[$i] }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tahun</label>
                        <select class="form-control">
                            @for($i = 0; $i < count($years); $i++)
                                <option value="{{ $years[$i] }}">{{ $years[$i] }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-post">Filter</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Page level custom scripts
        $(document).ready(function() {

            $('#dataTableHover').DataTable(); // ID From dataTable with Hover

            $('#jenis').on('change', function() {
                var id = $('#jenis').val();
                window.location.href = '{{ url('product/index') }}/' + id;
            });

            $('body').on('click', '.btn-delete', function(event) {
                event.preventDefault();
                var me = $(this);
                var title = $(this).attr('title');
                $(".modal-alert-body").html("Yakin akan menghapus transaksi <b>" + title + "</b> ?")
                $("#btn-confirm").click(function() {
                    me.closest("form").submit();
                });
            });
        });

    </script>
@endpush
