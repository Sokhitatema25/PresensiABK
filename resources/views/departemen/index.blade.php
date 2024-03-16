@extends('Layouts.admin.tabler')

@section('content')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Data Departemen
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <div class="row mb-2">
                            <div class="col-12">
                                @php
                                    $messagesuccess = Session::get('success');
                                    $messageerror = Session::get('warning');
                                @endphp
                                @if (Session::get('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ $messagesuccess }}</strong>

                                    </div>
                                @endif
                                @if (Session::get('warning'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ $messageerror }}</strong>

                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-12">
                                <a href="#" id="btntambahdepartemen" class="btn btn-primary"> <svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>Tambah Data</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <form action="/departemen" method="GET">

                                    <div class="row">
                                        <div class="col-10">
                                            <div class="form-group">
                                                <input type="text" name="nama_deprt" id="nama_deprt"
                                                    class="form-control" placeholder="Cari Data"
                                                    value="{{ Request('nama_deprt') }}">
                                            </div>
                                        </div>

                                      

                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                        <path d="M21 21l-6 -6" />
                                                    </svg>
                                                    Cari

                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Departemen</th>
                                            <th>Nama Departemen</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($departemen as $d )
                                          <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$d->kode_deprt}}</td>
                                            <td>{{$d->nama_deprt}}</td>
                                            <td>
                                                <div class="btn-group btn-sm">
                                                    <a href="#" class="edit btn btn-info"
                                                    kode_deprt="{{ $d->kode_deprt }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                        <path d="M16 5l3 3" />
                                                      </svg>
                                                    </a>
                                                    <form action="/departemen/{{ $d->kode_deprt }}/delete" method="POST"
                                                        style="margin-left: 5px">
                                                        @csrf
                                                     
                                                        <a class="btn btn-danger delete-confirm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor" />
                                                                <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor" />
                                                              </svg>
                                                        </a>
                                                    </form>
                                                </div>
                                            </td>
                                          </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- MODEL TAMBAH ADATA DEPARTEMEN--}}

    <div class="modal modal-blur fade" id="modal-inputdepartemen" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Departemen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/departemen/store" method="POST" id="frmdepartemen">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Kode Departemen</label>
                                    <input type="text" class="form-control" id="kode_deprt" name="kode_deprt"
                                        placeholder="Kode Departemen">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Nama Departemen</label>
                                    <input type="text" class="form-control" id="nama_deprt" name="nama_deprt"
                                        placeholder="Nama Departemen">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"
                                        id="submit">Simpan</button>
                                    <button type="button" class="btn btn-danger me-auto"
                                        data-bs-dismiss="modal">kembali</button>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MODEL EDIT ADATA DEPARTEMEN --}}
    <div class="modal modal-blur fade" id="modal-editdepartemen" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Departemen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadededitform">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {
            $("#btntambahdepartemen").click(function() {
                $("#modal-inputdepartemen").modal("show");
            });

            $(".edit").click(function() {
                var kode_deprt = $(this).attr('kode_deprt');
                $.ajax({
                    type: 'POST',
                    url: '/departemen/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_deprt: kode_deprt
                    },
                    success: function(respond) {
                        $("#loadededitform").html(respond);
                    }

                });

                $("#modal-editdepartemen").modal("show");
            });

            $(".delete-confirm").click(function(e) {
                var form = $(this).closest('form');
                e.preventDefault
                Swal.fire({
                    title: "Apakah Anda Yakin Menghapus ?",
                    text: "Data Ini Terhapus Secara Permanen !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus !"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            title: "Terhapus !",
                            text: "Data Ini Berhasil Dihapus",
                            icon: "success"
                        });
                    }
                });
            });




            $("#frmkaryawan").submit(function() {
                var kode_karyawan = $("#kode_karyawan").val();
                var nama_lengkap = $("#nama_lengkap").val();
                var jabatan = $("#jabatan").val();
                var no_telp = $("#no_telp").val();
                var kode_deprt = $("frmkaryawan").find("#kode_deprt").val();

                if (kode_karyawan == "") {
                    // alert("data harus diisi");
                    Swal.fire({
                        title: 'Maaf',
                        text: 'Kode Karyawan Wajib Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#kode_karyawan').focus();
                        //$("kode_karyawan").focus();
                    });
                    return false;
                } else if (nama_lengkap == "") {
                    Swal.fire({
                        title: 'Maaf',
                        text: 'Nama Lengkap Wajib Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#nama_lengkap').focus();
                    });
                    return false;
                } else if (jabatan == "") {
                    // alert("data harus diisi");
                    Swal.fire({
                        title: 'Maaf',
                        text: 'Jabatan Wajib Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#jabatan').focus();
                        //$("kode_karyawan").focus();
                    });
                    return false;
                } else if (no_telp == "") {
                    // alert("data harus diisi");
                    Swal.fire({
                        title: 'Maaf',
                        text: 'Nomor Telp Wajib Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#no_telp').focus();
                        //$("kode_karyawan").focus();
                    });
                    return false;
                } else if (kode_deprt == "") {
                    // alert("data harus diisi");
                    Swal.fire({
                        title: 'Maaf',
                        text: 'Kode Departemen Wajib Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#kode_deprt').focus();
                        //$("kode_karyawan").focus();
                    });
                    return false;
                }
            });


        });
    </script>
@endpush
