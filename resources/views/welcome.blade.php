@extends('layouts.main')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ Session('success') }}
        </div>
    @endif
    <div class="row mb-3">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total User</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ currency($count_user) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ currency($count_transaction) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- New User Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Produk</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ currency($count_product) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-glass-martini-alt fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Saran Produk Bundel</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ currency($count_bundle) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Area Chart -->
        <div class="col-lg-12 mb-4">
            <div class="card mb-4">
                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Saran Produk Bundel Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-striped table-bordered rs-table-bordered" id="dataTableHover">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama Bundel</th>
                                    <th>Tanggal</th>
                                    <th>Diproses sejak</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latest_bundles as $i => $bundle)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $bundle->bundle_name }}</td>
                                        <td>{{ Carbon\Carbon::parse($bundle->date)->isoFormat('DD MMMM Y') }}</td>
                                        <td>{{ $bundle->created_at->diffForHumans() }}</td>
                                        <td><a href="{{ route('bundle.modal-detail', $bundle->id) }}"
                                                class="btn-detail badge badge-info"
                                                title="{{ $bundle->bundle_name }}">detail</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.modal')
@endsection

@push('scripts')
    <script>
        $('#dataTableHover').DataTable({
            searching: false,
            paging: false,
            info: false
        });

        $('body').on('click', '.btn-detail', function(event) {
            event.preventDefault();

            var me = $(this),
                url = me.attr('href'),
                title = me.attr('title');

            $('.modal-detail-title').text(title);
            $.ajax({
                url: url,
                dataType: 'html',
                beforeSend: function() {
                    $('#cover-spin').show(0);
                },
                success: function(response) {
                    $('.modal-detail-body').html(response);
                    $('#cover-spin').hide(0);
                }
            });
            $('#modal-detail').modal('show');
        });
    </script>
@endpush
