@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <a href="{{ route('product.index', 0) }}" class="btn btn-danger mb-4" id="btn-cancle">
        <i class="fas fa-chevron-left"></i>
        Kembali
    </a>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-square"></i> &nbsp; Edit Produk Bundel</h5>
        </div>
        <div class="card-body">
            <form id="form-product" method="post" action="{{ route('product.update.bundle', $product->id) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-4">
                        <div class="shadow-sm mb-4 bg-light table-responsive rounded">
                            <div class="card-header bg-primary text-white">
                                Identitas Produk
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="kode" class="font-weight-bold">*Kode Produk</label>
                                            <input type="text" class="form-control" id="kode" value="{{ $product->kode }}"
                                                name="kode">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="nama" class="font-weight-bold">*Nama Produk Bundle</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                value="{{ $product->nama }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="stok_awal" class="font-weight-bold">Stok awal</label>
                                            <input type="number" class="form-control" id="stok_awal" name="stok"
                                                value="{{ $product->stok }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="nama-jual" class="font-weight-bold">Harga Jual</label>
                                            <input type="text" class="form-control" id="harga-jual" name="harga_jual"
                                                value="{{ $product->harga_jual }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="shadow-sm mb-4 bg-light table-responsive rounded">
                            <div class="card-header bg-primary text-white">
                                Pilih Produk
                                <div class="spinner-border float-right" role="status" id="ajax-loading" hidden=""><span
                                        class="sr-only">Loading...</span></div>
                            </div>

                            <div class="card-body" id="card-product">
                                <table cellpadding="8">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Qty</th>
                                            <th>Harga Per Produk</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>
                                                <button class="btn btn-sm btn-primary" id="tambah-baris">
                                                    <i class="fas fa-plus"></i>
                                                    Tambah
                                                </button>
                                            </th>
                                            <th></th>
                                            <th colspan="2" class="float-right">
                                                Total Rp. <span id="total-harga">0</span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <button id="btn" type="submit">Tes</button>
            </form>
        </div>
        <div class="card-footer">
            <button class="btn btn-outline-primary" id="btn-simpan">Simpan</button>
            <div class="spinner-border spinner-border-sm text-primary" role="status" hidden="hidden" id="button-loading">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('') }}js/jquery.maskMoney.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btn-simpan').click(function(event) {
                event.preventDefault();
                const form = $('#form-product');
                form.find('.invalid-feedback').remove();
                form.find('.form-control').removeClass('is-invalid');
                $('#alert-product').remove();

                $.ajax({
                    url: "{{ route('product.update.bundle',$product->id) }}",
                    type: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        $('#btn-simpan').attr('disabled', 'disabled');
                        $('#btn-cancle').addClass('btn-cancle-disable');
                        $('#button-loading').attr('hidden', false);
                    },
                    success: function(response) {
                        toastr["success"](response);
                        window.location.href = '{{ route('product.index', 0) }}';
                    },
                    error: function(xhr) {
                        var res = xhr.responseJSON;
                        if ($.isEmptyObject(res) == false) {
                            $.each(res.errors, function(key, value) {
                                $('#' + key)
                                    .addClass('is-invalid')
                                    .after('<div class="invalid-feedback">' + value +
                                        '</div>');
                                if (key == "produk") {
                                    $('#card-product').prepend(
                                        '<div class="alert alert-danger mt-0 mb-0" role="alert" id="alert-product">' +
                                        value + '</div>');
                                }
                            });
                        }
                        $('#btn-simpan').attr('disabled', false);
                        $('#btn-cancle').removeClass('btn-cancle-disable');
                        $('#button-loading').attr('hidden', 'hidden');
                    }
                });
            });

            @foreach ($product->product_bundle as $index => $product_bundle)
                var index = {{ $index + 1 }};
                var product_id = {{ $product_bundle->product }};
                var product_name = '{{ $product_bundle->product_nama($product_bundle->product) }}';
                var qty = {{ $product_bundle->qty }};
                var price = {{ $product_bundle->price }};
                dinamis_field(index, product_id, product_name, qty, price);
            @endforeach

            var count = index;

            $('#tambah-baris').click(function(event) {
                event.preventDefault();
                count++;
                dinamis_field(count, null, '', 1, 0);
            });

            $(document).on('click', '.remove-row', function(event) {
                event.preventDefault();
                var row_id = $(this).attr('id');
                $('#row' + row_id).remove();
                autosum();
            });

            $('#harga-jual').maskMoney({
                thousands: '.',
                decimal: ',',
                affixesStay: false,
                precision: 0,
                allowZero: true,
                selectAllOnFocus: true
            });

            $('#harga-jual').each(function() {
                $(this).maskMoney('mask');
            });

            $('body').on('change', '.quantity', function() {
                autosum();
            });

            $('body').on('change', '.money', function() {
                autosum();
            });
        });

        function autosum() {
            var qty = $('input[name^=qty]').map(function(idx, elem) {
                return $(elem).val();
            }).get();

            var price = $('input[name^=price]').map(function(idx, elem) {
                return $(elem).val();
            }).get();
            $.ajax({
                url: '{{ route('product.bundle.sum') }}',
                type: 'post',
                dataType: 'text',
                data: {
                    qty,
                    price
                },
                beforeSend: function() {
                    $('#ajax-loading').removeAttr('hidden');
                },
                success: function(data) {
                    $('#ajax-loading').attr('hidden', true);
                    $('#total-harga').html(data);
                }
            });
        }

        function dinamis_field(count, product_id, product_name, qty, price) {
            var html = '<tr id="row' + count + '" class="td">';
            html += '<td width="40%"><input type="hidden" id="product_id' + count +
<<<<<<< HEAD
                '" name="product_id[]" value="'+ product_id +'" readonly><select class="form-control select-product-id" name="produk[]" id="select-product' +
                count + '"><option value="'+ product_id +'" selected>'+ product_name +'</option></select></td>';
=======
                '" name="product_id[]" readonly><select class="form-control select-product-id" name="produk[]" id="select-product' +
                count + '"><option value="' + product_id + '" selected>' + product_name + '</option></select></td>';
>>>>>>> c7912036bb4336732233da19269aa3a375bd1396
            html += '<td width="20%"><input id="qty' + count +
                '" type="number" class="form-control quantity" value="' + qty + '" name="qty[]"></td>';
            html += '<td><input id="price' + count +
                '" type="text" name="price[]" value="' + price + '" class="form-control money"></td>';

            if (count > 1) {
                html += '<td class="hapus" width="1px"><a href="" class="badge badge-danger remove-row" id="' + count +
                    '" >hapus</a></td></tr>';
                $('tbody').append(html);
            } else {
                html += '<td></td></tr>';
                $('tbody').html(html);
            }

            $('#price' + count).maskMoney({
                thousands: '.',
                decimal: ',',
                affixesStay: false,
                precision: 0,
                allowZero: true,
                selectAllOnFocus: true
            });

            $('#select-product' + count).select2({
                placeholder: {
                    id: null,
                    text: "Cari Produk"
                },
                allowClear: true,
                theme: "classic",
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route('find.product') }}',
                    dataType: 'json',
                    type: 'post',
                    delay: 100,
                    data: function(params) {
                        return {
                            search: params.term
                        }
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        }
                    },
                    cache: true
                }
            }).on('change', function() {
                var selected = $(this).val();
                $('#product_id' + count).val(selected);
                $.ajax({
                    url: '{{ url('product/find/price') }}/' + selected,
                    type: 'get',
                    dataType: 'text',
                    beforeSend: function() {
                        $('#ajax-loading').removeAttr('hidden');
                    },
                    success: function(data) {
                        $('#ajax-loading').attr('hidden', true);
                        $('#price' + count).val(data);
                        $('#price' + count).maskMoney({
                            thousands: '.',
                            decimal: ',',
                            affixesStay: false,
                            precision: 0,
                            allowZero: true,
                            selectAllOnFocus: true
                        });
                        $('#price' + count).each(function() {
                            $(this).maskMoney('mask', data);
                        });
                        autosum();
                    }
                });
            });
        }

    </script>
@endpush

@push('styles')
    <style type="text/css">
        .select2-selection__rendered {
            line-height: 41px !important;
        }

        .select2-selection {
            height: 41px !important;
        }

        .select2-selection__arrow {
            height: 40px !important;
        }

        .btn-cancle-disable {
            opacity: .4;
            cursor: default !important;
            pointer-events: none;
        }

    </style>
@endpush
