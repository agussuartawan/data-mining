@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12 notif">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Laporan Produk Bundel</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('report.pdf') }}" id="form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="form">Dari :</label>
                                    <input type="date" name="from" class="form-control" required="required">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="until">Sampai :</label>
                                    <input type="date" name="to" class="form-control" required="required">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                            Cari
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
            $('.text').html('Mohon tunggu..<br>Laporan sedang diproses');
            $('#cover-spin').show(0);
        });
    </script>
@endpush
