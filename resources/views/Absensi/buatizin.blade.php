@extends('layouts.absensi')
@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <style>
        .datepicker-modal {
            max-height: 430px !important;
        }

        .datepicker-date-display {
            background-color: #228B22 !important;
        }
    </style>
    <!-- App Header -->
    <div class="appHeader bg-success text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Izin / Sakit</div>
        <div class="right"></div>
    </div>
@endsection


@section('content')
    <div class="fab-button bottom-right" style="margin-bottom: 70px">
        <a href="/Absensi/izin" class="fab">
            <ion-icon name="arrow-undo-circle-sharp"></ion-icon>
        </a>
    </div>
    <div class="row" style="margin-top: 70px;">
        <div class="col">
            <form action="/Absensi/storeizin" method="POST" id="frmizin">
                @csrf
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" style="padding: 12px 12px !important; line-height: 0.8rem;">

                            <div class="form-group">
                                <label for="" class="mb-2"> Tanggal</label>
                                <input type="text" class="form-control datepicker" name="tgl_izin" id="tgl_izin"
                                    placeholder="Masukan Tanggal">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="" class="mb-2"> Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="i">Izin / Sakit</option>
                                            <option value="i">Izin</option>
                                            <option value="s">Sakit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="" class="mb-2"> Keterangan</label>
                                        <textarea name="keterangan" class="form-control" rows="5" id="keterangan"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">

                                        <button id="" class="btn btn-primary rounded">Kirim Data
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd"
            });

            $("#tgl_izin").change(function(e) {
                var tgl_izin = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: '/Absensi/cekpengajuanizin',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tgl_izin: tgl_izin,

                    },
                    cache: false,
                    success: function(respond) {
                        if (respond == 1) {
                            Swal.fire({
                                title: 'Oops!',
                                text: 'Tidak Boleh Melakukan 2 X Pengajuan Izi di Tanggal Yang Sama',
                                icon: 'warning',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                $("#tgl_izin").val("");
                            });
                        }
                    }
                });
            });

            $("#frmizin").submit(function() {

                var tgl_izin = $("#tgl_izin").val();
                var status = $("#status").val();
                var keterangan = $("#keterangan").val();
                if (tgl_izin == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Tanggal Wajib Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                } else if (status == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Status Wajib Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                } else if (keterangan == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Keterangan Wajib Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                }
            });
        });
    </script>
@endpush
