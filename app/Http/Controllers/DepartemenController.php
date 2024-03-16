<?php

namespace App\Http\Controllers;
use App\Models\Departemen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $nama_deprt = $request->nama_deprt;
        $query = Departemen::query();
        $query->select('*');
        if (!empty($request->nama_deprt)) {
            $query->where('nama_deprt', 'like', '%' . $request->nama_deprt . '%');
        }
        $departemen = $query->get();
        //$departemen = DB::table('departemen')->orderBy('kode_deprt')->get();
        return view('departemen.index', compact('departemen'));
    }

    public function store(Request $request)
    {
        $kode_deprt = $request->kode_deprt;
        $nama_deprt = $request->nama_deprt;
            $data = [
                'kode_deprt' => $kode_deprt,
                'nama_deprt' => $nama_deprt,  
            ];
            $simpan = DB::table('departemen')->insert($data);
            if ($simpan) {
                return Redirect::back()->with(['success' => 'Data Departemen Berhasil Di Tambahkan']);
            }else{
                return Redirect::back()->with(['warning' => 'Data Departemen Gagal Di Tambahkan']);
            }
     
    }

    public function edit(Request $request){
        $kode_deprt = $request->kode_deprt;
        $departemen = DB::table('departemen')->where('kode_deprt', $kode_deprt)->first();
        return view('departemen.edit',compact('departemen'));
    }

    public function update($kode_deprt, Request $request)
    {
        $nama_deprt = $request->nama_deprt;
            $data = [
                'nama_deprt' => $nama_deprt,
            ];
            $update = DB::table('departemen')->where('kode_deprt', $kode_deprt )->update($data);
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Departemen Berhasil Di Edit']);
            }else{
                return Redirect::back()->with(['warning' => 'Data Departemen Gagal Di Edit']);
            }
           
    }
    public function delete($kode_deprt){
        $delete = DB::table('departemen')->where('kode_deprt', $kode_deprt)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'Data Departemen Berhasil Di Hapus']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Departemen Gagal Di Hapus']);
        }
    }
    
}
