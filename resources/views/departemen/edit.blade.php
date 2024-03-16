

<form action="/departemen/{{$departemen->kode_deprt}}/update" method="POST" id="frmdepartemen">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">Kode Departemen</label>
                <input type="text" class="form-control" readonly value="{{$departemen->kode_deprt}}" id="kode_deprt" name="kode_deprt"
                    placeholder="Kode Departemen">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">Nama Departemen</label>
                <input type="text" class="form-control" value="{{$departemen->nama_deprt}}" id="nama_deprt" name="nama_deprt"
                    placeholder="Nama Departemen">
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