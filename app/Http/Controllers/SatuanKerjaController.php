<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SatuanKerja;
use App\Models\KodeUnitKerja;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

//buat panggil fungsi
use App\Helper\StringFunc;
use App\Helper\DateFunc;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ComboController;
use Session;


// use Carbon\Carbon;

class SatuanKerjaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $CABANG_ID;

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
        Route::get('/app/satuan_kerja/index', [SatuanKerjaController::class,'index']);
        Route::get('/app/satuan_kerja/add/{id?}/{view?}', [SatuanKerjaController::class,'addview'])->where('view', 'view');
        Route::get('/app/satuan_kerja/edit/{id?}/{view?}', [SatuanKerjaController::class,'editview'])->where('view', 'view');

        Route::post('SatuanKerja/add/{id?}', [SatuanKerjaController::class,'add']);
        Route::delete('SatuanKerja/delete/{id}',[ SatuanKerjaController::class, "delete" ]);
    }

    public function index() {
      $satuan_kerja= new SatuanKerja;
           // DB::enableQueryLog();
          $query=$satuan_kerja->selectByParamsMonitoring();
      return view('app/satuan_kerja', compact('query'));
    }


    public function addview(request $request)
    {
      $reqId = $request->route('id');
      $reqStatus = 'tambah';
      $query='';
      return view('app/satuan_kerja_add', compact('reqStatus','reqId','query'));
    }


    public function editview(request $request)
    {
      $reqId = $request->route('id');
      $reqStatus = 'edit';
      $satuan_kerja= new SatuanKerja;
      $query=$satuan_kerja->selectByParamsMonitoring("and a.satker_id='".$reqId."'")->first();
      return view('app/satuan_kerja_add', compact('reqStatus','reqId','query'));
    }


    public function add(request $request)
    {

      $validated = $request->validate
      (
        [
          'reqNama' => 'required',
        ]
      );

      $reqId=$request->reqId;
      $reqNama=$request->reqNama;
      $reqStatus=$request->reqStatus;

      if($reqStatus=='tambah'){
        // nama kolom yang di insert
        $satuan_kerja= new SatuanKerja;
        $query=$satuan_kerja->selectByParamsMonitoringMax("and satker_id_parent='".$reqId."'")->first();

        $set = new SatuanKerja();
        $set->satker_id = $query->selanjutnya;
        $set->satker_id_parent         = $reqId;
        $set->nama         = $reqNama;
        
        $reqId=$query->selanjutnya;

      }
      else{
        $set = SatuanKerja::findOrFail($reqId);
        $set->satker_id = $reqId;
        $set->nama         = $reqNama;
      }

      $set->save(); 


      if(!$set)
      {
        return StringFunc::json_response(400, "Data gagal disimpan");
      }
      else
      {
        return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");
      }
      
    }



    public function delete($request)
    {
      $reqId = $request;
      SatuanKerja::where('satker_id', $reqId)
      ->delete();
      
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

  

}
