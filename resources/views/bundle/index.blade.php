@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="row mb-3">
                <div class="col-lg-12">
                    <a class="btn btn-sm btn-primary" href="{{ route('bundle.create') }}">
                        <i class="fas fa-spinner"></i>
                        Proses Produk Bundel
                    </a>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Data Produk Bundel</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-striped table-bordered rs-table-bordered" id="dataTableHover">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama Bundel</th>
                                    <th>Support</th>
                                    <th>Confidence</th>
                                    <th>Support & Confidence</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bundles as $key => $bundle)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $bundle->bundle_name }}</td>
                                        <td>{{ round($bundle->support * 100, 1) }}%</td>
                                        <td>{{ round($bundle->confidence * 100, 1) }}%</td>
                                        <td>{{ round($bundle->support_x_confidence * 100, 1) }}%</td>
                                        <td>{{ Carbon\Carbon::parse($bundle->date)->isoFormat('DD MMMM Y') }}</td>
                                        <td><a href="{{ route('bundle.show', $bundle->id) }}" class="badge badge-info">detail</a></td>
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
        $(document).ready(function() {
            $('#dataTableHover').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 100]
            });
        });
    </script>
@endpush
