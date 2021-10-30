@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Input Kriteria</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('bundle.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group input-group-sm">
                                    <label>Masukan nilai support</label>
                                    <i class="far fa-question-circle" rel="tooltip"
                                        title="Input dalam persen tanpa tanda (%)"></i>
                                    <input type="text" name="support" class="form-control" required="required">
                                </div>
                                <div class="form-group input-group-sm">
                                    <label>Masukan nilai confidence</label>
                                    <i class="far fa-question-circle" rel="tooltip"
                                        title="Input dalam persen tanpa tanda (%)"></i>
                                    <input type="text" name="confidence" class="form-control" required="required">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="label">Pilih data transaksi</label>
                                <div class="input-group input-group-sm mb-3">
                                    <input type="text" class="form-control" id="file_list_name"
                                        placeholder="Cari data transaksi" readonly>
                                    <input type="text" name="filelist" id="file_list_id" readonly="" hidden="">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#search-modal"
                                            type="button"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" onclick="$('#cover-spin').show(0)">
                            Proses
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Hasil</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-striped table-hover" id="dataTableHover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama Bundel</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="15%">Aksi</th>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data File List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table align-items-center table-flush table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th width="10%">#</th>
                                <th>Nama File</th>
                                <th>Di upload pada</th>
                                <th>Aksi</th>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($filelist as $index => $filelist)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="file-list-name">{{ $filelist->file_name }}</td>
                                    <td>{{ $filelist->created_at->isoFormat('dddd, D MMMM Y') }}</td>
                                    <td><a href="#" class="badge badge-info select-button"
                                            title="{{ $filelist->id }}">pilih</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $('#dataTableHover').DataTable({
            searching: false,
            paging: false,
            info: false
        });

        $(document).ready(function($) {
            $('.select-button').click(function(event) {
                event.preventDefault();

                var fileName = $(this).parents('tr').find('.file-list-name').text();
                var fileId = $(this).attr('title');

                $('#file_list_name').val(fileName);
                $('#file_list_id').val(fileId);
                $('#search-modal').modal('hide');
            });

            $("[rel=tooltip]").tooltip({
                placement: 'right'
            });
        });
    </script>
@endpush

@push('styles')
    <style type="text/css">
        #cover-spin {
            position: fixed;
            width: 100%;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.685);
            z-index: 9999;
            display: none;
        }

        @-webkit-keyframes spin {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        #cover-spin::after {
            content: '';
            display: block;
            position: absolute;
            left: 48%;
            top: 40%;
            width: 40px;
            height: 40px;
            border-style: solid;
            border-color: rgb(255, 255, 255);
            border-top-color: transparent;
            border-width: 4px;
            border-radius: 50%;
            -webkit-animation: spin .8s linear infinite;
            animation: spin .8s linear infinite;
        }

        .text {
            text-align: center;
            margin-top: 430px;
        }

    </style>
@endpush
