<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   public function prosesLogin(Request $request)
   {
    
      if(Auth::guard('tbl_karyawan')->attempt(['kode_karyawan' => $request->kode_karyawan, 'password'=> $request->password]))
      {
        return redirect('/dashboard');
      }
      else
      {
        return redirect('/')->with(['warning' => 'Kode Pegawai / Password Salah']);
      }
   }
   public function prosesLogout()
   {
    if(Auth::guard('tbl_karyawan')->check()){
      Auth::guard('tbl_karyawan')->logout();
      return redirect('/');
    }
   }
  //  PROSES LOGIN ADMIN
public function prosesLogoutadmin()
{
  if(Auth::guard('user')->check()){
    Auth::guard('user')->logout();
    return redirect('/panel');
  }
}
  
   public function prosesloginadmin(Request $request)
   {
      if(Auth::guard('user')->attempt(['email' => $request->email, 'password'=> $request->password]))
      {
        return redirect('/panel/dashboardadmin');
      }
      else
      {
        return redirect('/panel')->with(['warning' => 'Email dan Password Anda Salah']);
      }
   }
}
