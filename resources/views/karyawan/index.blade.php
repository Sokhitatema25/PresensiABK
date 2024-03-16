@extends('Layouts.admin.tabler')

@section('content')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Data Karyawan
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
                                <a href="#" id="btntambahkaryawan" class="btn btn-primary"> <svg
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
                                <form action="/karyawan" method="GET">

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" name="nama_karyawan" id="nama_karyawan"
                                                    class="form-control" placeholder="Cari Data"
                                                    value="{{ Request('nama_karyawan') }}">
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <select name="kode_deprt" id="kode_deprt" class="form-select">
                                                    <option value="">Departemen</option>
                                                    @foreach ($departemen as $d)
                                                        <option
                                                            {{ Request('kode_deprt') == $d->kode_deprt ? 'selected' : '' }}
                                                            value="{{ $d->kode_deprt }}">{{ $d->nama_deprt }}</option>
                                                    @endforeach
                                                </select>
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
                                            <th>Kode karyawan</th>
                                            <th>Name</th>
                                            <th>Jabatan</th>
                                            <th>No Telpon</th>
                                            <th>Departemen</th>
                                            <th>Foto</th>

                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($karyawan as $d)
                                            @php
                                                $path = Storage::url('uploads/Profil/' . $d->foto);
                                            @endphp
                                            <tr>
                                                {{-- <td>{{ $loop->iteration}}</td> --}}
                                                <td>{{ $loop->iteration + $karyawan->firstItem() - 1 }}</td>
                                                <td>{{ $d->kode_karyawan }}</td>
                                                <td>{{ $d->nama_lengkap }}</td>
                                                <td>{{ $d->jabatan }}</td>
                                                <td>{{ $d->no_telp }}</td>
                                                <td>{{ $d->nama_deprt }}</td>
                                                <td>
                                                    @if (empty($d->foto))
                                                        <img src="{{ asset('assets/img/nophoto.jpeg') }}" class="avatar"
                                                            alt="">
                                                    @else
                                                        <img src="{{ url($path) }}" class="avatar" alt="">
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#" class="edit btn btn-success"
                                                            kode_karyawan="{{ $d->kode_karyawan }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="32" height="32" viewBox="0 0 24 24" stroke-width="2.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                                <path d="M13.5 6.5l4 4" />
                                                                <path d="M16 19h6" />
                                                              </svg>
                                                        </a>


                                                        <form action="/karyawan/{{ $d->kode_karyawan }}/delete" method="POST"
                                                            style="margin-left: 5px">
                                                            @csrf
                                                         
                                                            <a class="btn btn-danger  delete-confirm">
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
                                <div class="mt-4">
                                    {{ $karyawan->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                            {{-- {!! $karyawan->links('pagination::bootstrap-5') !!} --}}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- MODEL TAMBAH ADATA --}}

    <div class="modal modal-blur fade" id="modal-inputkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/karyawan/store" method="POST" id="frmkaryawan" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Kode Karyawan</label>
                                    <input type="text" class="form-control" id="kode_karyawan" name="kode_karyawan"
                                        placeholder="Kode Karayawan">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                        placeholder="Nama Karayawan">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan"
                                        placeholder="Jabatan">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">No. Telpon</label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp"
                                        placeholder="No Telp">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Departemen</label>
                                    <select name="kode_deprt" id="kode_deprt" class="form-select">
                                        <option value="">Departemen</option>
                                        @foreach ($departemen as $d)
                                            <option {{ Request('kode_deprt') == $d->kode_deprt ? 'selected' : '' }}
                                                value="{{ $d->kode_deprt }}">{{ $d->nama_deprt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <input type="file" class="form-control" name="foto">
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

    {{-- MODEL EDIT ADATA --}}
    <div class="modal modal-blur fade" id="modal-editkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Karyawan</h5>
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
            $("#btntambahkaryawan").click(function() {
                $("#modal-inputkaryawan").modal("show");
            });

            $(".edit").click(function() {
                var kode_karyawan = $(this).attr('kode_karyawan');
                $.ajax({
                    type: 'POST',
                    url: '/karyawan/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_karyawan: kode_karyawan
                    },
                    success: function(respond) {
                        $("#loadededitform").html(respond);
                    }

                });

                $("#modal-editkaryawan").modal("show");
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
