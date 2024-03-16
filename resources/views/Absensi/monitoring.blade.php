@extends('Layouts.admin.tabler')
@section('content')

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Monitoring Presensi
                    </h2>
                </div>

            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <p>Pilih Tanggal</p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control " value="{{date("Y-m-d")}}" id="tanggal" name="tanggal" autocomplete="off" placeholder="Masukan Tanggal">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="bg-secondary text-white text-center">
                                <td>No</td>
                                <td>Kode Karyawan</td>
                                <td>Nama</td>
                                <td>Departemen</td>
                                <td>Jam Masuk</td> 
                                <td>Foto</td>
                                <td>Jam Pulang</td>
                                <td>Foto</td>
                                <td>Keterangan</td>
                                <td>Maps</td>
                            </tr>
                        </thead>
                        <tbody id="loadpresensi">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

     {{-- MODEL TAMPILKAN PETA PRESENSI --}}
     <div class="modal modal-blur fade" id="modal-tampilkanpeta" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lokasi Presensi Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadmap">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {
            $("#tanggal").datepicker({
                autoclose: true,
                todayHighlight: true,
                format:'yyyy-mm-dd'
            });

            function loadpresensi(){
                var tanggal = $("#tanggal").val();
                $.ajax({
                    type: 'POST',
                    url: '/getabsensi',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadpresensi").html(respond);
                    }
                });
            }


            $("#tanggal").change(function(e){
                loadpresensi();
            });
            loadpresensi();
        });
    </script>
@endpush
