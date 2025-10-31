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

class ManajemenTalentaController extends Controller
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
        Route::get('/app/manajemen_talenta/grafikninebox', [ManajemenTalentaController::class,'grafikninebox']);
        Route::get('/app/manajemen_talenta/tabelninebox', [ManajemenTalentaController::class,'tabelninebox']);
        Route::get('/app/manajemen_talenta/lookup/{id?}/{view?}', [ManajemenTalentaController::class,'addviewlookupFormula']);
        Route::get('/app/manajemen_talenta/talenta_info_pegawai/{id?}', [ManajemenTalentaController::class,'talenta_info_pegawai']);
        Route::get('/app/talenta/edit/{id?}/{pg?}', [ManajemenTalentaController::class,'talenta_menu']);
        Route::get('/app/talenta/skp/{id?}/{pg?}', [ManajemenTalentaController::class,'skp']);
        Route::get('/app/talenta/pendidikan/{id?}/{pg?}', [ManajemenTalentaController::class,'pendidikan']);
        Route::get('/app/talenta/huknis/{id?}/{pg?}', [ManajemenTalentaController::class,'huknis']);
        Route::get('/app/talenta/assesment/{id?}/{pg?}', [ManajemenTalentaController::class,'assesment']);
        Route::get('/app/talenta/penghargaan/{id?}/{pg?}', [ManajemenTalentaController::class,'penghargaan']);

        Route::get('ManajemenTalenta/jsontabelninebox/', [ManajemenTalentaController::class,'jsontabelninebox']);
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

    public function talenta_info_pegawai(request $request) {
        $reqId=$request->route('id');
        $pg='talenta_info_pegawai';
        return view("app/talenta_info_pegawai",compact('pg','reqId'));
    }

    public function talenta_menu(request $request) {
        $reqId=$request->route('id');
        $pg=$request->route('pg');
        return view("app/talenta_menu",compact('pg','reqId'));
    }

    public function skp(request $request) {
        $reqId=$request->route('id');
        $pg='skp';
        return view("app/talenta_skp",compact('pg','reqId'));
    }

    public function pendidikan(request $request) {
        $reqId=$request->route('id');
        $pg='pendidikan';
        return view("app/talenta_pendidikan",compact('pg','reqId'));
    }

    public function huknis(request $request) {
        $reqId=$request->route('id');
        $pg='huknis';
        return view("app/talenta_huknis",compact('pg','reqId'));
    }

    public function assesment(request $request) {
        $reqId=$request->route('id');
        $pg='assesment';
        return view("app/talenta_assesment",compact('pg','reqId'));
    }

    public function penghargaan(request $request) {
        $reqId=$request->route('id');
        $pg='penghargaan';
        return view("app/talenta_penghargaan",compact('pg','reqId'));
    }

    public function addviewlookupFormula(request $request) 
    {
      $query='';
      return view('app/lookup_pegawai', compact('query'));
    }

    public function jsontabelninebox(request $request)
    {
        $reqUnitKerja = $request->input('reqUnitKerja');
        $reqJenis = $request->input('reqJenis');
        // dd($reqUnitKerja);
        $query= new Pegawai();

        $query=$query->selectByParamsMonitoring();
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $btn = '<a href="'.url('app/manajemen_talenta/talenta_info_pegawai/'.$row->pegawai_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-eye"></span></a>'; 
          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->editColumn('tgl_lahir', function ($user) {
          return DateFunc::dateToPageCheck($user->tgl_lahir);
        })

        ->addColumn('potensi', function ($user) {
          return '-';
        })
        ->addColumn('kinerja', function ($user) {
          return '-';
        })
        ->addColumn('kuadran', function ($user) {
          return '-';
        })
        ->make(true);
    }


}