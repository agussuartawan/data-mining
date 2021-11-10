<!DOCTYPE html>
<html>

<head>
    <title>Laporan Produk Bundel</title>
</head>

<body>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        h3 {
            font-weight: bold;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 9pt;
        }

        .table th {
            padding: 8px 8px;
            border: 1px solid #000000;
            text-align: center;
        }

        .table td {
            vertical-align: top;
            padding: 3px 3px;
            border: 1px solid #000000;
        }

        .text-center {
            text-align: center;
        }

    </style>
    <h3>Laporan Produk Bundel</h3>
    <p class="text">Periode : {{ Carbon\Carbon::parse($date['from'])->isoFormat('DD MMMM Y') }} -
        {{ Carbon\Carbon::parse($date['to'])->isoFormat('DD MMMM Y') }}</p>

    <table class="table">
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
            @forelse ($bundles as $i => $bundle)
                <tr>
                    <td class="text-center">
                        <p>{{ $i + 1 }}</p>
                    </td>
                    <td>
                        <p>{{ $bundle->bundle_name }}</p>
                    </td>
                    <td class="text-center">
                        <p>{{ Carbon\Carbon::parse($bundle->created_at)->isoFormat('DD MMMM Y') }}</p>
                    </td>
                    <td class="text-center">
                        <p>{{ round($bundle->support * 100, 1) }}%</p>
                    </td>
                    <td class="text-center">
                        <p>{{ round($bundle->confidence * 100, 1) }}%</p>
                    </td>
                    <td class="text-center">
                        <p>{{ round($bundle->support_x_confidence * 100, 1) }}%</p>
                    </td>
                    <td>
                        @foreach ($bundle->product as $product)
                            <p>{{ $product->name }} <i>({{ $product->pivot->keterangan }})</i></p>
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center"><p>Tidak ada data.</p></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
