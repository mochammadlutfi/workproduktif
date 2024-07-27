<html>

<head>
    <title>Invoice {{ $data->nomor }}</title>

    <link rel="stylesheet" href="/css/bootstrap.css">
</head>

<body>
    <div class="container">
        <table width="100%">
            <tr>
                <td width="20%" class="text-center">
                    <img src="/images/logo.png" width="120pt">
                </td>
                <td class="text-right width" width="50%">
                    <h1 style="margin-bottom: 5px;font-size:16pt;font-weight: 600;">INVOICE</h1>
                    <table width="400px">
                        <tr>
                            <td>
                                Referensi
                            </td>
                            <td style="text-align: right;">
                                {{ $data->nomor}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Tanggal
                            </td>
                            <td style="text-align: right;">
                                {{ \Carbon\Carbon::parse($data->tgl)->translatedFormat('d F Y')}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br/>
        <br/>
        <table width="100%">
            <tr>
                <td style="border-bottom: 1px solid black" width="40%">
                    Info Perusahaan
                </td>
                <td></td>
                <td style="border-bottom: 1px solid black" width="40%">
                    Tagihan untuk
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style="font-size: 12pt;font-weight:bold;">Work Produktif AAPMIN</h4>
                    <br/>
                    <p style="font-size:10pt">
                        Jalan RSI Faisal 2 no.4<br/>
                        Makassar, Kota Makassar,<br/>
                        Sulawesi Selatan, Indonesia<br/>
                        <br/>
                        Telp : 085656859403<br/>
                        Email : echapawi04@gmail.com
                    </p>
                </td>
                <td></td>
                <td>
                    <h4 style="font-size: 12pt;font-weight:bold;">{{$data->user->nama}}</h4>
                    <br/>
                    <p style="font-size:10pt">
                        {{$data->user->alamat}}
                        <br/>
                        Telp : {{$data->user->hp}}<br/>
                        Email : {{$data->user->email}}
                    </p>
                </td>
            </tr>
        </table>
        <br/>
        <br/>
        {{-- <hr/> --}}
        <table class="table v-align-center table-bordered datatable w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Lama</th>
                    <th>Harga Unit</th>
                    <th>Harga Operator</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->produk->nama }}</td>
                        <td>{{ $data->qty }} Unit</td>
                        <td>{{ $data->lama }} Jam</td>
                        <td>Rp {{ number_format($data->harga_unit,0,',','.') }}</td>
                        <td>Rp {{ number_format($data->harga_operator,0,',','.') }}</td>
                        <td>Rp {{ number_format($data->total,0,',','.') }}</td>
                    </tr>
            </tbody>
        </table>
        <br/>
        <table style="float: left;width: 100%;border-spacing: 0px;">
            <tr>
                <td width="60%"></td>
                <td>Sub Total</td>
                <td>Rp. {{ number_format($data->total,0,',','.') }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Dibayar</td>
                <td>Rp. {{ number_format($data->dibayar,0,',','.') }}</td>
            </tr>
            <tr>
                <td></td>
                <td style="border-bottom:1px solid black">Sisa</td>
                <td style="border-bottom:1px solid black">Rp. {{ number_format($data->total-$data->dibayar,0,',','.') }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Jumlah Tertagih</td>
                <td>Rp. {{ number_format($data->total-$data->dibayar,0,',','.') }}</td>
            </tr>
        </table>
        <br/>
        <br/>
        <br/>
        <table style="float: left;width: 100%;">
            <tr>
                <td width="80%"></td>
                <td style="text-align:center;">
                    {{ \Carbon\Carbon::today()->translatedFormat('d F Y') }}
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <hr/>
                    <p>ANDI ECHA PAW</p>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>