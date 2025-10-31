<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingPelaksanaan;
use App\Models\SatuanKerja;
use App\Models\UserLogin;
use App\Models\FormulaEselon;
use App\Models\Attribut;
use App\Models\FormulaAtributBobot;
use App\Models\FormulaAtribut;
use App\Models\LevelAtribut;
use App\Models\AtributPenggalian;
use App\Models\TipeUjian;
use App\Models\FormulaAssesmentUjianTahap;

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

class SettingPelaksanaanController extends Controller
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
          // print_r($this->user);
          // $this->user= Auth::user()->load('pegawai.satker_model');
          // print_r($this->UserLogin->pegawai);exit;

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
        Route::get('/app/setting_pelaksanaan/index', [SettingPelaksanaanController::class,'index']);
        Route::get('/app/setting_pelaksanaan/edit/{view?}/{id?}/{iddll?}', [SettingPelaksanaanController::class,'addviewEdit']);
        Route::get('/app/setting_pelaksanaan/add/{id?}/{view?}', [SettingPelaksanaanController::class,'addview']);
        Route::get('/app/setting_pelaksanaan/eselon/{id?}/{view?}', [SettingPelaksanaanController::class,'addviewEselon']);
        Route::get('/app/setting_pelaksanaan/attribut/{formulaid?}/{formulaeselonid?}', [SettingPelaksanaanController::class,'addviewAttribut']);
        Route::get('/app/setting_pelaksanaan/attributkompetensi/{formulaid?}/{formulaeselonid?}', [SettingPelaksanaanController::class,'addviewAttributkompetensi']);
        Route::get('/app/setting_pelaksanaan/soal/{id?}/{view?}', [SettingPelaksanaanController::class,'addviewSoal']);
        Route::get('/app/setting_pelaksanaan/soal_rapid/{id?}/{view?}', [SettingPelaksanaanController::class,'addviewSoalRapid']);
        Route::get('/app/setting_pelaksanaan/urutansoal/{id?}/{view?}', [SettingPelaksanaanController::class,'addviewUrutanSoal']);
        Route::get('/app/setting_pelaksanaan/lookup/soal/{filter?}/{view?}', [SettingPelaksanaanController::class,'addviewlookupSoal']);
        // Route::get('/app/pegawai/lookup/{link?}/{id?}', [PegawaiController::class,'lookup']);

        //buat route proses
        Route::get('SettingPelaksanaan/json/{id?}', [SettingPelaksanaanController::class,'json']);
        Route::get('SettingPelaksanaan/jsonsoal/{filterid?}', [SettingPelaksanaanController::class,'jsonsoal']);
        Route::post('SettingPelaksanaan/addFormula', [SettingPelaksanaanController::class, 'addFormula']);
        Route::post('SettingPelaksanaan/addEselon', [SettingPelaksanaanController::class, 'addEselon']);
        Route::post('SettingPelaksanaan/addAtribut', [SettingPelaksanaanController::class, 'addAtribut']);
        Route::post('SettingPelaksanaan/addAtributKompetensi', [SettingPelaksanaanController::class, 'addAtributKompetensi']);
        Route::post('SettingPelaksanaan/addSoal', [SettingPelaksanaanController::class, 'addSoal']);
        Route::post('SettingPelaksanaan/addSoalRapid', [SettingPelaksanaanController::class, 'addSoalRapid']);
        Route::post('SettingPelaksanaan/addUrutan', [SettingPelaksanaanController::class, 'addUrutan']);
        // Route::get('Pegawai/json/', [PegawaiController::class,'json']);
        // Route::post('Pegawai/add/{id?}', [PegawaiController::class,'add']);
        Route::delete('SettingPelaksanaan/deleteSoal/{id}/{tipeId}',[ SettingPelaksanaanController::class, "deleteSoal" ]);
        Route::delete('SettingPelaksanaan/deleteFormula/{id}',[ SettingPelaksanaanController::class, "deleteFormula" ]);

    }

    public function index(request $request) {
     $satuan_kerja = new SatuanKerjaController();
     // $cabangid=$this->CABANG_ID;
     // $satker=$satuan_kerja->combo_cabang($request,$cabangid);

     $jenis=$this->combojenis($request);
     // dd($jenis);
     // return view("app/pegawai/index",compact('satker','cabangid','jenis'));
     return view("app/setting_pelaksanaan",compact('jenis'));
    }

    public function json(request $request)
    {
        $reqUnitKerja = $request->input('reqUnitKerja');
        $reqJenis = $request->input('reqJenis');
        // dd($reqUnitKerja);
        $query= new SettingPelaksanaan();

        $query=$query->selectByParamsMonitoring();
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $btn = '<a href="'.url('app/setting_pelaksanaan/add/'.$row->formula_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
          $btn .= '<a onclick=\'deletedata("'.$row->formula_id.'")\' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }

    public function jsonsoal(request $request)
    {
        $reqFilter=$request->route('filterid');
        // echo $reqFilter;exit;
        $query= new TipeUjian();

        $statement=" and parent_id ='0' and muncul = 1 ";
        if($reqFilter!=''){
          $statement.=" and tipe_ujian_id not in (".$reqFilter.")";
        }
        $query=$query->selectByParamsMonitoring($statement);
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $disini="'".$row->tipe."'";
          $btn = '<a onclick="tampil('.$row->tipe_ujian_id.','.$disini.','.$row->waktu.')" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }

    public function addview(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      // $satker=$satuan_kerja->combo_cabang($request,$reqUnitKerjaId);
      $pg='setting_pelaksanaan_add';
      if(empty($reqId))
      {
        $query = "";
        // return view('app/pegawai.add', compact('query','jenis','satker','reqUnitKerjaId'));
        return view('app/setting_pelaksanaan_add', compact('query','pg'));
      }
      else
      {
        $query = new SettingPelaksanaan();
        $statement=' and a.FORMULA_ID ='.$reqId;
        $query=$query->selectByParamsMonitoring($statement)->first();
        //buat tes sqli
        // $query=$query->selectByParamsSqlI($reqId)->first();
        return view('app/setting_pelaksanaan_add', compact('query','pg'));
      }
    }

    public function addviewEdit(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');
      $iddll = $request->route('iddll');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      // $satker=$satuan_kerja->combo_cabang($request,$reqUnitKerjaId);
      $pg='setting_awal_add';

      if(empty($reqId))
      {
        $query = "";
        // return view('app/pegawai.add', compact('query','jenis','satker','reqUnitKerjaId'));
        return view('app/setting_pelaksanaan_edit', compact('query','reqId','reqView','pg'));
      }
      else
      {

        $queryIdentitas = new SettingPelaksanaan();
        $statement=' and a.FORMULA_ID ='.$reqId;
        $queryIdentitas=$queryIdentitas->selectByParamsMonitoring($statement)->first();
       
        $statement=' and FORMULA_ID='.$reqId;
        $query = new FormulaEselon();
        $query=$query->selectByParamsMenu($statement);
        //buat tes sqli
        // $query=$query->selectByParamsSqlI($reqId)->first();
        return view('app/setting_pelaksanaan_edit', compact('query','reqId','reqView','pg','iddll','queryIdentitas'));
      }
    }

    public function addviewAttribut(request $request)
    {
      $reqId=$request->route('formulaid');
      $formulaeselonid = $request->route('formulaeselonid');

      $pg='setting_pelaksanaan_attribut';
      $query = new Attribut();
      $statement='AND A.ASPEK_ID = 1 AND A.PERMEN_ID = 1';
      $query=$query->selectByParamsMonitoring($formulaeselonid,$statement);

      $data = new SettingPelaksanaan();
      $statement='AND a.formula_id = '.$reqId;
      $data=$data->selectByParamsMonitoring($statement)->first();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_pelaksanaan_attribut', compact('query','reqId','pg','formulaeselonid','data'));
    }

    public function addviewAttributkompetensi(request $request)
    {
      $reqId=$request->route('formulaid');
      $formulaeselonid = $request->route('formulaeselonid');

      $pg='setting_pelaksanaan_attribut';
      $query = new Attribut();
      $statement='AND A.ASPEK_ID = 2 AND A.PERMEN_ID = 1';
      $query=$query->selectByParamsMonitoring($formulaeselonid,$statement);

      $data = new SettingPelaksanaan();
      $statement='AND a.formula_id = '.$reqId;
      $data=$data->selectByParamsMonitoring($statement)->first();

      $dropdown = new LevelAtribut();
      $dropdown=$dropdown->selectByParamsDropdown();

      $checklist = new LevelAtribut();
      $statement =' and tahun ='. date("Y");
      $checklist=$checklist->selectByParamschecklist($statement);

      $penggalian = new AtributPenggalian();
      $penggalian=$penggalian->selectByParamsMonitoring();
      //buat tes sqli
      // print_r($checklist);exit;
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_pelaksanaan_attribut_kompetensi', compact('query','reqId','pg','formulaeselonid','data', 'dropdown', 'checklist','penggalian'));
    }

    public function addviewEselon(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $pg='setting_pelaksanaan_eselon';
      $query = new FormulaEselon();
      $query=$query->selectByParamsMonitoring($reqId);

      $queryFormula= new SettingPelaksanaan();
      $statement=' and a.FORMULA_ID ='.$reqId;
      $queryFormula=$queryFormula->selectByParamsMonitoring($statement)->first();
      //buat tes sqli
      // print_r($queryFormula); exit;
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_pelaksanaan_eselon', compact('query','reqId','pg','queryFormula'));
    }

    public function addviewSoal(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);
      $pg='setting_pelaksanaan_soal';
      $query = new TipeUjian();
      $query=$query->selectByParamsMonitoring();

      $statement=' and formula_assesment_id= '. $reqId;
      $list = new FormulaAssesmentUjianTahap();
      $list=$list->selectByParamsMonitoring($statement);

      $data = new SettingPelaksanaan();
      $statement='AND a.formula_id = '.$reqId;
      $data=$data->selectByParamsMonitoring($statement)->first();

      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_pelaksanaan_soal', compact('query','reqId','pg','list','data'));
    }

    public function addviewSoalRapid(request $request)
    {
      $reqId=$request->route('id');
      // print_r($reqId);exit;
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);
      $pg='setting_pelaksanaan_soal';
      
      $queryFormula= new SettingPelaksanaan();
      $statement=' and a.FORMULA_ID ='.$reqId;
      $queryFormula=$queryFormula->selectByParamsMonitoring($statement)->first();

      $query = new TipeUjian();
      $query=$query->selectByParamsMonitoring();

      $statement=' and formula_assesment_id= '. $reqId;
      $list = new FormulaAssesmentUjianTahap();
      $list=$list->selectByParamsMonitoring($statement);

      $querycfid = new TipeUjian();
      $statement= 'and tipe_ujian_id in (1,2)';
      $querycfid=$querycfid->selectByParamsMonitoring($statement);

      $querySJT = new TipeUjian();
      $statement= "and keterangan_ujian='SJT'";
      $querySJT=$querySJT->selectByParamsMonitoring($statement);


      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_pelaksanaan_soal_rapid', compact('query','reqId','pg','list','querySJT','querycfid','queryFormula'));
    }

    public function addviewUrutanSoal(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);
      $pg='setting_pelaksanaan_urutansoal';

      $query = new FormulaAssesmentUjianTahap();
      $statement=' and formula_assesment_id= '. $reqId. " and parent_id = '0'";
      $query=$query->selectByParamsMonitoring($statement);
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_pelaksanaan_urutan_soal', compact('query','reqId','pg'));
    }

    public function addFormula(request $request)
    {
      // buat validasi
      $validated = $request->validate([
            'reqTahun' => 'required',
            'reqFormula' => 'required',
            'reqKeterangan' => 'required',
            'reqTipeFormula' => 'required',
      ]);

      $infoid= $request->reqId;
      $reqTahun= $request->reqTahun;
      $reqFormula= $request->reqFormula;
      $reqKeterangan= $request->reqKeterangan;
      $reqTipeFormula= $request->reqTipeFormula;
         
      if(empty($infoid))
      {
        $maxId = SettingPelaksanaan::NextId();
        $set = new SettingPelaksanaan();
        // nama kolom yang di insert
        $set->formula_id = $maxId;
        $set->last_create_user = $this->user->user_app_id;
        $set->last_create_date = Carbon::now();
        $infoid=$maxId;
      }else{           
        $set = SettingPelaksanaan::findOrFail($infoid);
        $set->formula_id = $infoid;
        $set->last_update_user = $this->user->user_app_id;
        $set->last_update_date = Carbon::now();
      }

      $set->tahun =$reqTahun;
      $set->formula =$reqFormula;
      $set->keterangan =$reqKeterangan;
      $set->tipe_formula =$reqTipeFormula;
      $set->save();
      
      return StringFunc::json_response(200, $infoid."-Data berhasil disimpan.");

    }

    public function addEselon(request $request)
    {
      // buat validasi
      // $validated = $request->validate([
      //       'reqTahun' => 'required',
      //       'reqFormula' => 'required',
      //       'reqKeterangan' => 'required',
      //       'reqTipeFormula' => 'required',
      // ]);

      $infoid= $request->reqId;
      $reqFormulaEselonId= $request->reqFormulaEselonId;
      $reqEselonId= $request->reqEselonId;
      $reqProsenPotensi= $request->reqProsenPotensi;
      $reqProsenKomptensi= $request->reqProsenKomptensi;
      $reqProsenTotal= $request->reqProsenTotal;
      $reqProsenTotal= $request->reqProsenTotal;

      for($i=0 ;$i<count($reqFormulaEselonId);$i++){
        if($reqProsenPotensi[$i]==''){

        }
        else{
          if(empty($reqFormulaEselonId[$i]))
          {
            $maxId = FormulaEselon::NextId();
            $set = new FormulaEselon();
            // nama kolom yang di insert
            $set->formula_eselon_id = $maxId;
            $set->last_create_user = $this->user->user_app_id;
            $set->last_create_date = Carbon::now();
          }else{           
            $set = FormulaEselon::findOrFail($reqFormulaEselonId[$i]);
            $set->formula_eselon_id = $reqFormulaEselonId[$i];
            $set->last_update_user = $this->user->user_app_id;
            $set->last_update_date = Carbon::now();
          }

          $set->formula_id =$infoid;
          $set->eselon_id =$reqEselonId[$i];
          $set->prosen_kompetensi =$reqProsenPotensi[$i];
          $set->prosen_potensi =$reqProsenKomptensi[$i];
          $set->save();
        }
        
      }
         
      
      return StringFunc::json_response(200, $infoid."-Data berhasil disimpan.");

    }

    public function addAtribut(request $request)
    {
      // buat validasi
      // $validated = $request->validate([
      //       'reqTahun' => 'required',
      //       'reqFormula' => 'required',
      //       'reqKeterangan' => 'required',
      //       'reqTipeFormula' => 'required',
      // ]);

      $reqId= $request->reqId;
      $reqRowId= $request->reqRowId;
      $reqTahun= $request->reqTahun;
      $reqAspekId= $request->reqAspekId;
      $reqFormulaAtributBobotId= $request->reqFormulaAtributBobotId;
      $reqBobotStatusAtributId= $request->reqBobotStatusAtributId;
      $reqBobotAtributId= $request->reqBobotAtributId;
      $reqAtributNilaiStandar= $request->reqAtributNilaiStandar;
      $reqLevelId= $request->reqLevelId;
      // print_r($reqFormulaAtributBobotId);exit;
      $reqFormulaAtributId= $request->reqFormulaAtributId;
      $reqAtributId= $request->reqAtributParentId;
      $reqAtributPenggalianId= $request->reqAtributPenggalianId;
      for($i=0 ;$i<count($reqAtributNilaiStandar);$i++){
        if($reqAtributNilaiStandar[$i]==''){

        }
        else{
            if(empty($reqFormulaAtributBobotId[$i]))
            {
              if(empty($reqLevelId[$i])){
                $reqLevel='is null';
              }
              else{
                $reqLevel='='.$reqLevelId[$i];
              }
              $statement= " AND FORMULA_ESELON_ID = ".$reqRowId." AND LEVEL_ID  ".$reqLevel;
              $query = new FormulaAtribut();
              $query=$query->selectByParamsMonitoring($statement)->first();
              if(empty($query->formula_atribut_id)){
                if($reqAspekId==1){
                  $statement_level= " AND A.ATRIBUT_ID = '".$reqBobotAtributId[$i]."' AND A.LEVEL = 0";
                  // kondisi aktif permen
                  $statement_level.= " AND EXISTS (SELECT 1 FROM (SELECT PERMEN_ID AKTIF_PERMENT FROM PERMEN WHERE STATUS = '1') X WHERE AKTIF_PERMENT = PERMEN_ID)";
                  $query = new FormulaAtribut();
                  $query=$query->selectByParamsLevelAtribut($statement_level)->first();
                  if(empty($query->level_id)){
                    $setLevel = new LevelAtribut();
                    $maxLevelId = LevelAtribut::NextId();
                    $setLevel->level_id =$maxLevelId;
                    $setLevel->atribut_id =$reqBobotAtributId[$i];
                    $setLevel->level = "0";
                    $setLevel->keterangan ="INTEGRASI";
                    $setLevel->save(); 
                    $maxLevelId = $maxLevelId-1;
                  }
                  else{
                    $maxLevelId=$query->level_id;
                  }
                }
              }
              $maxFormulaAtributId = FormulaAtribut::NextId();
              $set = new FormulaAtribut();
              // // nama kolom yang di insert
              $set->formula_atribut_id = $maxFormulaAtributId;
              $set->level_id =$maxLevelId;
              $set->last_create_user = $this->user->user_app_id;
              $set->last_create_date = Carbon::now();
            }else{           
              $maxFormulaAtributId=$reqFormulaAtributBobotId[$i];
              $set = FormulaAtribut::findOrFail($reqFormulaAtributBobotId[$i]);
              $set->formula_atribut_id = $reqFormulaAtributBobotId[$i];
              $set->level_id=$reqLevelId[$i];
              $set->last_update_user = $this->user->user_app_id;
              $set->last_update_date = Carbon::now();
            }

            $set->formula_eselon_id =$reqRowId;
            $set->nilai_standar =StringFunc::ValToNullDB($reqAtributNilaiStandar[$i]);
            $set->form_atribut_id =$reqBobotAtributId[$i];
            $set->save();
        }
      }
         
      return StringFunc::json_response(200, $reqId."-".$reqRowId."-Data berhasil disimpan.");

    }

    public function addAtributKompetensi(request $request)
    {
      // buat validasi
      // $validated = $request->validate([
      //       'reqTahun' => 'required',
      //       'reqFormula' => 'required',
      //       'reqKeterangan' => 'required',
      //       'reqTipeFormula' => 'required',
      // ]);

      $reqId= $request->reqId;
      $reqRowId= $request->reqRowId;
      $reqTahun= $request->reqTahun;
      $reqAspekId= $request->reqAspekId;
      $reqFormulaAtributBobotId= $request->reqFormulaAtributBobotId;
      $reqBobotStatusAtributId= $request->reqBobotStatusAtributId;
      $reqBobotAtributId= $request->reqBobotAtributId;
      $reqAtributNilaiStandar= $request->reqAtributNilaiStandar;
      $reqLevelId= $request->reqLevelId;
      // print_r($reqLevelId);exit;
      $reqFormulaAtributId= $request->reqFormulaAtributId;
      // print_r($reqFormulaAtributId);exit;
      $reqAtributId= $request->reqAtributParentId;
      $reqAtributPenggalianId= $request->reqAtributPenggalianId;

      
      for($i=0 ;$i<count($reqAtributNilaiStandar);$i++){
        if($reqAtributNilaiStandar[$i]==''){

        }
        else{
          if($reqBobotStatusAtributId[$i]==1){
            if(empty($reqFormulaAtributBobotId[$i]))
            {
              $maxId = FormulaAtributBobot::NextId();
              $set = new FormulaAtributBobot();
              // nama kolom yang di insert
              $set->formula_atribut_bobot_id = $maxId;
            }else{           
              $set = FormulaAtributBobot::findOrFail($reqFormulaAtributBobotId[$i]);
              $set->formula_atribut_bobot_id = $reqFormulaAtributBobotId[$i];
            }

            $set->formula_eselon_id =$reqRowId;
            $set->aspek_id =$reqAspekId;
            $set->atribut_id =$reqBobotAtributId[$i];
            $set->atribut_nilai_standar =$reqAtributNilaiStandar[$i];
            $set->permen_id =1;
            $set->save(); 
          }
          
          $akses='tolak';
          if($reqBobotStatusAtributId[$i]=='' && $reqAspekId==1){
            $akses='masuk';
          }
          if($reqAspekId==2){
            $akses='masuk';
          }
          if($akses=='masuk'){
              
            $maxLevelId=$reqLevelId[$i];

            if(empty($reqFormulaAtributId[$i]))
            {
              if(empty($reqLevelId[$i])){
                $reqLevel='is null';
              // echo $reqLevel.'x'; exit;
              }
              else{
                $reqLevel='='.$reqLevelId[$i];
              }
              $statement= " AND FORMULA_ESELON_ID = ".$reqRowId." AND LEVEL_ID  ".$reqLevel;
              $query = new FormulaAtribut();
              $query=$query->selectByParamsMonitoring($statement)->first();
              if(empty($query->formula_atribut_id)){
                if($reqAspekId==1){
                  $statement_level= " AND A.ATRIBUT_ID = '".$reqBobotAtributId[$i]."' AND A.LEVEL = 0";
                  // kondisi aktif permen
                  $statement_level.= " AND EXISTS (SELECT 1 FROM (SELECT PERMEN_ID AKTIF_PERMENT FROM PERMEN WHERE STATUS = '1') X WHERE AKTIF_PERMENT = PERMEN_ID)";
                  $query = new FormulaAtribut();
                  $query=$query->selectByParamsLevelAtribut($statement_level)->first();
                  if(empty($query->level_id)){
                    $setLevel = new LevelAtribut();
                    $maxLevelId = LevelAtribut::NextId();
                    $setLevel->level_id =$maxLevelId;
                    $setLevel->atribut_id =$reqBobotAtributId[$i];
                    $setLevel->level = "0";
                    $setLevel->keterangan ="INTEGRASI";
                    $setLevel->save(); 
                    $maxLevelId = $maxLevelId-1;
                  }
                  else{
                    $maxLevelId=$query->level_id;
                  }
                }

              }
              $maxFormulaAtributId = FormulaAtribut::NextId();
              $set = new FormulaAtribut();
              // // nama kolom yang di insert
              $set->formula_atribut_id = $maxFormulaAtributId;
              $set->level_id =$maxLevelId;
              $set->last_create_user = $this->user->user_app_id;
              $set->last_create_date = Carbon::now();
            }else{           
              $maxFormulaAtributId=$reqFormulaAtributId[$i];
              $set = FormulaAtribut::findOrFail($reqFormulaAtributId[$i]);
              $set->formula_atribut_id = $reqFormulaAtributId[$i];
              $set->level_id =$maxLevelId;
              $set->last_update_user = $this->user->user_app_id;
              $set->last_update_date = Carbon::now();
            }

            $set->formula_eselon_id =$reqRowId;
            $set->nilai_standar =StringFunc::ValToNullDB($reqAtributNilaiStandar[$i]);
            $set->form_atribut_id =$reqBobotAtributId[$i];
            $set->save();
          }
          if($reqAspekId==2){
            if($reqAtributPenggalianId[$i] != ""){
              $arrAtributPenggalian= explode(",",$reqAtributPenggalianId[$i]);
              $arrAtributPenggalianFilter = array_filter($arrAtributPenggalian, function($value) {
                  // Menghapus nilai yang null atau string kosong
                  return $value !== null && $value !== '';
              });

              AtributPenggalian::whereNotIn('penggalian_id', $arrAtributPenggalianFilter)
              ->where('formula_atribut_id', $reqFormulaAtributBobotId[$i])
              ->delete();

              
                for($x=0; $x < count($arrAtributPenggalian); $x++)
                {
                  $tempPenggalianId= $arrAtributPenggalian[$x];
                  if(empty($tempPenggalianId)){

                  }
                  else{
                    $statement= " AND A.FORMULA_ATRIBUT_ID = ".$maxFormulaAtributId." AND A.PENGGALIAN_ID = ".$tempPenggalianId;
                    $set_cek= new AtributPenggalian();
                    $set_cek=$set_cek->selectByParamsMonitoring($statement)->first();
                    // echo $set_cek->atribut_penggalian_id;exit;
                    if(empty($set_cek->atribut_penggalian_id))
                    {
                      $maxId = AtributPenggalian::NextId();
                      $set = new AtributPenggalian();
                      // nama kolom yang di insert
                      $set->atribut_penggalian_id = $maxId;
                      $set->last_create_user = $this->user->user_app_id;
                      $set->last_create_date = Carbon::now();
                    }else{           
                      $set = AtributPenggalian::findOrFail($set_cek->atribut_penggalian_id);
                      $set->atribut_penggalian_id = $set_cek->atribut_penggalian_id;
                      $set->last_update_user = $this->user->user_app_id;
                      $set->last_update_date = Carbon::now();
                    }

                    $set->penggalian_id =$tempPenggalianId;
                    $set->formula_atribut_id =$maxFormulaAtributId;
                    $set->save(); 
                }
              }

            }
          }
        }
        
      }
         
        // echo 'xxxx-';exit;
      return StringFunc::json_response(200, $reqId."-".$reqRowId."-Data berhasil disimpan.");

    }

    public function addSoal(request $request)
    {
      // buat validasi
      // $validated = $request->validate([
      //       'reqTahun' => 'required',
      //       'reqFormula' => 'required',
      //       'reqKeterangan' => 'required',
      //       'reqTipeFormula' => 'required',
      // ]);

      $reqId= $request->reqId;
      $reqTipeUjian= $request->reqTipeUjian;
      $reqFormulaAssesmentUjianTahapid= $request->reqFormulaAssesmentUjianTahapid;
      $reqMenit= $request->reqMenit;
      // print_r($reqFormulaAssesmentUjianTahapid);exit;
        // echo 'xxxx-';exit;
      for($i=0; $i<count($reqTipeUjian); $i++){
        $query = new TipeUjian();
        $statement= 'and tipe_ujian_id=' .$reqTipeUjian[$i];
        $query=$query->selectByParamsMonitoring($statement)->first();
        $total_jadi=$query->total_soal_update;
        $id_sendiri=$query->id_sendiri;
        if(empty($reqFormulaAssesmentUjianTahapid[$i]))
        {
          $maxId = FormulaAssesmentUjianTahap::NextId();
          $set = new FormulaAssesmentUjianTahap();
          // nama kolom yang di insert
          $set->formula_assesment_ujian_tahap_id = $maxId;
          $set->last_create_user = $this->user->user_app_id;
          $set->menit_soal =$query->waktu;
          $set->last_create_date = Carbon::now();
        }else{           
          $set = FormulaAssesmentUjianTahap::findOrFail($reqFormulaAssesmentUjianTahapid[$i]);
          $set->formula_assesment_ujian_tahap_id = $reqFormulaAssesmentUjianTahapid[$i];
          $set->last_update_user = $this->user->user_app_id;
          $set->menit_soal =$reqMenit[$i];
          $set->last_update_date = Carbon::now();
        }

        $set->formula_assesment_id =$reqId;
        $set->tipe_ujian_id =$reqTipeUjian[$i];
        $set->jumlah_soal_ujian_tahap =$total_jadi;
        $set->save();
        if(empty($reqFormulaAssesmentUjianTahapid[$i])){
          if($query->anak!='0'){
            $query_anak = new TipeUjian();
            $statement= "and parent_id='" .$id_sendiri."'";
            $query_anak=$query_anak->selectByParamsMonitoring($statement);
            // print_r($query_anak);exit;
            foreach ($query_anak as $key => $value) {
              $maxId = FormulaAssesmentUjianTahap::NextId();
              $set = new FormulaAssesmentUjianTahap();
              // nama kolom yang di insert
              $set->formula_assesment_ujian_tahap_id = $maxId;
              $set->last_create_user = $this->user->user_app_id;
              $set->last_create_date = Carbon::now();
              $set->formula_assesment_id =$reqId;
              $set->tipe_ujian_id =$value->tipe_ujian_id;
              $set->menit_soal =$value->waktu;
              $set->jumlah_soal_ujian_tahap =$value->total_soal_update;
              $set->save(); 
            }
          }
        }
      }
      $query = new FormulaAssesmentUjianTahap();
      $query=$query->selectByParamsGenerateSoal($reqId, Carbon::now());

      return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");

    }

    public function addSoalRapid(request $request)
    {
      // buat validasi
      // $validated = $request->validate([
      //       'reqTahun' => 'required',
      //       'reqFormula' => 'required',
      //       'reqKeterangan' => 'required',
      //       'reqTipeFormula' => 'required',
      // ]);

      $reqId= $request->reqId;
      $reqTipeUjian= $request->reqTipeUjian;
      $reqFormulaAssesmentUjianTahapid= $request->reqFormulaAssesmentUjianTahapid;
      $reqMenit= $request->reqMenit;

      FormulaAssesmentUjianTahap::where('formula_assesment_id', $reqId)
      ->delete();

    //   print_r($reqFormulaAssesmentUjianTahapid);exit;
        // echo 'xxxx-';exit;
      for($i=0; $i<count($reqTipeUjian); $i++){
        $query = new TipeUjian();
        $statement= 'and tipe_ujian_id=' .$reqTipeUjian[$i];
        $query=$query->selectByParamsMonitoring($statement)->first();
        $total_jadi=$query->total_soal_update;
        $id_sendiri=$query->id_sendiri;
        // if(empty($reqFormulaAssesmentUjianTahapid[$i]))
        // {
          $maxId = FormulaAssesmentUjianTahap::NextId();
          $set = new FormulaAssesmentUjianTahap();
          // nama kolom yang di insert
          $set->formula_assesment_ujian_tahap_id = $maxId;
          $set->last_create_user = $this->user->user_app_id;
          $set->menit_soal =$query->waktu;
          $set->last_create_date = Carbon::now();
        // }else{           
        //   $set = FormulaAssesmentUjianTahap::findOrFail($reqFormulaAssesmentUjianTahapid[$i]);
        //   $set->formula_assesment_ujian_tahap_id = $reqFormulaAssesmentUjianTahapid[$i];
        //   $set->last_update_user = $this->user->user_app_id;
        //   $set->menit_soal =$reqMenit[$i];
        //   $set->last_update_date = Carbon::now();
        // }

        $set->formula_assesment_id =$reqId;
        $set->tipe_ujian_id =$reqTipeUjian[$i];
        $set->jumlah_soal_ujian_tahap =$total_jadi;
        $set->save();
        // if(empty($reqFormulaAssesmentUjianTahapid[$i])){
          if($query->anak!='0'){
            $query_anak = new TipeUjian();
            $statement= "and parent_id='" .$id_sendiri."'";
            $query_anak=$query_anak->selectByParamsMonitoring($statement);
            // print_r($query_anak);exit;
            foreach ($query_anak as $key => $value) {
              $maxId = FormulaAssesmentUjianTahap::NextId();
              $set = new FormulaAssesmentUjianTahap();
              // nama kolom yang di insert
              $set->formula_assesment_ujian_tahap_id = $maxId;
              $set->last_create_user = $this->user->user_app_id;
              $set->last_create_date = Carbon::now();
              $set->formula_assesment_id =$reqId;
              $set->tipe_ujian_id =$value->tipe_ujian_id;
              $set->menit_soal =$value->waktu;
              $set->jumlah_soal_ujian_tahap =$value->total_soal_update;
              $set->save(); 
            }
        //   }
        }
      }
      $query = new FormulaAssesmentUjianTahap();
      $query=$query->selectByParamsGenerateSoal($reqId, Carbon::now());

      return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");

    }

    public function addUrutan(request $request)
    {
      // buat validasi
      // $validated = $request->validate([
      //       'reqTahun' => 'required',
      //       'reqFormula' => 'required',
      //       'reqKeterangan' => 'required',
      //       'reqTipeFormula' => 'required',
      // ]);

      $reqId= $request->reqId;
      $reqFormulaAssesmentUjianTahapid= $request->reqFormulaAssesmentUjianTahapid;
      $reqUrutan= $request->reqUrutan;
        // echo 'xxxx-';exit;
      for($i=0; $i<count($reqFormulaAssesmentUjianTahapid); $i++){                 
        $set = FormulaAssesmentUjianTahap::findOrFail($reqFormulaAssesmentUjianTahapid[$i]);
        $set->formula_assesment_ujian_tahap_id = $reqFormulaAssesmentUjianTahapid[$i];
        $set->last_update_user = $this->user->user_app_id;
        $set->last_update_date = Carbon::now();      
        $set->urutan_tes =$reqUrutan[$i];
        $set->save();

        $query = new FormulaAssesmentUjianTahap();
        $statement=' and formula_assesment_ujian_tahap_id ='.$reqFormulaAssesmentUjianTahapid[$i];
        $query=$query->selectByParamsMonitoring($statement)->first();
        // print_r($query->tipe_ujian_id);exit;

        $query_anak = new TipeUjian();
        $statement= "and parent_id=(select id from cat.tipe_ujian where tipe_ujian_id =".$query->tipe_ujian_id.")";
        $query_anak=$query_anak->selectByParamsMonitoring($statement);
        // print_r($query_anak);exit;
        foreach ($query_anak as $key => $value) {
          // print_r($value->tipe_ujian_id); exit;
           $updated = DB::table('formula_assesment_ujian_tahap')
                  ->where('formula_assesment_id', $query->formula_assesment_id)
                  ->where('tipe_ujian_id', $value->tipe_ujian_id)
                  ->update([
                    'urutan_tes' => $reqUrutan[$i],
                    'last_update_user' => $this->user->user_app_id,
                    'last_update_date' => Carbon::now()
                  ]);
        }
      }
      return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");

    }


    public function deleteSoal(request $request)
    {
      $reqId = $request->route('id');
      $reqTipeId = $request->route('tipeId');
      FormulaAssesmentUjianTahap::where('formula_assesment_id', $reqId)
      ->where('tipe_ujian_id', $reqTipeId)
      ->delete();

      $query_anak = new TipeUjian();
      $statement= "and parent_id=( select id from cat.tipe_ujian where tipe_ujian_id= " .$reqTipeId.")";
      $query_anak=$query_anak->selectByParamsMonitoring($statement);
      // print_r($query_anak);exit;
      foreach ($query_anak as $key => $value) {
        FormulaAssesmentUjianTahap::where('formula_assesment_id', $reqId)
        ->where('tipe_ujian_id', $value->tipe_ujian_id)
        ->delete();
      }
      
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function combojenis(request $request) {

      $i = 0;

      if(empty($request->reqMode))
      {
        $arr_json[$i]['id']   = "";
        $arr_json[$i]['text'] = "Semua";
        $i++;
      }

      $arr_json[$i]['id']   = "ORGANIK";
      $arr_json[$i]['text'] = "Organik";
      $i++;
      $arr_json[$i]['id']   = "PENSIUN";
      $arr_json[$i]['text'] = "Pensiun";
      $i++;

      return $arr_json;
    }

    public function addviewlookupSoal(request $request) 
    {
      $reqFilter=$request->route('filter');
      return view('app/setting_pelaksanaan_soal_lookup', compact('reqFilter'));
    }

    public function deleteFormula(request $request)
    {
      $reqId = $request->route('id');
      SettingPelaksanaan::where('formula_id', $reqId)
      ->delete();
            
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }
}