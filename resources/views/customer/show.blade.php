@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Produk</h1>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <a href="{{ route('customer.index') }}" class="btn btn-danger mb-4" id="btn-cancle">
                <i class="fas fa-chevron-left"></i>
                Kembali
            </a>
        </div>
        <div class="col-lg-6">
            <form class="form-inline float-right" method="post" action="{{ route('customer.destroy', $customer->id) }}">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-info"> <i class="fas fa-edit"></i>
                    Edit</a> &nbsp;
                <a href="#" class="btn btn-danger btn-delete" title="{{ $customer->name }}" data-toggle="modal"
                    data-target="#modal-alert"> <i class="fas fa-trash"></i>
                    Hapus</a>
            </form>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="m-0 font-weight-bold text-info"><i class="fas fa-info-circle"></i> &nbsp; {{ $title }}</h5>
        </div>
        <div class="card-body">
            <div class="shadow-sm bg-light rounded">
                <div class="card-header bg-info text-white">
                    {{ $customer->name }}
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2"><span>Alamat</span></div>
                            <div class="col-10">:&nbsp;&nbsp;
                                @if (!$customer->address)
                                    <small class="font-italic text-danger">(Belum diset)</small>
                                @else
                                    {{ $customer->address }}
                                @endif
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2"><span>E-mail</span></div>
                            <div class="col-10">:&nbsp;&nbsp;
                                @if (!$customer->email)
                                    <small class="font-italic text-danger">(Belum diset)</small>
                                @else
                                    {{ $customer->email }}
                                @endif
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2"><span>Telp</span></div>
                            <div class="col-10">:&nbsp;&nbsp;
                                @if (!$customer->phone)
                                    <small class="font-italic text-danger">(Belum diset)</small>
                                @else
                                    {{ $customer->phone }}
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    {{-- Modal Alert --}}
    @include('partials.modal-alert')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
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
