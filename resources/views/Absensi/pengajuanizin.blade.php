@extends('Layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Pengajuan Data Izin
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
                            <div class="row mb-2">
                                <div class="col-12">
                                    <form action="/absensi/pengajuanizin" method="get" autocomplete="off">
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    
                                                    <input type="text" name="dari" id="dari" class="form-control"
                                                        placeholder="Dari" value="{{Request('dari')}}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" name="sampai" id="sampai" class="form-control"
                                                        placeholder="Sampai" value="{{Request('sampai')}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <input type="text" name="kode_karyawan" id="kode_karyawan" class="form-control"
                                                        placeholder="Kode Karyawan" value="{{Request('kode_karyawan')}}">
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                                                        placeholder="Nama Karyawan" value="{{Request('nama_lengkap')}}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <select name="status_approved" id="status_approved" class="form-select">
                                                        <option value="">Pilih Status</option>
                                                        <option value="0" {{Request('status_approved') === '0' ? 'selected' :''}}>Pending</option>
                                                        <option value="1" {{Request('status_approved') == 1 ? 'selected':''}}>Disetujui</option>
                                                        <option value="2" {{Request('status_approved') == 2 ? 'selected':''}}>Ditolak</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                            <path d="M21 21l-6 -6" />
                                                        </svg>
                                                        Cari Data
    
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <table class="table  table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Karyawan</th>
                                        <th>Tanggal Izin</th>
                                        <th>Nama Karyawan</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Status Approved</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($izinsakit as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->kode_karyawan }}</td>
                                            <td>{{ date('d-m-Y', strtotime($d->tgl_izin)) }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ $d->jabatan }}</td>
                                            <td>{{ $d->status == 'i' ? 'Izin' : 'Sakit' }}</td>
                                            <td>{{ $d->keterangan }}</td>
                                            <td>
                                                @if ($d->status_approved == 1)
                                                    <span class="badge bg-primary text-white text-small">Di Setujui</span>
                                                @elseif ($d->status_approved == 2)
                                                    <span class="badge bg-danger text-white text-small">Di Tolak</span>
                                                @else
                                                    <span class="badge bg-success text-white text-small">Di Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->status_approved == 0)
                                                    <a href="#" id="approved" id_izinsakit="{{ $d->id }}"
                                                        class="btn btn-info btn-sm">Setujui</a>
                                                @else
                                                    <a href="/absensi/{{ $d->id }}/batalizinsakit"
                                                        class="btn btn-warning btn-sm">Batalkan</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $izinsakit->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- MODEL PENGAJUAN IZIN --}}
    <div class="modal modal-blur fade" id="modal-izinsakit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Izin Sakit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/absensi/approvedizinsakit/" method="POST">
                        @csrf
                        <input type="hidden" id="id_izinsakit_form" name="id_izinsakit_form">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="status_approved" id="status_approved" class="form-select">
                                        <option value="1">Di Setujui</option>
                                        <option value="2">Di Tolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {
            $("#approved").click(function(e) {
                e.preventDefault();
                var id_izinsakit = $(this).attr("id_izinsakit");
                $("#id_izinsakit_form").val(id_izinsakit);
                $("#modal-izinsakit").modal("show");
            });

            $("#dari,#sampai").datepicker({
                autoclose: true,
                todayHighlight: true,
                format:'yyyy-mm-dd'
            });

        });
    </script>
@endpush
