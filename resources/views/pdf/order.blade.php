<html>

<head>
    <title> Laporan Pesanan</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
</head>

<body>
    <div class="container">
        <table width="100%">
            <tr>
                <td width="20%" class="text-center">
                    <img src="/images/logo2.png" width="120pt">
                </td>
                <td style="text-align: center" width="50%">
                    <h1 style="font-size: 22pt;font-weight:bold;text-decoration:underline;">CV. WORKPRODUKTIF AAPMIN</h1>
                    <h2 style="font-size: 18pt;font-weight:bold;">SERVICE PROCUREMENT COMPANY</h2>
                    <p class="mb-0" style="font-size: 10pt;margin-bottom:15px">Office/Factory : Jl RSI Faisal II No. 4, Banta – Bantaeng, Kec. Rappocini, Kota Makassar Sulawesi Selatan</p>
                </td>
            </tr>
        </table>
        <div style="width:100%; padding:3px;background:black;"></div>
        <div style="width:100%; padding:1px;background:black; margin-top:4px;"></div>
        <br/>
        <br/>
        <h2 class="h3 text-center" style="font-weight: bold; margin-top:0px">LAPORAN PESANAN</h2>
        <h2 class="h4 text-center" style="font-weight: bold; margin-top:0px">
            Periode : {{ \Carbon\Carbon::parse($tgl[0])->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($tgl[1])->translatedFormat('d F Y') }}
        </h2>
        <br/>
        <table class="table table-bordered datatable w-100">
            <thead>
                <tr>
                    <th width="60px">No</th>
                    <th>No Pesanan</th>
                    <th>Konsumen</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $a)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $a->nomor }}</td>
                        <td>{{ $a->user->nama }}</td>
                        <td>{{ \Carbon\Carbon::parse($a->tgl)->translatedFormat('d F Y') }}</td>
                        <td>{{ $a->status }}</td>
                        <td>{{ number_format($a->total,0,',','.') }} Bulan</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>