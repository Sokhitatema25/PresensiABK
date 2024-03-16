
@if ($histori->isEmpty())
    <div class="col-12 mt-2">
        <div class="card">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> Histori Absensi Belum Ada!</strong> Silahkan Lakukan Absensi terlebih Dahulu untuk melihat
                histori ini.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>   
@endif

@foreach ($histori as $d)
    <div class="col-12">
        <div class="card">
            <ul class="listview image-listview">
                <li>
                    <div class="item">
                        @php
                            $path = Storage::url('uploads/absensi/' . $d->foto_masuk);
                        @endphp
                        <img src="{{ $path }}" alt="image" class="image">
                        <div class="in">
                            <b>{{ date('d-m-Y', strtotime($d->tgl_absensi)) }}</b>
                            <span
                                class="badge badge-warning {{ $d->jam_masuk < '07:00' ? 'bg-success' : 'bg-danger' }}">
                                Jam Masuk {{ $d->jam_masuk }}
                            </span>
                            <span class="badge badge-danger"> Jam Pulang {{ $d->jam_keluar }}</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    
@endforeach
