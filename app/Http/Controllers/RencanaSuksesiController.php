<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asesor;
use App\Models\SatuanKerja;
use App\Models\UserLogin;
use App\Models\AsesorBaru;
use App\Models\Pegawai;
use App\Models\JadwalTes;
use App\Models\Penilaian;
use App\Models\JadwalPegawaiDetil;
use App\Models\JadwalPegawaiDetilAtribut;
use App\Models\PenilaianDetil;
use App\Models\PenilaianRekomendasi;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

//buat panggil fungsi
use App\Helper\StringFunc;
use App\Helper\DateFunc;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SatuanKerjaController;
use Session;


use Carbon\Carbon;

class RencanaSuksesiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $stringfunc;
    public function __construct()
    {
        $this->middleware('cek_login');

        $this->middleware(function ($request, $next) {
          $this->user= Session::get('user');
          // $this->user= Auth::user()->load('pegawai.satker_model');

          // $this->ID                   = $this->user->pegawai->pegawai_id;   
          // $this->NAMA                 = $this->user->pegawai->nama;   
          // $this->JABATAN              = $this->user->pegawai->jabatan;   
          // $this->HAK_AKSES            = $this->user->pegawai->hak_akses;   
          // $this->LAST_LOGIN           = $this->user->pegawai->last_login;   
          // $this->USERNAME             = $this->user->pegawai->username;  
          // $this->USER_LOGIN_ID        = $this->user->pegawai->user_login_id;  
          // $this->USER_GROUP           = $this->user->pegawai->user_group;  
          // $this->MULTIROLE            = $this->user->pegawai->multirole;  
          // $this->CABANG_ID            = $this->user->pegawai->satuan_kerja_id;  
          // $this->CABANG               = $this->user->pegawai->cabang;  
          // $this->SATUAN_KERJA_ID_ASAL = $this->user->pegawai->satuan_kerja_id_asal;  
          // $this->SATUAN_KERJA_ASAL    = $this->user->pegawai->satuan_kerja_asal;  
          // $this->SATUAN_KERJA_HIRARKI = $this->user->pegawai->satuan_kerja_hirarki;  
          // $this->SATUAN_KERJA_JABATAN = $this->user->pegawai->satuan_kerja_jabatan;  
          // $this->KD_LEVEL             = $this->user->pegawai->kd_level;  
          // $this->JENIS_KELAMIN        = $this->user->pegawai->jenis_kelamin;

          return $next($request);
        });

        $this->stringfunc = new StringFunc();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function route_web() {
    
        //buat route view
        Route::get('/app/suksesi/penilaian/{id?}', [RencanaSuksesiController::class,'penilaian']);
        Route::get('/app/suksesi/hasil/{id?}', [RencanaSuksesiController::class,'hasil']);  
        Route::get('/app/suksesi/bobotpenilaian/{id?}', [RencanaSuksesiController::class,'bobotpenilaian']);  
        Route::get('/app/suksesi/jabatantarget/{id?}', [RencanaSuksesiController::class,'jabatantarget']);  
        Route::get('/app/suksesi/masterrumpun/{id?}', [RencanaSuksesiController::class,'masterrumpun']);  
        Route::get('/app/suksesi/masterjabatan/{id?}', [RencanaSuksesiController::class,'masterjabatan']);  
        Route::get('/app/suksesi/masterpenilaian/{id?}', [RencanaSuksesiController::class,'masterpenilaian']);  
        Route::get('/app/suksesi/menu/{pg?}', [RencanaSuksesiController::class,'suksesi_menu']);  
        Route::get('/app/suksesi/menumaster/{pg?}', [RencanaSuksesiController::class,'suksesi_menu_master']);  
    }

    public function grafikninebox(request $request) {
     $satuan_kerja = new SatuanKerjaController();
     // $cabangid=$this->CABANG_ID;
     // $satker=$satuan_kerja->combo_cabang($request,$cabangid);

     // $jenis=$this->combojenis($request);
     $jenis=1;
     // dd($jenis);
     // return view("app/pegawai/index",compact('satker','cabangid','jenis'));
     return view("app/mj_grafik_nine_box",compact('jenis'));
    }

    public function tabelninebox(request $request) {
     $satuan_kerja = new SatuanKerjaController();
     // $cabangid=$this->CABANG_ID;
     // $satker=$satuan_kerja->combo_cabang($request,$cabangid);

     // $jenis=$this->combojenis($request);
     $jenis=1;
     // dd($jenis);
     // return view("app/pegawai/index",compact('satker','cabangid','jenis'));
     return view("app/tabel_nine_box",compact('jenis'));
    }

    public function penilaian(request $request) {
        $reqId=$request->route('id');
        return view("app/suksesi_penilaian",compact('reqId'));
    }

    public function hasil(request $request) {
        $reqId=$request->route('id');
        return view("app/suksesi_hasil",compact('reqId'));
    }

    public function suksesi_menu(request $request) {
        $reqId=$request->route('id');
        $pg=$request->route('pg');
        return view("app/suksesi_menu",compact('pg','reqId'));
    }

    public function suksesi_menu_master(request $request) {
        $reqId=$request->route('id');
        $pg=$request->route('pg');
        return view("app/suksesi_menu_master",compact('pg','reqId'));
    }

    public function bobotpenilaian(request $request) {
        $reqId=$request->route('id');
        $pg='bobot_penilaian';
        return view("app/suksesi_bobot_penilaian",compact('pg','reqId'));
    }

    public function jabatantarget(request $request) {
        $reqId=$request->route('id');
        $pg='jabatan_target';
        return view("app/suksesi_jabatan_target",compact('pg','reqId'));
    }

    public function masterrumpun(request $request) {
        $reqId=$request->route('id');
        $pg='master_rumpun';
        return view("app/suksesi_master_rumpun",compact('pg','reqId'));
    }

    public function masterjabatan(request $request) {
        $reqId=$request->route('id');
        $pg='master_jabatan';
        return view("app/suksesi_master_jabatan",compact('pg','reqId'));
    }

    public function masterpenilaian(request $request) {
        $reqId=$request->route('id');
        $pg='master_penilaian';
        return view("app/suksesi_master_penilaian",compact('pg','reqId'));
    }


}