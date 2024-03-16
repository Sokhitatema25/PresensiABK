<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        #title {
            font-family: 'Times New Roman', Times, serif;
            font-size: 16px;
            font-weight: bold;
        }

        .container {
            text-align: center;
        }

        .tabelkaryawan {
            margin-top: 40px;
            /* margin-left: 120px */
        }

        .tablepresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;


        }

        .tablepresensi tr th {
            border: 2px solid #968c8c;
            padding: 5px;
        }

        .tablepresensi tr td {
            border: 2px solid #968c8c;
            padding: 5px;
            font-size: 12px
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">
    @php
        function selisih($jam_masuk, $jam_keluar)
        {
            [$h, $m, $s] = explode(':', $jam_masuk);
            $dtAwal = mktime($h, $m, $s, '1', '1', '1');
            [$h, $m, $s] = explode(':', $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode('.', $totalmenit / 60);
            $sisamenit = $totalmenit / 60 - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ':' . round($sisamenit2);
        }
    @endphp
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">
        <table style="width: 100%">
            <tr>
                <td style="width: 20px">
                    <img src="{{ asset('assets/img/logoABK.png') }}" alt="" width="70">
                </td>
                <td>
                    <div class="container">
                        <span id="title">
                            LAPORAN PRESENSI PT. ANUGERAH BINA KARYA PERIODE {{ strtoupper($namabulan[$bulan]) }}
                            {{ $tahun }}
                        </span>
                        <br>
                        <span class="lokasi"><i>Jln. Bandengan Selatan No. 43, Blok I No. 31 Jakarta Utara</i></span>
                    </div>
                </td>
            </tr>

        </table>

        <table class="tabelkaryawan">
            <td rowspan="6">
                @php
                    $path = Storage::url('uploads/Profil/' . $karyawan->foto);
                @endphp
                <img src="{{ url($path) }}" alt="" style="width: 100px; border: 5px">
            </td>
            <tr>
                <td>Kode Karyawan</td>
                <td>:</td>
                <td>{{ $karyawan->kode_karyawan }}</td>
            </tr>

            <tr>
                <td>Nama Karyawan</td>
                <td>:</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td>:</td>
                <td>{{ $karyawan->nama_deprt }}</td>
            </tr>
            <tr>
                <td>Telpon</td>
                <td>:</td>
                <td>{{ $karyawan->no_telp }}</td>
            </tr>
        </table>
        <table class="tablepresensi">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
                <th>Jam Pulang</th>
                <th>Foto</th>
                <th>Ket</th>
                <th>Total Jam</th>
            </tr>
            @foreach ($presensi as $d)
                @php
                    $path_in = Storage::url('uploads/absensi/' . $d->foto_masuk);
                    $path_out = Storage::url('uploads/absensi/' . $d->foto_keluar);
                    $jamterlambat = selisih('07:00:00', $d->jam_masuk);
                @endphp

                <tr class="tabledata">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d-m-Y', strtotime($d->tgl_absensi)) }}</td>
                    <td>{{ $d->jam_masuk }}</td>
                    <td>
                        <img src="{{ url($path_in) }}" alt="" style="width: 50px;">
                    </td>
                    <td>{{ $d->jam_keluar != null ? $d->jam_keluar : 'Belum Absen' }}</td>
                    <td>
                        @if ($d->foto_keluar != null)
                            <img src="{{ url($path_out) }}" alt="" style="width: 50px;">
                        @else
                            <img src="{{ asset('assets/img/nophoto.jpeg') }}" alt="" style="width: 50px;">
                        @endif

                    </td>
                    <td>
                        @if ($d->jam_masuk > '07:00')
                            <p>Terlambat {{ $jamterlambat}}</p>
                        @else
                            Tepat Waktu
                        @endif
                    </td>

                    <td>
                        @if ($d->jam_keluar != null )
                        @php
                            $jmlkerja = selisih($d->jam_masuk,$d->jam_keluar)
                        @endphp
                        @else
                        @php
                            $jmlkerja =0
                        @endphp
                        
                        @endif
                    {{$jmlkerja}}
                    </td>

                </tr>
            @endforeach
        </table>

        <table width="95%" style="margin-top: 100px">
            <tr>
                <td  colspan="2" style="text-align: right;"> Jakarta Utara {{date("d-m-Y")}}</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align: bottom" height="100px">
                    <u>Muhhad Edison</u><br>
                    <i>
                        <b>Manager</b>
                    </i>
                </td>

                <td style="text-align: right; vertical-align: bottom">
                    <u>Karyono Kanedy</u><br>
                    <i>
                        <b>Direktur</b>
                    </i>
                </td>


            </tr>

        </table>



        <!-- Write HTML just like a web page -->
        <article>

        </article>

    </section>

</body>

</html>
