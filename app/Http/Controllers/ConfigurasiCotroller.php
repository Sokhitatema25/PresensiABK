<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class ConfigurasiCotroller extends Controller
{
   public function lokasikantor()
   {
    $lok_kantor = DB::table('konfig_lokasi')->where('id',1)->first();
    return view('konfigurasi.lokasikantor', compact('lok_kantor'));
   }
   public function updatelokasi(Request $request)
   {
    $lokasi_kantor = $request->lokasi_kantor;
    $radius = $request->radius;
    $update = Db::table('konfig_lokasi')->where('id',1)->update([
        'lokasi_kantor' => $lokasi_kantor,
        'radius' => $radius

    ]);
    if ($update) {

        return Redirect::back()->with(['success' => 'Update Data Berhasil di Simpan!']);
     }else{
        return Redirect::back()->with(['warning' => 'Data Gagal di Update!!']);
     }
   }
}
