<html>

<head>
    <title>Surat Kontrak {{ $data->nomor }}</title>

    <link rel="stylesheet" href="/css/bootstrap.css">
    <style>
        @page {
            header: page-header;
        }
        @page *{
            padding-top: 150cm;
        }

        body {
            font-family: "Times New Roman", "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 11pt;
        }

        
        .table2 {
            border-collapse: collapse;
            width: 100%;
            font-size: 10pt;
        }

        .table2 td, .table2 th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table2 th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

        h3 {
            font-size: 12pt;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <htmlpageheader name="page-header">
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
    </htmlpageheader>
    <div class="container">
        <h3 style="font-size: 14pt;font-weight:bold;text-decoration:underline;text-align:center;">SURAT PERJANJIAN SEWA ALAT BERAT</h3>
        <h4 style="font-size: 11pt;font-weight:bold;text-align:center;">No : 25/IJ/SP2AB/VIII/2021</h4>

        <p>Pada Hari {{ $date['hari'] }} Tanggal {{ $date['tgl'] }} Bulan {{ $date['bulan']}} Tahun {{ $date['tahun'] }} yang bertanda tanggan di bawah ini :</p>

        <table width="100%">
            <tr>
                <td width="130px">Nama</td>
                <td>: <b>MUHAMMAD IKSAN NUR</b></td>
            </tr>
            <tr>
                <td width="130px">Jabatan</td>
                <td>: <b>DIREKTUR UTAMA</b></td>
            </tr>
            <tr>
                <td width="130px">Perusahaan</td>
                <td>: <b>CV. WORKPRODUKTIF AAPMIN</b></td>
            </tr>
            <tr>
                <td width="130px">Alamat</td>
                <td>: <b>Jalan RSI Faisal II No. 4, Banta – Bantaeng, Kec Rappocini, Kota Makassar, 
                    Sulawesi Selatan 90222</b></td>
            </tr>
            <tr>
                <td width="130px">No Telp</td>
                <td>: <b>085258587128</b></td>
            </tr>
        </table>
        <br/>
        <p>Dalam hal ini bertindak untuk dan atas nama, yang selanjutnya dalam surat perjanjian sewa alat
            ini disebut sebagai pemilik alat (PIHAK PERTAMA)</p>
        
        <table width="100%">
            <tr>
                <td width="130px">Nama</td>
                <td>: <b>{{ $data->user->nama }}</b></td>
            </tr>
            <tr>
                <td width="130px">Jabatan</td>
                <td>: <b>{{ $data->user->jabatan ?? '-' }}</b></td>
            </tr>
            <tr>
                <td width="130px">Perusahaan</td>
                <td>: <b>{{ $data->user->perusahaan ?? '-' }}</b></td>
            </tr>
            <tr>
                <td width="130px">Alamat</td>
                <td>: 
                    <b>{{ $data->user->alamat ?? '-' }}</b>
                </td>
            </tr>
            <tr>
                <td width="130px">No Telp</td>
                <td>: <b>{{ $data->user->hp ?? '-' }}</b></td>
            </tr>
        </table>
        <br/>
        <p>PARA PIHAK terlebihi dahulu menerangkan kedudukan masing-masing sebagai berikut : </p>
        <ul>
        <li>PIHAK PERTAMA adalah penyedia/pemilik ALAT BERAT yang selanjutnya dalam perjanjian ini disebut “ ALAT BERAT”</li>
        <li>PIHAK KEDUA adalah penyewa Alat Berat dengan merek {{ $data->produk->nama }}, dan pengguna/penanggung jawab ALAT BERAT</li>
        </ul>
        <h3 style="text-align: center;">PASAL I</h3>
        <h3 style="text-align: center;">JANGKA WAKTU SEWA 1.</h3>
        <ol>
            <li>Perjanjian ini mulai berlaku efektif tanggal ditandatanganinya perjanjian ini dan berlaku {{ $data->lama }} jam
                dengan waktu pemakaian satu bulan (30 hari).</li>
            <li>Perjanjian ini dapat di perpanjang untuk jangka waktu tertentu sebelum jangka waktu berlakunya
                perjanjian ini berakhir dan dituangkan dalam addendum/Amandemen dengan membuat perjanjian baru atas
                kesepakatan tertulis dari PARA PIHAK selambat-lambatnya 7 (tujuh) hari sebelum berakhirnya
                perjanjian ini merupakan bagian yang tidak terpisahkan dari perjanjian ini.</li>
        </ol>
        <pagebreak />
        <h3 style="text-align: center;">PASAL II</h3>
        <h3 style="text-align: center;">SEWA MENYEWA DAN LOKASI PEMAKAIAN</h3>
        <ol>
            <li>PIHAK PERTAMA dan PIHAK KEDUA telah sepakat bahwa nilai kontrak sewa alat berat merk {{ $data->produk->nama }} berdasarkan sewa pemakaian {{ $data->lama }} jam atau selama 30 hari.</li>
            <li>PIHAK PERTAMA dan PIHAK KEDUA telah sepakat bahwa harga kontrak sewa alat berat dibayar berdasarkan
                sewa pemakaian {{ $data->lama }} jam selama 30 hari PIHAK KEDUA dengan rincian sebagai berikut :
            
            </li>
        </ol>
        <table class="table2">
            <tbody>
                <tr>
                    <td style="width: 32px;">NO</td>
                    <td style="width: 85.2656px;">Nama Alat</td>
                    <td style="width: 85.2656px;">Jumlah Alat</td>
                    <td style="width: 86px;">Masa Kontrak</td>
                    <td style="width: 86px;">Harga Unit</td>
                    <td style="width: 86px;">Harga Operator</td>
                    <td style="width: 86px;">Total</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>{{ $data->produk->nama }}</td>
                    <td>{{ $data->qty }}</td>
                    <td>{{ $data->lama }} Jam</td>
                    <td>Rp {{ number_format($data->harga_unit,0,',','.') }}</td>
                    <td>Rp {{ number_format($data->harga_operator,0,',','.') }}</td>
                    <td>Rp {{ number_format($data->total,0,',','.') }}</td>
                </tr>
            </tbody>
        </table>
        <br/>
        <ol start="3">
            <li>Komponen dan perhitungan biaya sewa ALAT BERAT tersebut yang harus dibayarkan oleh PIHAK KEDUA
                kepada PIHAK PERTAMA adalah sebagai berikut :
                <ol style="list-style-type: lower-alpha;">
                    <li>Biaya sewa alat berat, Komponennya terdiri dari :
                        <ul>
                            <li>Biaya sewa alat berat </li>
                            <li>Biaya Maintanance</li>
                            <li>Upah dan gaji dasar operator</li>
                        </ul>
                    </li>
                    <li>Minimum {{ $data->lama }} jam kerja per unit untuk ALAT BERAT, dan jika pemakaian alat berat melebihi {{ $data->lama }} jam maka
                        pihak pertama menagihkan jumlah kelebihan hari kerja.</li>
                    <li>Insentif,bonus dan biaya kerja lembur
                        operator diperhitungkan lain dan tidak termasuk komponen biaya sewa alat berat, dan diatur lansung
                        dilokasi bersama operator tanpa perlu melibatkan pemilik alat berat (pihak pertama)</li>
                </ol>
            </li>
            <li>Pihak kedua akan mengoperasikan alat berat yang disewa dari PIHAK PERTAMA dilokasi proyek
                penambangan PIHAK KEDUA di lokasi PENAMBANGAN IUP CINTA JAYA DESA TAPUNGGAYA KECAMATAN MOLAWE KAB
                KONUT</li>
        </ol>

        <h3 style="text-align: center;">Pasal III</h3>
        <h3 style="text-align: center;">SYARAT PEMBAYARAN</h3>
        <ol>
            <li style="text-align: left;">Pihak Kedua melakukan pembayaran muka (Down Payment) sebelum alat
                diberangkatkan.</li>
            <li style="text-align: left;">Tagihan/Invoice pemakaian alat berat setiap bulan dilakukan sesuai tanggal
                serah terima unit atau sesuai tanggal ditandatanganinya kontrak.</li>
            <li style="text-align: left;">Pembayaran dilakukan oleh PIHAK KEDUA dengan cara transfer ke rekening PIHAK
                PERTAMA Atas nama : ISBAR WAHYU ALFARIZY Bank : BRI No Rek 493201022630533</li>
        </ol>
        <h3 style="text-align: center;">Pasal IV</h3>
        <h3 style="text-align: center;">Biaya Mobilisasi dan Demobilisasi</h3>
        <ol>
            <li>Biaya Mobilisasi dan Demobilisasi ditanggung oleh PIHAK KEDUA baik dari pengambilan alat hingga
                pengembalian alat dan harus disetujui oleh PIHAK PERTAMA.</li>
            <li>Biaya Mobilisasi dan Demobilisasi dibayar dimuka sebelum alat berada diatas tronton.</li>
        </ol>
        <h3 style="text-align: center;">Pasal V</h3>
        <h3 style="text-align: center;">Biaya Operasi, Biaya Pemeliharaan dan Biaya Perbaikan Alat</h3>
        <ol>
            <li>Selama masa penyewan alat berat, keperluan oli, perbaikan kerusakan, pengantian spare dan mekanik
                menjadi tanggung jawab PIHAK PERTAMA.</li>
            <li>Pemakaian BBM (Bahan Bakar Minyak) solar untuk keperluan operasi menjadi tanggung jawab PIHAK KEDUA. Dan
                harus disiapkan sesuai dengan kerja alat seharinya. Dan apabila tidak mencukupi maka PIHAK PERTAMA
                meminta diisi kembali sesuai permintaan wajar.</li>
        </ol>
        <p style="text-align: center;">Operasi dan Helper Operator</p>
        <ol>
            <li>Operator dan Helper Operator menjadi tanggung jawab pihak pertama</li>
            <li>Kebutuhan Operator dan Helper Makan, Minum @ 3 x sehari bagi, Tempat tinggal menjadi tanggung jawab
                pihak kedua</li>
        </ol>
        <h3 style="text-align: center;">Pasal VII</h3>
        <h3 style="text-align: center;">Laporan Operasi Alat (Time Sheet)</h3>
        <ol>
            <li style="text-align: left;">Laporan harian operasi alat dibuat oleh operator dan ditanda tangani oleh
                Pengawas Kerja dari Pihak Kedua atau atas nama penyewa alat.</li>
            <li style="text-align: left;">Apabila alat standby (tidak bekerja) disebabkan karena lokasi becek, tidak ada
                solar ataupun libur tanpa pemberitahuan kepada pihak pertama maka dihitung 1 hari kerja</li>
            <li style="text-align: left;">Apabila dari point 2 dan 3 dari pihak kedua mengoperasikan alat yang mana
                minimal jam cash telah masuk 4 jam maka pemakaian dihitung jam cash ditambah jam kerja yang digunakan.
            </li>
            <li style="text-align: left;">Apabilah kerja alat telah mencapai 30 hari dan Hm alat belum mencapai 200 maka
                kontrak dianggap telah selesai.</li>
            <li style="text-align: left;">Jika terjadi kerusakan alat dimasa kontrak maka PIHAK PERTAMA wajib melakukan
                penggantian hari sebanyak hari kerusakan alat yang dilaporkan oleh Operator dan disepakati oleh PIHAK
                KEDUA.</li>
            <li style="text-align: left;">Jika dalam masa kontrak terjadi penyegelan/Penyitaan Alat Pihak Pertama oleh
                pihak Kepolisian dikarenakan Lahan Bermasalah ataupun hal lain yang dianggap melanggar hukum,maka Pihak
                Kedua Bertanggung Jawab dalam pembebasan Alat Tampa melibatkan Pihak Kedua dan Pihak Pertama Wajib
                Membayar Biaya Parkir sesuai Kontrak selama proses hukum</li>
        </ol>

        <h3 style="text-align: center;">Pasal VIII</h3>
        <h3 style="text-align: center;">Keamanan Alat Berat</h3>
        <ol>
            <li style="text-align: left;">Pihak kedua wajib untuk menyediakan security untuk menjaga keamanan alat
                dilokasi kerja.</li>
            <li style="text-align: left;">Pihak kedua wajib membayar ganti rugi terhadap unit kerja jika terjadi
                pencurian dan perusakan dalam bentuk apapun yang dilakukan secara sengaja maupun tidak sengaja oleh
                pihak ketiga.</li>
            <li style="text-align: left;">Apabila alat tenggelam, mengalami kecelakaan pada saat mobilisasi,
                demobilisasi dan dilokasi kerja maka biaya yang timbul akibat hal tersebut akan menjadi tanggungan Pihak
                Kedua</li>
        </ol>
        <h3 style="text-align: center;">Pasal IX</h3>
        <h3 style="text-align: center;">Masa Perjanjian</h3>
        <ol>
            <li>Perjanjian ini berlaku sejak ditanda tangani oleh kedua belah pihak hingga alat selesai bekerja sesuai
                dana diterima per-bulan</li>
            <li>Dan perjanjian sewa akan diperpanjang kembali jika ada kesepakatan oleh kedua belah pihak baik
                pembayaran maupun hal lainnya.</li>
            <li>Perjanjian kontrak lama tetap berlaku apabila ada tambahan perpanjangan jam alat terkecuali ada item
                yang akan berubah dengan sendirinya seperti masalah mobilisasi alat.</li>
        </ol>
        <h3 style="text-align: center;">Pasal X</h3>
        <h3 style="text-align: center;">Pemindahan, Pengambilan dan Pengunaan Alat</h3>
        <ol>
            <li>Alat tidak boleh dipindahkan oleh pihak kedua sebelum masa perjanjian belum habis kecuali ada
                persetujuan dari pihak pertama.</li>
            <li>Apabila pihak kedua akan menggunakan alat kelokasi diluar dari perjanjian sedang masa alat belum habis
                maka pihak kedua harus memberitahukan kepada pihak pertama sebelumnya.</li>
            <li>Apabila pihak pertama memerlukan alat untuk dipakai kelokasi lain diluar dari lokasi perjanjian maka
                semua biaya dan jam kerja menjadi tanggung jawab PIHAK PERTAMA dan PIHAK PERTAMA pun tidak akan
                membebankan kepada PIHAK KEDUA atas pemakaian alat tersebut. Dan PIHAK PERTAMA akan meminta ijin
                tertulis sebelumnya kepada pihak kedua bahwa alat mau dipakai kelokasi lain.</li>
            <li>Apabila masa kerja alat belum habis dari masa perjanjian maka pihak kedua harus mencari jalan solusinya
                dan apabila tidak ada jalan solusinya dari pihak kedua maka pihak pertama akan memberlakukan cash charge
                / harinya minimal 4 jam hingga jam perjanjian mencapai target yang telah disepakati bersama.</li>
            <li>Tidak dibenarkan apabila pihak kedua merentalkan kembali alat pihak pertama kepada pihak lain dan
                apabila terdapat hal tersebut maka perjanjian akan putus dengan sendirinya dan semua biaya menjadi
                tanggung jawab pihak kedua kepada pihak pemakai dan pihak pertama akan menarik alat dari lokasi pihak
                kedua tanpa pemberitahuan apapun dan semua pembayaran tidak dapat ditarik oleh pihak kedua kepada pihak
                pertama.</li>
        </ol>
        <h3 style="text-align: center;">Pasal XI</h3>
        <h3 style="text-align: center;">Perselisihan</h3>
        <ol>
            <li>Jika timbul perselisihan antara pihak pertama dengan pihak kedua maka sebisa mungkin akan diselesikan
                secara musyawarah dan kekeluargaan.</li>
            <li>Apabila perselisihan tidak bisa diselesaikan secara musyawarah maka kedua belah pihak sepakat untuk
                menyelesaikan masalah tersebut di secara hukum yang berlaku.</li>
            <li>Apabila terjadi kesalahpahaman diluar dari perjanjian maka pihak kedua dianggap lalai dan tidak memahami
                isi dari perjanjian konrak dan pihak pertama tetap berpedoman pada kontrak dalam menyelesaikan masalah.
            </li>
        </ol>
        <h3 style="text-align: center;">Pasal XII</h3>
        <h3 style="text-align: center;">Penutup</h3>
        <p>Demikian surat perjanjian sewa pakai alat berat ini ditanda tangani oleh kedua belah pihak dalam rangkap 2
            (dua) bermatrai cukup dan berkekuatan hukum yang sama dan di buat tanpa paksaan serta tekanan dari pihak
            manapun.</p>

        <p style="text-align: right">Kendari, {{ \Carbon\Carbon::today()->translatedFormat('d F Y') }}</p>
    
        <br/>
        <table class="table2">
            <tr>
                <td width="30%" style="text-align: center">
                    Pihak Pertama
                </td>
                <td width="30%" style="text-align: center">
                    Pihak Kedua
                </td>
            </tr>
            <tr>
                <td>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </td>
                <td width="40%" style="text-align: right">
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </td>
            </tr>
            <tr>
                <td width="40%" style="text-align: center">
                    <p style="font-weight:bold;text-decoration:underline;font-size:12pt">MUHAMMAD IKSAN NUR</p>
                    <p>Direktur Cv. Workproduktif Aapmin</p>
                </td>
                <td width="40%" style="text-align: center">
                    <p style="font-weight:bold;text-decoration:underline;font-size:12pt">{{ $data->user->nama }}</p>
                    <p>{{ $data->user->jabatan }} {{ $data->user->perusahaan ?? '-' }}</p>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>