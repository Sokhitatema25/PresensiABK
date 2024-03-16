@extends('Layouts.admin.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Pengaturan Lokasi
                    </h2>
                </div>

            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-8">
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
                            <form action="/konfigurasi/updatelokasi" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label class="form-label mb-2">Lokasi Kantor</label>
                                                <input type="text" value="{{ $lok_kantor->lokasi_kantor }}"
                                                    class="form-control" id="lokasi_kantor" name="lokasi_kantor"
                                                    placeholder="Lokasi Kantor">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label class="form-label mb-2">Radius Kantor</label>
                                                <input type="text" value="{{ $lok_kantor->radius }}" class="form-control"
                                                    id="radius" name="radius" placeholder="Radius Kantor">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"
                                                    id="submit">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
