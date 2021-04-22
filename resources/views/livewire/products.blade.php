<div>
    <div class="shadow-sm mb-4 bg-light table-responsive rounded">
        <div class="card-header bg-primary text-white">
            Pilih Produk {{$product_id}}
        </div>

        <div class="card-body">
            <form>
                <div class="row">
                        <div class="col-lg-4">
                            <select class="select-produc form-control" name="product_id" wire:model="product_id">
                                @foreach($allProducts as $product)
                                    <option value="{{$product->id}}">{{$product->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <input type="number" class="form-control" name="qty" placeholder="Qty" wire:model="qty">
                        </div>
                        <div class="col-lg-3">
                            <input type="number" class="form-control" name="price" placeholder="Harga" wire:model="price">
                        </div>
                        <div class="col-lg-2">
                            <button wire:loading.attr="disabled"
                            {{ $formType == 0 ? 'wire:click.prevent="store"' : 'wire:click.prevent="update"' }} 
                            class="btn btn-primary btn-tambah mt-1">
                                <div class="spinner-grow spinner-grow-sm" role="status" wire:loading>
                                    <span class="sr-only">Loading...</span>
                                </div>
                                {{$btnTitle}}
                            </button>
                        </div>
                </div>
            </form>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th style="width: 40%;">Nama</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product_temp as $index=>$pt)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$pt->nama}}</td>
                                    <td>{{$pt->qty}}</td>
                                    <td>{{$pt->price}}</td>
                                    <td>
                                        <a href="#" class="badge badge-info" wire:click.prevent="getDataProduct({{$pt->id}})">edit</a>
                                        <a href="#" class="badge badge-danger" wire:click.prevent="destroy({{$pt->id}})">hapus</a>
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

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.select-product').select2({
                placeholder: "Pilih Produk",
                allowClear: true,
                theme: "classic"
            });

            $('#table').dataTable({searching: false, paging: false, info: false});
        });
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
