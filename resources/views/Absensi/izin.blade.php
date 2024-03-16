@extends('layouts.absensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-success text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin / Sakit</div>
        <div class="right"></div>
    </div>
@endsection
@section('content')
    <div class="col-12"class="fab-button bottom-right" style="margin-top: 70px">
        <div class="col">
            @php
                $messagesuccess = Session::get('success');
                $messageerror = Session::get('error');
            @endphp
            @if (Session::get('success'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>{{ $messagesuccess }}</strong> Jika Terjadi Kesalahan silahkan hubungi Admin
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ $messageerror }}</strong> Jika Terjadi Kesalahan silahkan hubungi Admin
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    
@foreach ($data_izin as $d)
<div class="col-12">
    <div class="card">
        <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="in">
                        <div class="">
                            <b>{{ date('d-m-Y', strtotime($d->tgl_izin)) }} ({{$d->status=="s"? "Sakit": "Izin"}})</b>
                            <small class="text-muted">{{$d->keterangan}}</small>

                            @if ($d->status_approved == 0)
                           
                            <span class="badge bg-warning">Proses Pending</span> 
                            @elseif($d->status_approved == 1)
                            <span class="badge bg-primary">Proses Pengajuan</span> 
                            @elseif($d->status_approved == 2)
                            <span class="badge bg-danger">Permintaan Anda Ditolak</span> 
                            @endif
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

@endforeach

    <div class="fab-button bottom-right" style="margin-bottom: 70px">
        <a href="/Absensi/buatizin" class="fab">
            <ion-icon name="add-circle"></ion-icon>
        </a>
    </div>
@endsection
