<?php

namespace App\Http\Controllers;

use App\Models\Pengajuanizin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
   public function create()
   {
      $hariini = date("Y-m-d");
      $kode_karyawan = Auth::guard('tbl_karyawan')->user()->kode_karyawan;
      $cek = DB::table('tbl_absensi')->where('tgl_absensi', $hariini)->where('kode_karyawan', $kode_karyawan)->count();

      $lok_kantor = DB::table('konfig_lokasi')->where('id', 1)->first();
      //dd($lokasi_kantor); 
      return view('Absensi.create', compact('cek', 'lok_kantor'));

   }
   public function store(Request $request)
   {
      $kode_karyawan = Auth::guard('tbl_karyawan')->user()->kode_karyawan;
      $tgl_absensi = date("Y-m-d");
      $jam = date("H:i:s");
      $lok_kantor = DB::table('konfig_lokasi')->where('id', 1)->first();
      $lok = explode(",", $lok_kantor->lokasi_kantor);
      // -6.252101204656219,107.01373787136497 STB JIA
      // -6.252359,107.01333  KONTRAKAN
      // -6.25123733696333,107.01447816101074; KAMPUS PRATANATA INDONESIA
      $latitudekantor = $lok[0];
      $longitudekantor = $lok[1];
      $lokasi = $request->lokasi;
      $lokasiuser = explode(",", $lokasi);
      $latitudeuser = $lokasiuser[0];
      $longitudeuser = $lokasiuser[1];
      $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
      $radius = round($jarak["meters"]);
      $cek = DB::table('tbl_absensi')->where('tgl_absensi', $tgl_absensi)->where('kode_karyawan', $kode_karyawan)->count();
      if ($cek > 0) {
         $ket = "foto pulang";

      } else {
         $ket = "foto masuk";
      }
      $image = $request->image;
      $folderPath = "public/uploads/absensi/";
      $formatName = $kode_karyawan . "-" . $tgl_absensi . "-" . $ket;
      $image_parts = explode(";base64", $image);
      $image_base64 = base64_decode($image_parts[1]);
      $fileName = $formatName . ".png";
      $file = $folderPath . $fileName;
      // UNTUK MEMBATASI RADIUS KANTOR
      if ($radius > $lok_kantor->radius) {
         echo "error| Anda Berada di Luar Radius Kantor, Jarak Anda Sekitar " . $radius . " (Meter) dari Kantor|radius";
      } else {

         if ($cek > 0) {
            $data_pulang = [
               'jam_keluar' => $jam,
               'foto_keluar' => $fileName,
               'lokasi_keluar' => $lokasi,
            ];
            $update = DB::table('tbl_absensi')->where('tgl_absensi', $tgl_absensi)->where('kode_karyawan', $kode_karyawan)->update($data_pulang);
            if ($update) {
               echo "success|Absensi Pulang Berhasil Disimpan|out";
               Storage::put($file, $image_base64);
            } else {
               echo "error|Maaf Gagal Melakukan Absensi Pulang Hubungi Admin|out";
            }
         } else {
            $data = [
               'kode_karyawan' => $kode_karyawan,
               'tgl_absensi' => $tgl_absensi,
               'jam_masuk' => $jam,
               'foto_masuk' => $fileName,
               'lokasi_masuk' => $lokasi,
            ];
            $simpan = DB::table('tbl_absensi')->insert($data);
            if ($simpan) {
               echo "success|Absensi Masuk Berhasil Disimpan|in";
               Storage::put($file, $image_base64);
            } else {
               echo "error|Maaf Gagal Melakukan Absensi Masuk Hubungi Admin|in";
            }
         }
      }
   }

   //MENGHITNG JARAK RADIUS ANTARA KANTOR DENGAN POSISI KITA
   function distance($lat1, $lon1, $lat2, $lon2)
   {
      $theta = $lon1 - $lon2;
      $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
      $miles = acos($miles);
      $miles = rad2deg($miles);
      $miles = $miles * 60 * 1.1515;
      $feet = $miles * 5280;
      $yards = $feet / 3;
      $kilometers = $miles * 1.609344;
      $meters = $kilometers * 1000;
      return compact('meters');
   }

   public function editProfile()
   {
      $kode_karyawan = Auth::guard('tbl_karyawan')->user()->kode_karyawan;
      $karyawan = DB::table('tbl_karyawan')->where('kode_karyawan', $kode_karyawan)->first();
      //  dd($karyawan );
      return view('Absensi.editprofile', compact('karyawan'));
   }
   public function updateProfile(Request $request)
   {

      $kode_karyawan = Auth::guard('tbl_karyawan')->user()->kode_karyawan;
      $nama_lengkap = $request->nama_lengkap;
      $no_telp = $request->no_telp;
      $password = Hash::make($request->password);
      $karyawan = DB::table('tbl_karyawan')->where('kode_karyawan', $kode_karyawan)->first();
      if ($request->hasFile('foto')) {
         $foto = $kode_karyawan . "." . $request->file('foto')->getClientOriginalExtension();
      } else {
         $foto = $karyawan->foto;
      }


      if (empty ($request->password)) {
         $data = [
            'nama_lengkap' => $nama_lengkap,
            'no_telp' => $no_telp,
            'foto' => $foto

         ];
      } else {
         $data = [
            'nama_lengkap' => $nama_lengkap,
            'no_telp' => $no_telp,
            'password' => $password,
            'foto' => $foto
         ];
      }


      $update = DB::table('tbl_karyawan')->where('kode_karyawan', $kode_karyawan)->update($data);

      if ($update) {

         if ($request->hasFile('foto')) {
            $folderPath = "public/uploads/karyawan/";
            $request->file('foto')->storeAs($folderPath, $foto);
         }
         return Redirect::back()->with(['success' => 'Update Data Berhasil di Simpan!']);
      } else {
         return Redirect::back()->with(['error' => 'Tidak berhasil di simpan.!!']);
      }
   }

   public function history()
   {
      $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

      // dd($namabulan[$bulanini]);
      return view('Absensi.histori', compact('namabulan'));
   }

   public function gethistori(Request $request)
   {
      $bulan = $request->bulan;
      $tahun = $request->tahun;
      // echo $bulan."adn".$tahun;
      $kode_karyawan = Auth::guard('tbl_karyawan')->user()->kode_karyawan;
      $histori = DB::table('tbl_absensi')
         ->whereRaw('MONTH(tgl_absensi)="' . $bulan . '"')
         ->whereRaw('YEAR(tgl_absensi)="' . $tahun . '"')
         ->where('kode_karyawan', $kode_karyawan)
         ->orderBy('tgl_absensi')
         ->get();
      // dd($histori);
      return view('Absensi.gethistori', compact('histori'));

   }
   //UNTUK IZIN
   public function izin()
   {
      $kode_karyawan = Auth::guard('tbl_karyawan')->user()->kode_karyawan;
      $data_izin = DB::table('tbl_pengajuan_izin')->where('kode_karyawan', $kode_karyawan)->get();
      return view('Absensi.izin', compact('data_izin'));

   }
   public function buatizin()
   {


      return view('Absensi.buatizin');
   }

   public function storeizin(Request $request)
   {
      $kode_karyawan = Auth::guard('tbl_karyawan')->user()->kode_karyawan;
      $tgl_izin = $request->tgl_izin;
      $status = $request->status;
      $keterangan = $request->keterangan;
      $data = [
         'kode_karyawan' => $kode_karyawan,
         'tgl_izin' => $tgl_izin,
         'status' => $status,
         'keterangan' => $keterangan
      ];

      $simpan = DB::table('tbl_pengajuan_izin')->insert($data);
      if ($simpan) {
         return Redirect('/Absensi/izin')->with(['success' => 'Data Berhasil di Simpan!']);
      } else {
         return Redirect('/Absensi/izin')->with(['error' => 'Data Gagal di Simpan!']);
      }

   }

   // untuk monitoring
   public function monitoring()
   {
      return view('Absensi.monitoring');
   }

   public function getabsensi(Request $request)
   {
      $tanggal = $request->tanggal;
      $presensi = DB::table('tbl_absensi')
         ->select('tbl_absensi.*', 'nama_lengkap', 'nama_deprt')
         ->join('tbl_karyawan', 'tbl_absensi.kode_karyawan', '=', 'tbl_karyawan.kode_karyawan')
         ->join('departemen', 'tbl_karyawan.kode_deprt', '=', 'departemen.kode_deprt')
         ->where('tgl_absensi', $tanggal)
         ->get();
      return view('Absensi.getpresensi', compact('presensi'));
   }

   public function tampilkanpeta(Request $request)
   {
      $id = $request->id;
      $presensi = DB::table('tbl_absensi')->where('id', $id)
         ->join('tbl_karyawan', 'tbl_absensi.kode_karyawan', '=', 'tbl_karyawan.kode_karyawan')
         ->first();
      return view('Absensi.showmap', compact('presensi'));
   }

   //LAPORAN PRESENSI
   public function laporan()
   {
      $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

      $karyawan = DB::table('tbl_karyawan')->orderBy('nama_lengkap')->get();
      return view('Absensi.laporan', compact('namabulan', 'karyawan'));
   }
   // CETAK LAPORAN PRESENSI
   public function cetaklaporan(Request $request)
   {
      $kode_karyawan = $request->kode_karyawan;
      $bulan = $request->bulan;
      $tahun = $request->tahun;
      $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
      $karyawan = DB::table('tbl_karyawan')->where('kode_karyawan', $kode_karyawan)
         ->join('departemen', 'tbl_karyawan.kode_deprt', '=', 'departemen.kode_deprt')
         ->first();

      $presensi = DB::table('tbl_absensi')
         ->where('kode_karyawan', $kode_karyawan)
         ->whereRaw('MONTH(tgl_absensi)="' . $bulan . '"')
         ->whereRaw('YEAR(tgl_absensi)="' . $tahun . '"')
         ->orderBy('tgl_absensi')
         ->get();
      return view('Absensi.cetaklaporan', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
   }
   //LAPORAN PRESENSI
   public function rekap()
   {
      $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

      return view('Absensi.rekap', compact('namabulan'));
   }
   public function cetakrekap(Request $request)
   {
      $bulan = $request->bulan;
      $tahun = $request->tahun;
      $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

      $rekap = DB::table('tbl_absensi')
         ->selectRaw('tbl_absensi.kode_karyawan, nama_lengkap,
      MAX(IF(DAY(tgl_absensi) = 1,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_1,
      MAX(IF(DAY(tgl_absensi) = 2,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_2,
      MAX(IF(DAY(tgl_absensi) = 3,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_3,
      MAX(IF(DAY(tgl_absensi) = 4,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_4,
      MAX(IF(DAY(tgl_absensi) = 5,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_5,
      MAX(IF(DAY(tgl_absensi) = 6,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_6,
      MAX(IF(DAY(tgl_absensi) = 7,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_7,
      MAX(IF(DAY(tgl_absensi) = 8,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_8,
      MAX(IF(DAY(tgl_absensi) = 9,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_9,
      MAX(IF(DAY(tgl_absensi) = 10,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_10,
      MAX(IF(DAY(tgl_absensi) = 11,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_11,
      MAX(IF(DAY(tgl_absensi) = 12,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_12,
      MAX(IF(DAY(tgl_absensi) = 13,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_13,
      MAX(IF(DAY(tgl_absensi) = 14,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_14,
      MAX(IF(DAY(tgl_absensi) = 15,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_15,
      MAX(IF(DAY(tgl_absensi) = 16,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_16,
      MAX(IF(DAY(tgl_absensi) = 17,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_17,
      MAX(IF(DAY(tgl_absensi) = 18,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_18,
      MAX(IF(DAY(tgl_absensi) = 19,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_19,
      MAX(IF(DAY(tgl_absensi) = 20,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_20,
      MAX(IF(DAY(tgl_absensi) = 21,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_21,
      MAX(IF(DAY(tgl_absensi) = 22,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_22,
      MAX(IF(DAY(tgl_absensi) = 23,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_23,
      MAX(IF(DAY(tgl_absensi) = 24,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_24,
      MAX(IF(DAY(tgl_absensi) = 25,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_25,
      MAX(IF(DAY(tgl_absensi) = 26,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_26,
      MAX(IF(DAY(tgl_absensi) = 27,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_27,
      MAX(IF(DAY(tgl_absensi) = 28,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_28,
      MAX(IF(DAY(tgl_absensi) = 29,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_29,
      MAX(IF(DAY(tgl_absensi) = 30,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_30,
      MAX(IF(DAY(tgl_absensi) = 31,CONCAT(jam_masuk,"-",IFNULL(jam_keluar, "00:00:00")), "")) as tgl_31
      ')
         ->join('tbl_karyawan', 'tbl_absensi.kode_karyawan', '=', 'tbl_karyawan.kode_karyawan')
         ->whereRaw('MONTH(tgl_absensi)="' . $bulan . '"')
         ->whereRaw('YEAR(tgl_absensi)="' . $tahun . '"')
         ->groupByRaw('tbl_absensi.kode_karyawan, nama_lengkap')
         ->get();
      return view('Absensi.cetakrekap', compact('bulan', 'tahun', 'namabulan', 'rekap'));

   }

   // UNTUK PENGAJUAN IZIN
   public function pengajuanizin(Request $request)
   {
      $query = Pengajuanizin::query();
      $query->select('id', 'tgl_izin', 'tbl_pengajuan_izin.kode_karyawan', 'nama_lengkap', 'jabatan', 'status', 'keterangan', 'status_approved');
      $query->join('tbl_karyawan', 'tbl_pengajuan_izin.kode_karyawan', '=', 'tbl_karyawan.kode_karyawan');
      if (!empty ($request->dari) && !empty ($request->sampai)) {
         $query->whereBetween('tgl_izin', [$request->dari, $request->sampai]);
      }
      if (!empty ($request->kode_karyawan)) {
         $query->where('tbl_pengajuan_izin.kode_karyawan', $request->kode_karyawan);
      }
      if (!empty ($request->nama_lengkap)) {
         $query->where('nama_lengkap', 'LIKE', '%' . $request->nama_lengkap . '%');
      }
      if ($request->status_approved === '0' || $request->status_approved === '1' || $request->status_approved === '2'){
         $query->where('status_approved', $request->status_approved );
      }
      $query->orderBy('tgl_izin', 'desc');
      $izinsakit = $query->paginate(10);
      $izinsakit->appends($request->all());
      return view('Absensi.pengajuanizin', compact('izinsakit'));
   }

   // UNTUK UPROVE IZIN KARYAWAN 
   public function approvedizinsakit(Request $request)
   {
      $status_approved = $request->status_approved;
      $id_izinsakit_form = $request->id_izinsakit_form;
      $update = DB::table('tbl_pengajuan_izin')->where('id', $id_izinsakit_form)->update([
         'status_approved' => $status_approved
      ]);
      if ($update) {
         return Redirect::back()->with(['success' => 'Pengajuan Izin Berhasil Disimpan!']);
      } else {
         return Redirect::back()->with(['warning' => 'Perubahan Data gagal Dilakaukan!!']);
      }
   }
   // UNTUK BATALKAN PENGGAJUAN IZIN
   public function batalizinsakit($id)
   {
      $update = DB::table('tbl_pengajuan_izin')->where('id', $id)->update([
         'status_approved' => 0
      ]);
      if ($update) {
         return Redirect::back()->with(['success' => 'Data Pengajuan Izin Berhasil dibatalkan!']);
      } else {
         return Redirect::back()->with(['warning' => 'Perubahan Data gagal Dilakaukan']);
      }
   }
   // UNTUK IZIN TIDAK BOLEH DILAKUKAN 2X DALAM SEHARI
   public function cekpengajuanizin(Request $request)
   {
      $tgl_izin = $request->tgl_izin;
      $kode_karyawan = Auth::guard('tbl_karyawan')->user()->kode_karyawan;
      $cek = DB::table('tbl_pengajuan_izin')->where('kode_karyawan', $kode_karyawan)->where('tgl_izin',$tgl_izin)->count();
      return $cek;
   }

}




