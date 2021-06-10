@foreach ($sales as $sale)
    <p>{{ $sale->customer_id }}</p>
    <p>{{ $sale->date }}</p>
    <p>{{ $sale->global_discount }}</p>
    <p>{{ $sale->grand_total }}</p>
    <hr>
    @foreach ($sale->product as $product)
        <p>kode {{ $product->kode }}</p>
        <p>nama {{ $product->nama }}</p>
        <p>qty {{ $product->pivot->qty }}</p>
        <p>diskon{{ $product->pivot->discount }}</p>
        <p>harga {{ $product->pivot->price }}</p>
        <p>subtotal {{ $product->pivot->subtotal }}</p>
    @endforeach
@endforeach
