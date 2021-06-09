@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <a href="{{ route('customer.create') }}" class="btn btn-primary mb-4">
                <i class="fas fa-plus"></i>
                Tambah
            </a>
        </div>
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
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-users"></i> &nbsp; Data
                        Pelanggan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-striped table-hover" id="dataTableHover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama Pelanggan</th>
                                    <th width="30%">Alamat</th>
                                    <th width="20%">Telp</th>
                                    <th width="15%">###</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $index => $customer)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><a class="card-link"
                                                href="{{ route('customer.show', $customer->id) }}">{{ $customer->name }}</a>
                                        </td>
                                        <td>
                                            @if (!$customer->address)
                                                <small class="font-italic text-danger">(Belum diset)</small>
                                            @else
                                                {{ $customer->address }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$customer->phone)
                                                <small class="font-italic text-danger">(Belum diset)</small>
                                            @else
                                                {{ $customer->phone }}
                                            @endif
                                        </td>
                                        </td>
                                        <td>
                                            <form class="form-inline" method="post"
                                                action="{{ route('customer.destroy', $customer->id) }}">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="{{ route('customer.edit', $customer->id) }}"
                                                    class="badge badge-info">edit</a>&nbsp;
                                                <a href="#" class="badge badge-danger btn-delete"
                                                    title="{{ $customer->name }}" data-toggle="modal"
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
@endsection

@push('scripts')
    <script>
        // Page level custom scripts
        $(document).ready(function() {

            $('#dataTableHover').DataTable(); // ID From dataTable with Hover

            $('body').on('click', '.btn-delete', function(event) {
                event.preventDefault();
                var me = $(this);
                var title = $(this).attr('title');
                $(".modal-alert-body").html("Yakin akan menghapus pelanggan <b>" + title + "</b> ?")
                $("#btn-confirm").click(function() {
                    me.closest("form").submit();
                });
            });
        });

    </script>
@endpush
