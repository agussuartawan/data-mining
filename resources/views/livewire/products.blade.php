<div>
    <div class="shadow-sm mb-4 bg-light table-responsive rounded">
        <div class="card-header bg-primary text-white">
            Pilih Produk
            <div class="spinner-border float-right" role="status" wire:loading>
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="card-body">
            <form>
                <div class="row">
                        <div class="col-lg-4" wire:ignore>
                            <select class="form-control" name="product_id" wire:model="product_id" id="select-product" data-livewire="@this">
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
                            wire:click.prevent="store"
                            class="btn btn-primary btn-tambah mt-1">
                                {{$btnTitle}}
                            </button>
                        </div>
                </div>
            </form>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    @livewire('table-product')
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#select-product').select2({
                placeholder: "Pilih Produk",
                allowClear: true,
                theme: "classic"
            }).on('change', function (e) {
                let livewire = $(this).data('livewire');
                eval(livewire).set('product_id', $(this).val());
            });
        });
        document.addEventListener("livewire:load", function (event) {
            window.livewire.hook('afterDomUpdate', () => {
                $('#select-product').select2({
                    placeholder: "Pilih Produk",
                    allowClear: true,
                    theme: "classic"
                });
            });
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
