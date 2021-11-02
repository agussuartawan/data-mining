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
                        <table class="table align-items-center table-flush table-striped table-hover" id="dataTableHover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="10%">#</th>
                                    <th>Nama File</th>
                                    <th>Diupload sejak</th>
                                    <th>Aksi</th>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filelist as $index => $filelist)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $filelist->file_name }}</td>
                                        <td>{{ $filelist->created_at->diffForHumans() }}</td>
                                        <td><a href="{{ route('transaction.data', $filelist->id) }}"
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
    {{-- Modal Alert --}}
    @include('partials.modal-alert')

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
