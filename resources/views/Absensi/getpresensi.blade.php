@php    
function selisih($jam_masuk, $jam_keluar)
        {
            list($h, $m, $s) = explode(":", $jam_masuk);
            $dtAwal = mktime($h, $m, $s, "1", "1", "1");
            list($h, $m, $s) = explode(":", $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode(".", $totalmenit / 60);
            $sisamenit = ($totalmenit / 60) - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ":" . round($sisamenit2);
        }
@endphp
@foreach ($presensi as $d)
    @php
        $foto_masuk = Storage::url('uploads/absensi/' . $d->foto_masuk);
        $foto_keluar = Storage::url('uploads/absensi/' . $d->foto_keluar);
    @endphp
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $d->kode_karyawan }}</td>
        <td>{{ $d->nama_lengkap }}</td>
        <td>{{ $d->nama_deprt }}</td>
        <td>{{ $d->jam_masuk }}</td>
        <td>
            <img src="{{ url($foto_masuk) }}" class="avatar" alt="">
        </td>
        <td>{!! $d->jam_keluar != null
            ? $d->jam_keluar
            : '<span class="badge bg-danger text-white">Belum Absen</span>' !!}</td>

        <td>
            @if ($d->foto_keluar != null)
                <img src="{{ url($foto_keluar) }}" class="avatar" alt="">
            @else
                belum pulang
            @endif
        </td>
       
        <td>
            @if ($d->jam_masuk > '07:00')

            @php
                
               $jamterlambat = selisih('07:00:00', $d->jam_masuk);
            @endphp
            <span class="badge bg-danger text-white">Terlambat {{ $jamterlambat}}</span>
            @else
            <span class="badge bg-primary text-white">Tepat Waktu</span>
            @endif
        </td>
        <td>
            <a href="#" class="btn btn-success tampilkanpeta" id="{{$d->id}}">
                <i class="fa-solid fa-map-location"></i>
            </a>
        </td>
    </tr>
@endforeach

<script>
     $(function() {
            $(".tampilkanpeta").click(function(e) {
                var id = $(this).attr('id');
                $.ajax({
                    type: 'POST',
                    url: '/tampilkanpeta',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadmap").html(respond);
                    }
                });
                $("#modal-tampilkanpeta").modal("show");
            });
        })
</script>

