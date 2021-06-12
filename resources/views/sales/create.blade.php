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
        <div class="card-body">
            <form id="form-product">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shadow-sm mb-4 bg-light table-responsive rounded">
                            <div class="card-header bg-primary text-white">
                                Pelanggan
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bold">*Nama Pelanggan</label>
                                            <select class="form-control select-customer">
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="email" class="font-weight-bold">E-mail</label>
                                            <input type="email" class="form-control" id="email" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="no_invoice" class="font-weight-bold">No Penjualan</label>
                                            <input type="text" class="form-control" id="no_invoice" value="{{ ++$no_invoice->no_invoice }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address" class="font-weight-bold">Alamat</label>
                                            <textarea class="form-control" id="address" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="date" class="font-weight-bold">Tanggal</label>
                                            <input class="form-control" type="text" id="date" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
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
                                            <th>Produk</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Diskon(%)</th>
                                            <th>Subtotal</th>
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
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-lg-7"></div>
                <div class="col-lg-2 text-right">
                    <h5>Total :</h5>
                    <h5>Diskon(%) :</h5>
                    <h5 class="font-weight-bold">Grand Total :</h5>
                </div>
                <div class="col-lg-3 text-right">
                    <h5>Rp. 100.000.000</h5>
                    <input class="form-control form-control-sm" type="text">
                    <h5 class="font-weight-bold">Rp. 100.000.000.000</h5>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-outline-primary" id="btn-simpan">Simpan</button>
            <button type="submit" class="btn btn-outline-primary" id="btn-simpan-baru">Simpan & Baru</button>
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
            // For Customer
            // Select2 for customer
            $('.select-customer').select2({
                placeholder: "Cari Pelanggan",
                allowClear: true,
                theme: "classic",
                minimumInputLength: 1
            }).on('change', function(){
                var customer_id = $(this).val();
                if(customer_id == null){
                    $('#email').val('');
                    $('#address').text('');
                }
                $.ajax({
                    url: '{{ url('customer/find/') }}/' + customer_id,
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        $('#email').val(data[0].email);
                        $('#address').text(data[0].address);
                    }
                });
            });


            $('#btn-simpan-baru').click(function(event) {
                event.preventDefault();
                const form = $('#form-product');
                form.find('.invalid-feedback').remove();
                form.find('.form-control').removeClass('is-invalid');
                $('#alert-product').remove();

                $.ajax({
                    url: '{{ route('product.store.bundle') }}',
                    type: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        $('#btn-simpan').attr('disabled', 'disabled');
                        $('#btn-simpan-baru').attr('disabled', 'disabled');
                        $('#btn-cancle').addClass('btn-cancle-disable');
                        $('#button-loading').attr('hidden', false);
                    },
                    success: function(response) {
                        toastr["success"](response);
                        $('#btn-simpan').attr('disabled', false);
                        $('#btn-simpan-baru').attr('disabled', false);
                        $('#btn-cancle').removeClass('btn-cancle-disable');
                        $('#button-loading').attr('hidden', 'hidden');
                        dinamis_field(1);
                        form.trigger('reset');
                        $('#total-harga').text(0);
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
                        $('#btn-simpan-baru').attr('disabled', false);
                        $('#btn-cancle').removeClass('btn-cancle-disable');
                        $('#button-loading').attr('hidden', 'hidden');
                    }
                });
            });

            $('#btn-simpan').click(function(event) {
                event.preventDefault();
                const form = $('#form-product');
                form.find('.invalid-feedback').remove();
                form.find('.form-control').removeClass('is-invalid');
                $('#alert-product').remove();

                $.ajax({
                    url: '{{ route('product.store.bundle') }}',
                    type: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        $('#btn-simpan').attr('disabled', 'disabled');
                        $('#btn-simpan-baru').attr('disabled', 'disabled');
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
                        $('#btn-simpan-baru').attr('disabled', false);
                        $('#btn-cancle').removeClass('btn-cancle-disable');
                        $('#button-loading').attr('hidden', 'hidden');
                    }
                });
            });

            var count = 1;
            for (var i = 1; i <= count; i++) {
                dinamis_field(i);
            }

            $('#tambah-baris').click(function(event) {
                event.preventDefault();
                count++;
                dinamis_field(count);
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

        function dinamis_field(count) {
            var html = '<tr id="row' + count + '" class="td">';
            html += '<td width="30%"><input type="hidden" id="product_id' + count +
                '" name="product_id[]" readonly><select class="form-control select-product-id" name="produk[]" id="select-product' +
                count + '"></select></td>';
            html += '<td width="15%"><input id="qty' + count +
                '" type="number" class="form-control quantity" value="1" name="qty[]"></td>';
            html += '<td width="20%"><input id="price' + count +
                '" type="text" name="price[]" value="0" class="form-control money"></td>';
            html += '<td width="5%"><input id="discount' + count +
            '" type="text" name="discount[]" value="0" class="form-control"></td>';
            html += '<td width="20%"><input id="subtotal' + count +
                '" type="text" name="subtotal[]" value="0" class="form-control money"></td>';

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
