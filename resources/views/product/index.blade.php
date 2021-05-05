@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    @if (Session::has('success'))
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ Session('success') }}
                        </div>
                    @endif
                    <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-glass-martini-alt"></i> &nbsp; Data
                        Produk</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive p-3">
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-inline">
                                    <label class="label">Jenis Produk </label>&nbsp;
                                    <select class="custom-select custom-select-sm form-control form-control-sm" id="jenis">
                                        <option value="0" {{ $selected == 0 ? 'selected' : '' }}>Semua</option>
                                        @foreach ($group as $j)
                                            <option value="{{ $j->id }}"
                                                {{ $selected == $j->id ? 'selected' : '' }}>
                                                {{ $j->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="btn-group float-right" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-plus"></i>
                                        Tambah Produk
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <a class="dropdown-item" href="{{ route('product.create') }}">Produk</a>
                                        <a class="dropdown-item" href="{{ route('product.create.bundle') }}">Produk
                                            Bundle</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table align-items-center table-flush table-striped table-hover" id="dataTableHover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th width="15%">Kode</th>
                                    <th>Nama Produk</th>
                                    <th width="10%">Stok</th>
                                    <th width="10%">Jenis</th>
                                    <th width="15%">###</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index => $product)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if ($product->tipe == 'Bundle')
                                                <i class="fas fa-box-open"></i>
                                            @endif
                                        </td>
                                        <td><a class="card-link"
                                                href="{{ route('product.show', $product->id) }}">{{ $product->kode }}</a>
                                        </td>
                                        <td><a class="card-link"
                                                href="{{ route('product.show', $product->id) }}">{{ $product->nama }}</a>
                                        </td>
                                        <td>{{ $product->stok }}</td>
                                        <td><a class="card-link" href="">{{ $product->group->nama }}</a></td>
                                        </td>
                                        <td>
                                            <form class="form-inline" method="post"
                                                action="{{ route('product.destroy', $product->id) }}">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                    class="badge badge-info">edit</a>&nbsp;
                                                <a href="#" class="badge badge-danger btn-delete"
                                                    title="{{ $product->nama }}">hapus</a>
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
@endsection

@push('scripts')
    <script>
        // Page level custom scripts
        $(document).ready(function() {

            $('#dataTableHover').DataTable(); // ID From dataTable with Hover

            $('#jenis').on('change', function() {
                var id = $('#jenis').val();
                window.location.href = '{{ url('product') }}/' + id;
            });

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
