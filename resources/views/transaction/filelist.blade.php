@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="row mb-3">
                <div class="col-lg-12">
                    <a class="btn btn-sm btn-primary" href="{{ route('transaction.create') }}">
                        <i class="fas fa-plus"></i>
                        Import
                    </a>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Data
                        File</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-striped table-bordered rs-table-bordered" id="dataTableHover">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th>Nama File</th>
                                    <th>Diupload sejak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filelist as $index => $file)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $file->file_name }}</td>
                                        <td>{{ Carbon\Carbon::parse($file->created_at)->diffForhumans() }}</td>
                                        <td><a href="{{ route('transaction.data', $file->id) }}"
                                            class="badge badge-info">lihat transaksi</a></td>
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
