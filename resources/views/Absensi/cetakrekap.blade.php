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
            font-size: 12px;

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

<body class="A4 landscape">
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
                            REKAP PRESENSI PT. ANUGERAH BINA KARYA PERIODE {{ strtoupper($namabulan[$bulan]) }}
                            {{ $tahun }}
                        </span>
                        <br>
                        <span class="lokasi"><i>Jln. Bandengan Selatan No. 43, Blok I No. 31 Jakarta Utara</i></span>
                    </div>
                </td>
            </tr>
        </table>

        <table class="tablepresensi">
            <tr>
                <th rowspan="2">Kode Karyawan</th>
                <th rowspan="2">Nama Karyawan</th>
                <th colspan="31">Waktu Dan Tanggal Presensi</th>
                <th rowspan="2">Hadir</th>
                <th rowspan="2">Telat</th>
            </tr>
            <tr>
                <?php
                for ($i=1; $i<=31; $i++){
                    ?>
                <th>{{ $i }}</th>
                <?php
                }
                ?>
            </tr>
            @foreach ($rekap as $d)
                <tr>
                    <td>{{ $d->kode_karyawan }}</td>
                    <td>{{ $d->nama_lengkap }}</td>
                    <?php
                    $totalhadir = 0;
                    $totalterlambat = 0;
                    for ($i=1; $i<=31; $i++){
                        $tgl = "tgl_".$i;
                        if(empty($d->$tgl)){
                            $hadir = ['', ''];
                            $totalhadir +=0;
                            $totalterlambat  +=0;
                        }else{
                            $hadir = explode("-", $d->$tgl);
                            $totalhadir +=1;
                            if($hadir[0] > "07:00:00"){
                                $totalterlambat  +=1;
                            }                            
                        }
                        ?>
                    <td>
                        <span style="color:{{ $hadir[0] > '07:00:00' ? ' red' : ""}}">{{ $hadir[0] }}</span>
                        <span style="color:{{ $hadir[1] < '16:00:00' ? ' red' : ""}}">{{ $hadir[1] }}</span>
                    </td>
                    <?php
                    }
                    ?>
                     <td>{{$totalhadir}}</td>
                     <td>{{$totalterlambat}}</td>
                </tr>
            @endforeach
        </table>



        <table width="95%" style="margin-top: 100px">
            <tr>
                <td colspan="2" style="text-align: right;"> Jakarta Utara {{ date('d-m-Y') }}</td>
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
    </section>

</body>

</html>
