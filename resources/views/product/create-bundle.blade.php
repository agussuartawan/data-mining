@extends('layouts.main')
@section('content')
  <div class="card mb-4">
    <div class="card-body">
    	@if(Session::has('success'))
	      <div class="alert alert-info alert-dismissible" role="alert">
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	        {{Session('success')}}
	      </div>
	    @endif
      <form id="form-product" method="post" action="{{route('product.store.bundle')}}">
      	@csrf

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
                            <input type="text" class="form-control" id="kode" placeholder="Contoh AB001 untuk Absolut Blue" name="kode">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                          <label for="nama" class="font-weight-bold">*Nama Produk Bundle</label>
                          <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                        <label for="nama-jual" class="font-weight-bold">Harga Jual</label>
                        <input type="text" class="form-control" id="harga-jual" name="harga_jual" value="0">
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
                    <div class="spinner-border float-right" role="status" id="ajax-loading" hidden=""><span class="sr-only">Loading...</span></div>
                </div>

                <div class="card-body">
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
        <hr>
        <input type="hidden" name="redirect_to" id="redirect_to">
        <a href="{{route('product.index',0)}}" class="btn btn-outline-danger">Batal</a>
        <button type="submit" class="btn btn-outline-primary" id="btn-simpan">Simpan</button>
        <button type="submit" class="btn btn-outline-primary" id="btn-simpan-baru">Simpan & Baru</button>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
    <script src="{{asset('')}}js/jquery.maskMoney.min.js"></script>
    <script type="text/javascript">
        $(document).ready( function(){
            $('#btn-simpan').click(function(event) {
                event.preventDefault();
                $('#redirect_to').val('index');
                $('#form-product').submit();
            });

            $('#btn-simpan-baru').click(function(event) {
                event.preventDefault();
                $('#redirect_to').val('create');
                $('#form-product').submit();
            });

            var count = 1;
            for (var i = 1; i <= count; i++) {
                dinamis_field(i);
            }

            $('#tambah-baris').click(function(event){
                event.preventDefault();
                count++;
                dinamis_field(count);
            });

            $(document).on('click', '.remove-row', function(event){
                event.preventDefault();
                var row_id = $(this).attr('id');
                $('#row'+row_id).remove();
                autosum(); 
            });

            $('#harga-jual').maskMoney({
                thousands:'.', 
                decimal:',', 
                affixesStay: false, 
                precision: 0,
                allowZero: true,
                selectAllOnFocus: true
            });

            $('body').on('change', '.quantity', function(){
                autosum();
            });

            $('body').on('change', '.money', function(){
                autosum();
            });
        });

        function autosum(){
            var qty = $('input[name^=qty]').map(function(idx, elem) {
                            return $(elem).val();
                          }).get();

            var price = $('input[name^=price]').map(function(idx, elem) {
                            return $(elem).val();
                          }).get();
            $.ajax({
                url: '{{route('product.bundle.sum')}}',
                type: 'post',
                dataType: 'text',
                data: {qty,price},
                beforeSend: function(){
                    $('#ajax-loading').removeAttr('hidden');
                },
                success: function(data){
                    $('#ajax-loading').attr('hidden',true);
                    $('#total-harga').html(data);
                }
            });
        }

        function dinamis_field(count){
            var html = '<tr id="row'+count+'" class="td">';
            html += '<td width="40%"><input type="hidden" id="product_id'+count+'" name="product_id[]" value="0" readonly><select class="form-control select-product-id" id="select-product'+count+'"></select></td>';
            html += '<td width="20%"><input id="qty'+count+'" type="number" class="form-control quantity" value="1" name="qty[]"></td>';
            html += '<td><input id="price'+count+'" type="text" name="price[]" value="0" class="form-control money"></td>';

            if (count > 1){
                html += '<td class="hapus" width="1px"><a href="" class="badge badge-danger remove-row" id="'+count+'" >hapus</a></td></tr>';
                $('tbody').append(html);
            } else {
                html += '<td></td></tr>';
                $('tbody').html(html);
            }

            $('#price'+count).maskMoney({
                thousands:'.', 
                decimal:',', 
                affixesStay: false, 
                precision: 0,
                allowZero: true,
                selectAllOnFocus: true
            });

            $('#select-product'+count).select2({
                placeholder: {
                    id : null,
                    text : "Cari Produk"
                },
                allowClear: true,
                theme: "classic",
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route("find.product") }}',
                    dataType: 'json',
                    type: 'post',
                    delay: 100,
                    data: function(params){
                        return {
                            search: params.term
                        }
                    },
                    processResults: function(data){
                        return {
                            results: data
                        }
                    },
                    cache: true
                }
            }).on('change', function() {
                var selected = $(this).val();
                $('#product_id'+count).val(selected);
                $.ajax({
                    url: '{{ url('product/find/price') }}/'+selected,
                    type: 'get',
                    dataType: 'text',
                    beforeSend: function() {
                        $('#ajax-loading').removeAttr('hidden');
                    },
                    success: function(data){
                        $('#ajax-loading').attr('hidden',true);
                        $('#price'+count).val(data);
                        $('#price'+count).maskMoney({
                            thousands:'.', 
                            decimal:',', 
                            affixesStay: false, 
                            precision: 0,
                            allowZero: true,
                            selectAllOnFocus: true
                        });
                        $('#price'+count).each(function() {
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
    </style>
@endpush