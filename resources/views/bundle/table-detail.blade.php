<table class="table table-bordered rs-table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Produk</th>
            <th width="20%">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bundle->product as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>
                    <p @if($product->pivot->keterangan == "Slow Moving") class="badge badge-danger" @else class="badge badge-success" @endif>
                        {{ $product->pivot->keterangan }}
                    </p>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>