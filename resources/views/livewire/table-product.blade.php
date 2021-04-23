<div>
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
