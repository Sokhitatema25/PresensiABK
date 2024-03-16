<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {

        $query = Karyawan::query();
        $query->select('tbl_karyawan.*', 'nama_deprt');
        $query->join('departemen', 'tbl_karyawan.kode_deprt', '=', 'departemen.kode_deprt')
            ->orderBy('nama_lengkap');
        if (!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }

        if (!empty($request->kode_deprt)) {
            $query->where('tbl_karyawan.kode_deprt', $request->kode_deprt);
        }
        $karyawan = $query->paginate(10);
        $departemen = DB::table('departemen')->get();
        return view('karyawan.index', compact('karyawan', 'departemen'));

    }

    // Tambah Data Karyawan
    public function store(Request $request)
    {
        $kode_karyawan = $request->kode_karyawan;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_telp = $request->no_telp;
        $kode_deprt = $request->kode_deprt;
        $password = Hash::make('12345');
       
        if ($request->hasFile('foto')) {
            $foto = $kode_karyawan . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }
        try {
            $data = [
                'kode_karyawan' => $kode_karyawan,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_telp' => $no_telp,
                'kode_deprt' => $kode_deprt,
                'foto' => $foto,
                'password' => $password
            ];
            $simpan = DB::table('tbl_karyawan')->insert($data);
            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/Profil/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Karyawan Berhasil Di Tambahkan']);
            }
        } catch (\Exception $e) {
            //dd($e);
       return Redirect::back()->with(['warning' => 'Data Karyawan Gagal Di Tambahkan']);
        }
    }
    public function edit(Request $request){
        $kode_karyawan = $request->kode_karyawan;

        
        $departemen = DB::table('departemen')->get();
        $karyawan = DB::table('tbl_karyawan')->where('kode_karyawan', $kode_karyawan)->first();
       
        return view('karyawan.edit',compact('departemen', 'karyawan'));
    }
    public function update($kode_karawan, Request $request)
    {
        $kode_karyawan = $request->kode_karyawan;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_telp = $request->no_telp;
        $kode_deprt = $request->kode_deprt;
        $password = Hash::make('12345');
        $old_foto = $request->old_foto;
        
        if ($request->hasFile('foto')) {
            $foto = $kode_karyawan . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto ;
        }
        try {
            $data = [
               
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_telp' => $no_telp,
                'kode_deprt' => $kode_deprt,
                'foto' => $foto,
                'password' => $password
            ];
            $update = DB::table('tbl_karyawan')->where('kode_karyawan', $kode_karyawan)->update($data);
            if ($update) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/Profil/";
                    $folderPathOld = "public/uploads/Profil/".$old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Karyawan Berhasil Di Edit']);
            }
        } catch (\Exception $e) {
            //dd($e);
       return Redirect::back()->with(['warning' => 'Data Karyawan Gagal Di Edit']);
        }
    }

    // UNTUK HAPUS DATA KARYAWAN 
    public function delete($kode_karyawan){
        $delete = DB::table('tbl_karyawan')->where('kode_karyawan', $kode_karyawan)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'Data Karyawan Berhasil Di Hapus']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Karyawan Gagal Di Hapus']);
        }
    }

}
