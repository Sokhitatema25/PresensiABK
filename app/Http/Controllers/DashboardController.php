<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1; //bulan
        $tahunini = date("Y"); // tahun
        $kode_karyawan = Auth::guard('tbl_karyawan')->user()->kode_karyawan;
        $absensihariini = DB::table('tbl_absensi')->where('kode_karyawan', $kode_karyawan)->where('tgl_absensi', $hariini)->first();

        $historibulanini = DB::table('tbl_absensi')
            ->where('kode_karyawan', $kode_karyawan)
            ->whereRaw('MONTH(tgl_absensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_absensi)="' . $tahunini . '"')
            ->orderBy('tgl_absensi')
            ->get();

        // UNTUK MENAMPIKAN TAHUN DI REKAP ABSENSI
        $rekappresensi = DB::table('tbl_absensi')
            ->selectRaw('COUNT(kode_karyawan) as jmlhadir, SUM(IF(jam_masuk > "07:00",1,0)) as jmlterlambat')
            ->where('kode_karyawan', $kode_karyawan)
            ->whereRaw('MONTH(tgl_absensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_absensi)="' . $tahunini . '"')
            ->first();
        // dd($rekappresensi );

        $leaderboard = DB::table('tbl_absensi')
            ->join('tbl_karyawan', 'tbl_absensi.kode_karyawan', '=', 'tbl_karyawan.kode_karyawan')
           
            ->where('tgl_absensi', $hariini)
            ->orderBy('jam_masuk')
            ->get();


        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        // dd($namabulan[$bulanini]);

        $rekapizin = DB::table('tbl_pengajuan_izin')
            ->selectRaw('SUM(IF(status= "i",1,0 )) as jmlizin, SUM(IF(status="s",1,0 )) as jmlsakit')
            ->where('kode_karyawan', $kode_karyawan)
            ->whereRaw('MONTH(tgl_izin)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_izin)="' . $tahunini . '"')
            ->where('status_approved', 1)
            ->first();
            //dd($rekapizin);
        return view('dashboard.dashboard', compact('absensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini', 'rekappresensi', 'leaderboard', 'rekapizin'));
    }


    // UNTUK DASHBOARD ADMIN
    public function dashboardadmin()
    {
        $hariini = date('Y-m-d');
        $rekappresensi = DB::table('tbl_absensi')
        ->selectRaw('COUNT(kode_karyawan) as jmlhadir, SUM(IF(jam_masuk > "07:00",1,0)) as jmlterlambat')
        ->where('tgl_absensi', $hariini)
        ->first();

        $rekapizin = DB::table('tbl_pengajuan_izin')
        ->selectRaw('SUM(IF(status= "i",1,0 )) as jmlizin, SUM(IF(status="s",1,0 )) as jmlsakit')
        ->where('tgl_izin', $hariini)
        ->where('status_approved', 1)
        ->first();
        return view('dashboard.dashboardadmin', compact('rekappresensi', 'rekapizin'));
    }
}
