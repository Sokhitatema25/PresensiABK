@extends('layouts.absensi')
@section('content')
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar">
                @if (!empty(Auth::guard('tbl_karyawan')->user()->foto))
                    @php
                       $path = Storage::url('uploads/karyawan/' . Auth::guard('tbl_karyawan')->user()->foto);
                    @endphp
                     <img src="{{url($path)}}" alt="avatar" class="imaged w64 rounded">
                @else
                <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                @endif
  
            </div>
            <div id="user-info">
                <h2 id="user-name">{{Auth::guard('tbl_karyawan')->user()->nama_lengkap}}</h2>
                <span id="user-role">{{Auth::guard('tbl_karyawan')->user()->jabatan}}</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/editprofile" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/Absensi/izin" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Izin / Sakit</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/Absensi/history" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($absensihariini != null)
                                        @php
                                            $path = Storage::url('uploads/absensi/' . $absensihariini->foto_masuk);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w48">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $absensihariini != null ? $absensihariini->jam_masuk : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($absensihariini != null && $absensihariini->jam_keluar != null)
                                        @php
                                            $path = Storage::url('uploads/absensi/' . $absensihariini->foto_keluar);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w48">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif

                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{ $absensihariini != null && $absensihariini->jam_keluar != null ? $absensihariini->jam_keluar : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="" id="rekappresensi">
            <h4 class="mt-2">Rekap Absensi Bulan <span class="">{{ $namabulan[$bulanini] }}</span> Tahun
                {{ $tahunini }}</h3>
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                                <span class=" badge bg-primary "
                                    style="position: absolute; top:3px; right:10px; font-size: 0.6rem; z-index:999">
                                    {{ $rekappresensi->jmlhadir }}
                                </span>
                                <ion-icon style="font-size: 1.6rem" class="text-primary mr-1"
                                    name="id-card-outline"></ion-icon>
                                <span style="font-size: 20px">Absen</span>
                            </div>
                        </div>
                    </div>


                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                                <span class=" badge bg-warning "
                                    style="position: absolute; top:3px; right:10px; font-size: 0.6rem; z-index:999">
                                    {{ $rekapizin->jmlizin }}
                                </span>
                                <ion-icon style="font-size: 1.6rem" class="text-warning mr-1"
                                    name="hand-right-outline"></ion-icon>
                                <span style="font-size: 20px">Izin</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                                <span class=" badge bg-danger "
                                    style="position: absolute; top:3px; right:10px; font-size: 0.6rem; z-index:999">
                                    {{ $rekapizin->jmlsakit }}
                                </span>
                                <ion-icon style="font-size: 1.6rem" class="text-danger mr-1"
                                    name="medkit-outline"></ion-icon>
                                <span style="font-size: 20px">Sakit</span>
                            </div>
                        </div>
                    </div>


                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center"
                                style="padding: 12px 12px !important; line-height: 0.8rem;">
                                <span class=" badge bg-success "
                                    style="position: absolute; top:3px; right:10px; font-size: 0.6rem; z-index:999">
                                    {{ $rekappresensi->jmlterlambat }}
                                </span>
                                <ion-icon style="font-size: 1.6rem" class="text-success mr-1"
                                    name="bicycle-sharp"></ion-icon>
                                <span style="font-size: 20px">Telat</span>
                            </div>
                        </div>
                    </div>

                </div>
        </div>





        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">

                        @foreach ($historibulanini as $d)
                            @php
                                $path = Storage::url('uploads/absensi/' . $d->foto_masuk);
                            @endphp
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="finger-print-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div class="badge badge-success">{{ date('d-m-Y', strtotime($d->tgl_absensi)) }}
                                        </div>
                                        <div class="">
                                            <span class="badge badge-warning">Jam Masuk {{ $d->jam_masuk }}</span>
                                            <span class="badge badge-danger">Jam Pulang
                                                {{ $absensihariini != null && $d->jam_keluar != null ? $d->jam_keluar : 'Belum Absen' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>



                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($leaderboard as $d)
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <b>{{$d->nama_lengkap}}</b>
                                        <small class="text-muted"> Jabatan: {{$d->jabatan}}</small>
                                        <span class="badge badge-warning {{$d->jam_masuk < "07:00" ? "bg-warning" : "bg-danger"}}">
                                            Jam Masuk: {{$d->jam_masuk}}
                                        </span>

                                        
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
