

<form action="/karyawan/{{$karyawan->kode_karyawan}}/update" method="POST" id="frmkaryawan" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">Kode Karyawan</label>
                <input type="text" class="form-control" readonly value="{{$karyawan->kode_karyawan}}" id="kode_karyawan" name="kode_karyawan"
                    placeholder="Kode Karayawan">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" value="{{$karyawan->nama_lengkap}}" id="nama_lengkap" name="nama_lengkap"
                    placeholder="Nama Karayawan">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input type="text" class="form-control" value="{{$karyawan->jabatan}}" id="jabatan" name="jabatan"
                    placeholder="Jabatan">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">No. Telpon</label>
                <input type="text" class="form-control" value="{{$karyawan->no_telp}}" id="no_telp" name="no_telp"
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
                        <option {{ $karyawan->kode_deprt == $d->kode_deprt ? 'selected' : '' }}
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
                <input type="hidden" name="old_foto" value="{{$karyawan->foto}}">
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="form-group">

                {{-- sampai menit ke 20 pass --}}
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"
                    id="submit">Simpan</button>
                <button type="button" class="btn btn-danger me-auto"
                    data-bs-dismiss="modal">kembali</button>
            </div>

        </div>

    </div>
</form>