<div>
    <div class="shadow-sm mb-4 bg-light table-responsive rounded">
        <div class="card-header bg-primary text-white">
            Produk
        </div>

        <div class="card-body">
            <table class="table" style="min-width: 40rem;">
                <thead>
                    <tr>
                        <th style="width: 40%;">Nama</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>
                            <button class="btn btn-sm btn-primary btn-tambah" wire:click.prevent="addProduct">
                                <i class="fas fa-plus"></i>Tambah Data
                            </button>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($orderProducts as $index=>$orderProduct)
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div wire:ignore wire:key="{{$index}}">
                                        <select class="selectpicker form-control" name="orderProducts[{{$index}}][product_id]" wire:model="orderProducts.{{$index}}.product_id">
                                            @foreach($allProducts as $product)
                                            <option value="{{$product->id}}">{{$product->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="orderProducts[{{$index}}][qty]" wire:model="orderProducts.{{$index}}.qty">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="orderProducts[{{$index}}][price]" wire:model="orderProducts.{{$index}}.price">
                            </td>
                            <td><a href="#" class="badge badge-danger" wire:click.prevent="removeProduct({{$index}})">hapus</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
