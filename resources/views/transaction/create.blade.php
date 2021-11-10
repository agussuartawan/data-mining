@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12 notif">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Import Penjualan</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('transaction.import') }}" enctype="multipart/form-data"
                        id="form">
                        @csrf
                        <div class="form-group">
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required="required">
                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <a class="btn btn-danger" href="{{ url()->previous() }}">
                            <i class="fas fa-times"></i>
                            Batal
                        </a>
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-cloud-download-alt"></i>
                            Import
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $('#form').on('submit', function(e) {
            $('.text').html('Mohon tunggu..<br>File anda sedang diupload');
            $('#cover-spin').show(0);
        });
    </script>
@endpush
