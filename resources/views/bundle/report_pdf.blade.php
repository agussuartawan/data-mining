<!DOCTYPE html>
<html>
<head>
	<title>Laporan Produk Bundel</title>
	<style type="text/css">
        *{
            font-family: sans-serif;
        },
		table tr td, table tr th {
			font-size: 9pt; 
		}
	</style>
</head>
<body>
	<div>
		<h3>Laporan Produk Bundel</h3>
        <p class="text">Periode : {{ $date['from'] }} - {{ $date['to'] }}</p>
	</div>
 
	<table>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Bundel</th>
				<th>Tgl</th>
				<th>Support</th>
				<th>Confidence</th>
				<th>Sup & Conf</th>
                <th>Produk</th>
			</tr>
		</thead>
		<tbody>
			@foreach($bundles as $i => $bundle)
			<tr>
				<td>{{ $i+1 }}</td>
				<td>{{ $bundle->bundle_name }}</td>
				<td>{{ Carbon\Carbon::parse($bundle->created_at)->isoFormat('DD MMMM Y') }}</td>
				<td>{{ round($bundle->support * 100,1) }}%</td>
				<td>{{ round($bundle->confidence * 100, 1) }}%</td>
				<td>{{ round($bundle->support_x_confidence * 100, 1) }}%</td>
                <td>
                    @foreach ($bundle->product as $product)
                        <p>{{ $product->name }} <i @if($product->pivot->keterangan == 'Fast Moving') class="text-success" @else class="text-danger" @endif>({{ $product->pivot->keterangan }})</i></p>
                    @endforeach
                </td>
			</tr>
			@endforeach
		</tbody>
	</table> 
</body>
</html>