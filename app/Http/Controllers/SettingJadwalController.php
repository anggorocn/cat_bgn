<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingJadwal;
use App\Models\SatuanKerja;
use App\Models\UserLogin;
use App\Models\JadwalAcara;
use App\Models\Penggalian;
use App\Models\JadwalAsesor;
use App\Models\JadwalPegawai;
use App\Models\FormulaAssesmentUjianTahap;
use App\Models\TipeUjian;
use App\Models\HasilUjian;
use App\Models\JadwalTes;
use App\Models\PermohonanFile;
use App\Models\AsesorBaru;
use App\Models\UjianTahapStatusUjian;
use App\Models\EssaySoal;
use App\Models\Kelompok;
use App\Models\KelompokDetil;
use App\Models\Pegawai;
use App\Models\EssayJawaban;
use App\Models\JadwalAwalTesSimulasiPegawai;
use App\Models\Log;

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

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\IOFactory;

use Carbon\Carbon;

// use Carbon\Carbon;

class SettingJadwalController extends Controller
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
        Route::get('/app/setting_jadwal/index', [SettingJadwalController::class,'index']);
        Route::get('/app/setting_jadwal/edit/{view?}/{id?}/{iddll?}', [SettingJadwalController::class,'addviewEdit']);
        Route::get('/app/setting_jadwal/add/{id?}/{view?}', [SettingJadwalController::class,'addview']);
        Route::get('/app/setting_jadwal/add_kelompok/{id?}/{detilid?}', [SettingJadwalController::class,'addviewkelompokadd']);
        Route::get('/app/setting_jadwal/absensi/{id?}/{view?}', [SettingJadwalController::class,'addviewabsensi']);
        Route::get('/app/setting_jadwal/acara/{id?}/{reqDetilId?}', [SettingJadwalController::class,'addviewacara']);
        Route::get('/app/setting_jadwal/acarahead/{view?}/{id?}/{reqDetilId?}', [SettingJadwalController::class,'addviewacaraHead']);
        Route::get('/app/setting_jadwal/asesor/{id?}/{reqDetilId?}', [SettingJadwalController::class,'addviewasesor']);
        Route::get('/app/setting_jadwal/asesordetil/{id?}/{reqDetilId?}', [SettingJadwalController::class,'addviewasesordetil']);
        Route::get('/app/setting_jadwal/pegawai/{id?}/{reqDetilId?}/{reqPenggalianId?}', [SettingJadwalController::class,'addviewpegawai']);
        Route::get('/app/setting_jadwal/pegawaidetil/{id?}/{reqDetilId?}/{reqPenggalianId?}', [SettingJadwalController::class,'addviewpegawaidetil']);
        Route::get('/app/setting_jadwal/pegawaidetilkelompok/{id?}/{reqDetilId?}/{reqPenggalianId?}', [SettingJadwalController::class,'pegawaidetilkelompok']);
        Route::get('/app/setting_jadwal/file/{id?}/{view?}', [SettingJadwalController::class,'addviewfile']);
        Route::get('/app/setting_jadwal/rekapfile/{id?}/{view?}', [SettingJadwalController::class,'addviewrekapfile']);
        Route::get('/app/setting_jadwal/mulai/{id?}/{view?}', [SettingJadwalController::class,'addviewmulai']);
        Route::get('/app/setting_jadwal/rekapasesor/{id?}/{view?}', [SettingJadwalController::class,'addviewrekapasesor']);
        Route::get('/app/setting_jadwal/progress/{id?}/{view?}', [SettingJadwalController::class,'addviewprogress']);
        Route::get('/app/setting_jadwal/rekappenggalian/{id?}/{view?}', [SettingJadwalController::class,'addviewrekappenggalian']);
        Route::get('/app/setting_jadwal/ujian/{id?}/{view?}', [SettingJadwalController::class,'addviewujian']);
        Route::get('/app/setting_jadwal/lookup/asesor/{id?}/{filter?}', [SettingJadwalController::class,'addviewlookupAsesor']);
        Route::get('/app/setting_jadwal/lookup/pegawai/{reqId?}/{reqPenggalianId?}', [SettingJadwalController::class,'addviewlookupPegawai']);
        Route::get('/app/setting_jadwal/lookup/pegawai_kelompok/{reqId?}/', [SettingJadwalController::class,'addviewlookupPegawaiKelompok']);
        Route::get('/app/setting_jadwal/lookup/pegawai_kelompok_pilih/{reqId?}/{reqPenggalianId?}', [SettingJadwalController::class,'addviewlookupPegawaiKelompokPilih']);
        Route::get('/app/setting_jadwal/lookup/kegiatan_file/{reqTipe?}/{filter?}', [SettingJadwalController::class,'addviewlookupKegiatanFile']);
        Route::get('/app/setting_jadwal/hasil/{reqId?}/{tipeUjian?}', [SettingJadwalController::class,'addviewhasil']);
        Route::get('/app/setting_jadwal/upload/{reqId?}', [SettingJadwalController::class,'addviewupload']);
        Route::get('/app/setting_jadwal/rekap_upload/{reqId?}', [SettingJadwalController::class,'addviewrekapupload']);
        Route::get('/app/setting_jadwal/jawaban/{reqUjianId?}/{reqTipeUjian?}/{reqId?}', [SettingJadwalController::class,'addviewjawaban']);
        Route::get('/app/setting_jadwal/jawaban_sjt/{reqUjianId?}/{reqTipeUjian?}/{reqId?}', [SettingJadwalController::class,'addviewjawabanSjt']);
        Route::get('/app/setting_jadwal/jawaban_essay/{reqId?}/{pegawaiId?}', [SettingJadwalController::class,'addviewjawabanessay']);
        Route::get('/app/setting_jadwal/kelompok/{reqId?}/{reqDetilId?}', [SettingJadwalController::class,'addviewkelompok']);
        Route::get('/app/setting_jadwal/add_kelompok_anggota/{id?}/{detilid?}', [SettingJadwalController::class,'addviewkelompokanggota']);
        Route::get('/app/setting_jadwal/lihat_detil/{id?}/{tipeujianid?}', [SettingJadwalController::class,'addviewlihatdetil']);
        // Route::get('/app/pegawai/lookup/{link?}/{id?}', [PegawaiController::class,'lookup']);

        //buat route proses
        Route::get('SettingJadwal/json/{id?}', [SettingJadwalController::class,'json']);
        Route::get('SettingJadwal/jsonasesor/{reqId?}/{reqIdFilter?}', [SettingJadwalController::class,'jsonAsesor']);
        Route::get('SettingJadwal/jsonpegawai/{reqId?}/{reqPenggalianId?}/{reqIdFilter?}', [SettingJadwalController::class,'jsonPegawai']);
        Route::get('SettingJadwal/jsonpegawaikelompok/{reqId?}/{reqIdFilter?}', [SettingJadwalController::class,'jsonpegawaikelompok']);
        Route::get('SettingJadwal/jsonpegawaikelompokPilih/{reqId?}/{reqIdFilter?}', [SettingJadwalController::class,'jsonpegawaikelompokPilih']);
        Route::get('SettingJadwal/jsonHasil/{reqId?}/{reqTipeUjian?}', [SettingJadwalController::class,'jsonHasil']);
        Route::get('SettingJadwal/jsonEssay/{id?}', [SettingJadwalController::class,'jsonEssay']);
        Route::get('SettingJadwal/jsonSoal/{reqTipe?}/{id?}', [SettingJadwalController::class,'jsonSoal']);
        Route::get('SettingJadwal/jsonKelompok/{id?}', [SettingJadwalController::class,'jsonKelompok']);
        // Route::get('Pegawai/json/', [PegawaiController::class,'json']);
        Route::post('SettingJadwal/addAcara/{id?}', [SettingJadwalController::class,'addAcara']);
        Route::post('SettingJadwal/addAsesor/{id?}', [SettingJadwalController::class,'addAsesor']);
        Route::post('SettingJadwal/AddPegawai/{id?}', [SettingJadwalController::class,'AddPegawai']);
        Route::post('SettingJadwal/AddPegawaiKelompok/{id?}', [SettingJadwalController::class,'AddPegawaiKelompok']);
        Route::post('SettingJadwal/addUpload/{id?}', [SettingJadwalController::class,'addUpload']);
        Route::post('SettingJadwal/addEssay/{id?}', [SettingJadwalController::class,'addEssay']);
        Route::post('SettingJadwal/addKelompok/', [SettingJadwalController::class,'addKelompok']);
        Route::post('SettingJadwal/addKelompokAnggota/', [SettingJadwalController::class,'addKelompokAnggota']);
        Route::post('SettingJadwal/EditStatus/{id?}', [SettingJadwalController::class,'EditStatus']);
        Route::post('SettingJadwal/resetEssay/{id?}/{idpeg?}/{idsoal?}', [SettingJadwalController::class,'resetEssay']);
        Route::post('SettingJadwal/deleteEssay/{id?}/{idpeg?}/{idsoal?}', [SettingJadwalController::class,'deleteEssay']);
        // Route::delete('Pegawai/delete/{id}',[ PegawaiController::class, "delete" ]);

        Route::delete('SettingJadwal/deleteAsesor/{id}',[ SettingJadwalController::class, "deleteAsesor" ]);
        Route::delete('SettingJadwal/deletePegawai/{id}',[ SettingJadwalController::class, "deletePegawai" ]);
        Route::delete('SettingJadwal/deletePegawaiKelompok/{id}/{ujianid}/{asesorid}/{penggalianid}',[ SettingJadwalController::class, "deletePegawaiKelompok" ]);
        Route::delete('SettingJadwal/deleteKelompokPegawai/{id}',[ SettingJadwalController::class, "deleteKelompokPegawai" ]);
        Route::delete('SettingJadwal/deleteUpload/{id}',[ SettingJadwalController::class, "deleteUpload" ]);
        Route::delete('SettingJadwal/reset/{JadwalId?}/{TipeUjianId?}/{id?}',[ SettingJadwalController::class, "reset" ]);
        Route::delete('SettingJadwal/deleteKelompok/{id?}',[ SettingJadwalController::class, "deleteKelompok" ]);
        Route::delete('SettingJadwal/deleteAcara/{id?}',[ SettingJadwalController::class, "deleteAcara" ]);

        Route::post('SettingJadwal/ImportExcelKelompok/{id?}/{kelompokid?}', [SettingJadwalController::class, 'ImportExcelKelompok']);
        Route::post('SettingJadwal/ImportExcelAsesi/{reqId?}/{reqDetilId?}/{reqPenggalianId?}', [SettingJadwalController::class, 'ImportExcelAsesi']);
        Route::post('SettingJadwal/addKelompokSemua/{id?}/{detilid?}', [SettingJadwalController::class, 'addKelompokSemua']);

    }
    public function index(request $request) {
     $satuan_kerja = new SatuanKerjaController();
     // $cabangid=$this->CABANG_ID;
     // $satker=$satuan_kerja->combo_cabang($request,$cabangid);

     $jenis='x';
     // dd($jenis);
     // return view("app/pegawai/index",compact('satker','cabangid','jenis'));
     return view("app/setting_jadwal",compact('jenis'));
    }



     public function jsonSoal(request $request)
    {
        $reqId = $request->route('id');
        $reqTipe = $request->route('reqTipe');
        // dd($reqUnitKerja);
        $query= new PermohonanFile();

        if(!empty($reqId)){
          $statement=' and kegiatan_file_id not in ('.$reqId.')';
        }
        else{
          $statement='';
        }

        $statement.=" and jenis='".$reqTipe."'";

        $query=$query->selectByParamsFileBaru($statement);
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $disini="'".$row->nama."'";
          $btn = '<a onclick="tampil('.$row->kegiatan_file_id.','.$disini.')" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }

    public function json(request $request)
    {
        $reqPencarian = isset($_GET['reqPencarian']) ? $_GET['reqPencarian'] : null;
       
        $statement='';
        if(!empty($reqPencarian)){
          $statement.=" and (UPPER(acara) like UPPER('%".$reqPencarian."%') OR nama_tipe like UPPER('%".$reqPencarian."%') OR TO_CHAR(CURRENT_DATE, 'YYYY-MM-DD') like UPPER('%".$reqPencarian."%') OR keterangan like UPPER('%".$reqPencarian."%') )";
        }
       
        $query= new SettingJadwal();

        $query=$query->selectByParamsMonitoring($statement);
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $btn = '<a href="'.url('app/setting_jadwal/add/'.$row->jadwal_tes_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span</a>';
          // $btn .= '<a onclick=\'deletedata("'.$row->jadwal_tes_id.'")\' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }

    public function jsonAsesor(request $request)
    {
        // dd($reqUnitKerja);
        $reqId = $request->route('reqId');
        $reqIdFilter = $request->route('reqIdFilter');
        // dd($reqUnitKerja);
        // echo $reqIdFilter;exit;

        if(!empty($reqIdFilter)){
          $statement=' and a.asesor_id not in ('.$reqIdFilter.')';
        }
        else{
          $statement='';
        }

          $statement.=' and asesor_id not in ( select asesor_id from jadwal_asesor where jadwal_acara_id='.$reqId.')';
        
        $query= new JadwalAsesor();
        // $statement.=' AND A.JADWAL_AWAL_TES_ID = '.$reqId;
        $query=$query->selectByParamsMonitoringLookup($statement);

        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $disini="'".$row->nama."'";
          $btn = '<a onclick="tampil('.$row->asesor_id.','.$disini.')" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }

    public function jsonPegawai(request $request)
    {
        // dd($reqUnitKerja);
        // $reqId = $request->route('id');
        $reqIdFilter = $request->route('reqIdFilter');
        $reqId = $request->route('reqId');
        $reqPenggalianId = $request->route('reqPenggalianId');
        // dd($reqUnitKerja);
        // echo $reqIdFilter;exit;

        if(!empty($reqIdFilter)){
          $statement=' and a.pegawai_id not in ('.$reqIdFilter.')';
        }
        else{
          $statement='';
        }

        
        $query= new JadwalPegawai();
        // $statement.=' AND A.JADWAL_AWAL_TES_ID = '.$reqId;
        $query=$query->selectByParamsMonitoringLookup($reqId,$reqPenggalianId, $statement);

        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $disini="'".$row->nama."'";
          $disini2="'".$row->nip_baru."'";
          $btn = '<a onclick="tampil('.$row->idpeg.','.$disini.','.$disini2.')" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }

    public function jsonpegawaikelompok(request $request)
    {
        // dd($reqUnitKerja);
        // $reqId = $request->route('id');
        $reqIdFilter = $request->route('reqIdFilter');
        $reqId = $request->route('reqId');
        // dd($reqUnitKerja);
        // echo $reqIdFilter;exit;

        if(!empty($reqIdFilter)){
          $statement=' and a.pegawai_id not in ('.$reqIdFilter.')';
        }
        else{
          $statement='';
        }

        
        $query= new Kelompok();
        // $statement.=' AND A.JADWAL_AWAL_TES_ID = '.$reqId;
        $query=$query->selectByParamsMonitoringLookup($reqId, $statement);

        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $disini="'".$row->nama."'";
          $disini2="'".$row->nip_baru."'";
          $btn = '<a onclick="tampil('.$row->idpeg.','.$disini.','.$disini2.')" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }


    public function jsonpegawaikelompokPilih(request $request)
    {
        // dd($reqUnitKerja);
        // $reqId = $request->route('id');
        $reqIdFilter = $request->route('reqIdFilter');
        $reqId = $request->route('reqId');
        // dd($reqUnitKerja);
        // echo $reqIdFilter;exit;

        if(!empty($reqIdFilter)){
          $statement=' and a.kelompok_id not in ('.$reqIdFilter.')';
        }
        else{
          $statement='';
        }

        
        $query= new Kelompok();
        $statement.=' AND b.total != 0';
        $query=$query->selectByParamsMonitoringLookupMaster($reqId, $statement);

        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $disini="'".$row->nama."'";
          $btn = '<a onclick="tampil('.$row->kelompok_id.','.$disini.')" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }

    public function jsonEssay(request $request)
    {
        $reqId = $request->route('id');
        $query= new PermohonanFile();
        // $statement=' AND jp.jadwal_awal_tes_simulasi_id = '.$reqId;
        $query=$query->selectByParamsMonitoringHasil($reqId);

        return Datatables::of($query)
        ->addColumn('status_html', function ($row) {
          $btn = $row->status;

          return $btn;
        })
        ->rawColumns(['status_html'])
        ->addIndexColumn()
        
        ->make(true);
    }

    public function jsonKelompok(request $request)
    {
        $reqId = $request->route('id');
        $query= new Kelompok();
        $query=$query->selectByParams();

        return Datatables::of($query)
        ->addColumn('aksi', function ($row) use ($reqId) {
          $btn = '<a href="app/setting_jadwal/add_kelompok/'.$reqId.'/'.$row->kelompok_id.'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span</a>';
          $btn .= '<a href="app/setting_jadwal/add_kelompok_anggota/'.$reqId.'/'.$row->kelompok_id.'" data-original-title="Detail" class="btn btn-primary mr-1 btn-sm detailProduct"><span class="fa fa-users"></span</a>';
          // $btn .= '<a onclick=\'deletedata("'.$row->kelompok_id.'")\' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }
    
    public function jsonHasil(request $request)
    {
      $reqId = $request->route('reqId');
      $reqTipeUjian = $request->route('reqTipeUjian');
      
      $pg='setting_jadwal_hasil';
      $statement=" and tipe_ujian_id=".$reqTipeUjian;
      $query = new TipeUjian();
      $query=$query->selectByParamsMonitoring($statement)->first();
      $reqKeteranganUjian=$query->keterangan_ujian;
      
      $statement= "";
      $statementdetil= " AND A.JADWAL_TES_ID = ".$reqId;
    
      $query= new HasilUjian();
      // $statement.=' AND A.JADWAL_AWAL_TES_ID = '.$reqId;
      if($reqTipeUjian==1){
          
        $statementdetil= " AND A.JADWAL_TES_ID = ".$reqId;
        $query=$query->selectByParamsMonitoringCfitHasilRekapA($reqId,$reqTipeUjian, $statement, $statementdetil);
      }
      else if($reqTipeUjian==2){
        $statementdetil= " AND A.JADWAL_TES_ID = ".$reqId;
        $query=$query->selectByParamsMonitoringCfitHasilRekapB($reqId,$reqTipeUjian, $statement, $statementdetil);
      }
      else if($reqTipeUjian==7){
        $statement = " AND B.JADWAL_TES_ID = ".$reqId;
        $query=$query->selectByParamsMonitoringPapiHasil($reqId,$statement);
      }
      else if($reqTipeUjian==94){
        $statement = " AND B.JADWAL_TES_ID = ".$reqId;
        $query=$query->selectByParamsMonitoringKeterangan($reqId,$reqTipeUjian);
      }
      else if($reqTipeUjian==40){
        $statement = " AND A.JADWAL_TES_ID = ".$reqId;
        $query=$query->selectByParamsMonitoringPf16($reqId,$statement);
      }
      else if($reqTipeUjian==41){
        $statement = " AND A.JADWAL_TES_ID = ".$reqId;
        $query=$query->selectByParamsMonitoringMbtiNew($reqId,$statement);
      }
      else if($reqTipeUjian==42){
        $statement = " AND A.JADWAL_TES_ID = ".$reqId;
        $query=$query->selectByParamsMonitoringDisc($reqId,$statement);
      }
      else if($reqTipeUjian==18){
        $statement = " AND A.JADWAL_TES_ID = ".$reqId;
        $query=$query->selectByParamsMonitoringIst($reqId,$statement);
      }
      else if($reqKeteranganUjian=='SJT'){
        $statement = " AND A.JADWAL_TES_ID = ".$reqId;
        $query=$query->selectByParamsMonitoringSJT($reqId,$reqTipeUjian,$statement);
      }
      else{
        $query=$query->selectByParamsMonitoringCfitHasilRekapA($reqId,$reqTipeUjian, $statement, $statementdetil);
      }
      return Datatables::of($query)
      ->addColumn('aksi', function ($row) {
        $btn = '';

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

      $pg='setting_jadwal_add';
      $statement=" and jadwal_tes_id=".$reqId;
      $query = new SettingJadwal();
      $query=$query->selectByParamsMonitoring($statement)->first();

      $asesor = new AsesorBaru();
      $asesor=$asesor->selectByParamsAsesor();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_jadwal_add', compact('query','reqId','pg','asesor'));
    }

    public function addviewkelompokadd(request $request)
    {
      $reqId=$request->route('id');
      $reqDetilId = $request->route('detilid');
      if(empty($reqDetilId)){
        $reqDetilId=-1;
      }
      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $statement=" and kelompok_id=".$reqDetilId;
      $query = new Kelompok();
      $query=$query->selectByParams($statement)->first();

      $pg='setting_jadwal_kelompok';
      return view('app/setting_jadwal_add_kelompok', compact('reqId','pg','query'));
    }

    public function addviewkelompokanggota(request $request)
    {
      $reqId=$request->route('id');
      $reqDetilId = $request->route('detilid');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $statement=" and kelompok_id=".$reqDetilId;
      $query = new Kelompok();
      $query=$query->selectByParams($statement)->first();

      $IdentitasUjian = new JadwalTes();
      $statement=' and jadwal_tes_id='. $reqId;
      $IdentitasUjian=$IdentitasUjian->selectByParamsMonitoring($statement)->first();

      $querypeserta = new KelompokDetil();
      $statement=' and kelompok_id='. $reqDetilId. ' and jadwal_tes_id='. $reqId;
      $querypeserta=$querypeserta->selectByParams($statement);

      $pg='setting_jadwal_kelompok';

      return view('app/setting_jadwal_add_kelompok_anggota', compact('reqId','pg','query','IdentitasUjian','querypeserta'));
    }

    public function addviewhasil(request $request)
    {
      $reqId=$request->route('reqId');
      $reqTipeUjian = $request->route('tipeUjian');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $pg='setting_jadwal_hasil';
      $statement=" and tipe_ujian_id=".$reqTipeUjian;
      $query = new TipeUjian();
      $query=$query->selectByParamsMonitoring($statement)->first();

      $statement=" and parent_id='".$query->id."'";
      $child = new TipeUjian();
      $child=$child->selectByParamsMonitoring($statement);

      $statement=" and jadwal_tes_id=".$reqId;
      $queryFormula = new SettingJadwal();
      $queryFormula=$queryFormula->selectByParamsMonitoring($statement)->first();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_jadwal_hasil', compact('query','reqId','pg','reqTipeUjian','child','queryFormula'));
    }

    public function addviewupload(request $request)
    {
      $reqId=$request->route('reqId');

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $statement=" and jadwal_tes_id=".$reqId;
      $query = new JadwalTes();
      $query=$query->selectByParamsMonitoring($statement)->first();

      $reqTanggalTes = explode(' ',$query->tanggal_tes);
      $reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
      $tempTahun = DateFunc::getYear($reqTanggalTes);

      $query = new PermohonanFile();
      $statement= " and A.KODE != 'PE'";
      $query=$query->selectByParamsPenggalianNew($tempTahun,$reqId,$statement);

      $batas = new JadwalTes();
      $statement='';
      $batas=$batas->selectByParamsMonitoring($statement)->first();

      $pg='setting_jadwal_upload';
      return view('app/setting_jadwal_upload', compact('query','reqId','pg','batas'));
    }

    public function addviewrekapupload(request $request)
    {
      $reqId=$request->route('reqId');

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $statement=" and jadwal_tes_id=".$reqId;
      $query = new JadwalTes();
      $query=$query->selectByParamsMonitoring($statement)->first();

      $reqTanggalTes = explode(' ',$query->tanggal_tes);
      $reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
      $tempTahun = DateFunc::getYear($reqTanggalTes);

      $query = new PermohonanFile();
      $query=$query->selectByParamsPenggalianNew($tempTahun,$reqId);

      $pg='setting_jadwal_rekap_upload';
      return view('app/setting_jadwal_rekap_upload', compact('query','reqId','pg'));
    }

    public function addviewjawaban20250110(request $request)
    {
      $reqUjianId=$request->route('reqUjianId');
      $reqTipeUjian=$request->route('reqTipeUjian');
      $reqId=$request->route('reqId');

      if($reqTipeUjian == "1")
      {
        $statement= " AND a.TIPE_UJIAN_ID IN (8,9,10,11)";
      }
      elseif($reqTipeUjianId == "2")
      {
        $statement= " AND a.TIPE_UJIAN_ID IN (12,13,14,15)";
      }

      $statement.=" and pegawai_id =".$reqId;
      $query = new JadwalTes();
      $query=$query->selectByParamsLihatJawabanCFID($reqUjianId,$statement);
      // print_r($query);exit;
      return view('app/setting_jadwal_jawaban', compact('query'));
    }

    public function addviewjawaban(request $request)
    {
      $reqUjianId=$request->route('reqUjianId');
      $reqTipeUjian=$request->route('reqTipeUjian');
      $reqId=$request->route('reqId');

      if($reqTipeUjian == "1")
      {
        $statement= " AND b.TIPE_UJIAN_ID IN (8,9,10,11)";
      }
      elseif($reqTipeUjian == "2")
      {
        $statement= " AND b.TIPE_UJIAN_ID IN (12,13,14,15)";
      }

      $statement.=" and a.pegawai_id =".$reqId;
      $querySoal = new JadwalTes();
      $querySoal=$querySoal->selectByParamsSoalCfid($reqUjianId,$statement);

      $queryJawaban = new JadwalTes();
      $queryJawaban=$queryJawaban->selectByParamsJawabanCfid($reqUjianId,$statement);

      $queryJawabanPegawai = new JadwalTes();
      $queryJawabanPegawai=$queryJawabanPegawai->selectByParamsJawabanPegawaiCfid($reqUjianId,$statement);

      $queryDataJawabanPegawai = new JadwalTes();
      $queryDataJawabanPegawai=$queryDataJawabanPegawai->selectByParamsCheckJawabanPegawai($reqUjianId,$statement);

      $queryJawabanBenar = new JadwalTes();
      $queryJawabanBenar=$queryJawabanBenar->selectByParamsJawabanBenarCFID($reqUjianId,$statement);
    //   print_r($queryJawabanPegawai);exit;
      return view('app/setting_jadwal_jawaban', compact('querySoal','queryJawaban','queryJawabanPegawai','queryDataJawabanPegawai','queryJawabanBenar'));
    }

    public function addviewjawabanSjt(request $request)
    {
      $reqUjianId=$request->route('reqUjianId');
      $reqTipeUjian=$request->route('reqTipeUjian');
      $reqId=$request->route('reqId');

      $statement= " AND b.TIPE_UJIAN_ID =".$reqTipeUjian;
     
      $statement.=" and a.pegawai_id =".$reqId;
      $querySoal = new JadwalTes();
      $querySoal=$querySoal->selectByParamsSoalCfid($reqUjianId,$statement);

      $queryJawaban = new JadwalTes();
      $queryJawaban=$queryJawaban->selectByParamsJawabanCfid($reqUjianId,$statement);

      $queryJawabanPegawai = new JadwalTes();
      $queryJawabanPegawai=$queryJawabanPegawai->selectByParamsJawabanPegawaiCfid($reqUjianId,$statement);

      $queryDataJawabanPegawai = new JadwalTes();
      $queryDataJawabanPegawai=$queryDataJawabanPegawai->selectByParamsCheckJawabanPegawai($reqUjianId,$statement);

      $queryJawabanBenar = new JadwalTes();
      $queryJawabanBenar=$queryJawabanBenar->selectByParamsJawabanBenarCFID($reqUjianId,$statement);
      // print_r($queryJawabanPegawai);exit;
      return view('app/setting_jadwal_jawaban_sjt', compact('querySoal','queryJawaban','queryJawabanPegawai','queryDataJawabanPegawai','queryJawabanBenar'));
    }

    public function addviewjawabanessay(request $request)
    {
      $reqId=$request->route('reqId');
      $pegawaiId=$request->route('pegawaiId');
      $statement=" and ujian_id=".$reqId." and a.pegawai_id =".$pegawaiId;
      $query = new PermohonanFile();
      $query=$query->selectByParamsPenggalianAsesorJawaban($statement);
      return view('app/setting_jadwal_jawaban_essay', compact('query'));
    }

    public function addviewabsensi(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $query = new SettingJadwal();
      $query=$query->selectByParamsMonitoring($reqId)->first();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_jadwal_absensi', compact('query',));
    }

    public function addviewacara(request $request)
    {
      $reqId=$request->route('id');
      $reqDetilId = $request->route('reqDetilId');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $pg='setting_jadwal_acara';

      $comboPenggalian = new Penggalian();
      // $statement=' and tahun='. date('Y');
      $comboPenggalian=$comboPenggalian->selectByParamsMonitoring($reqId);
      // print_r($comboPenggalian);exit;

      $IdentitasUjian = new JadwalTes();
      $statement=' and jadwal_tes_id='. $reqId;
      $IdentitasUjian=$IdentitasUjian->selectByParamsMonitoring($statement)->first();
      
      if(empty($reqDetilId))
      {
        $query = "";
        // return view('app/pegawai.add', compact('query','jenis','satker','reqUnitKerjaId'));
        return view('app/setting_jadwal_acara', compact('query','reqId','pg','reqDetilId','comboPenggalian','IdentitasUjian'));
      }
      else
      {
        $query = new JadwalAcara();
        $statement=' and jadwal_acara_id='. $reqDetilId;
        $query=$query->selectByParamsMonitoring($statement)->first();
        //buat tes sqli
        // $query=$query->selectByParamsSqlI($reqId)->first();
        return view('app/setting_jadwal_acara', compact('query','reqId','pg','reqDetilId','comboPenggalian','IdentitasUjian'));
      }
    }

    public function addviewacaraHead(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');
      $reqDetilId = $request->route('reqDetilId');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $query = new JadwalAcara();
      $statement=' and jadwal_tes_id='. $reqId;
      $query=$query->selectByParamsMonitoring($statement);
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      $pg='setting_jadwal_acara';
      return view('app/setting_jadwal_acara_head', compact('query','reqId','pg','reqDetilId'));
    }

    public function addviewasesor(request $request)
    {
      $reqId=$request->route('id');
      $reqDetilId = $request->route('reqDetilId');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $queryhead = new JadwalAcara();
      $statement=' and a.jadwal_tes_id='. $reqId;
      $queryhead=$queryhead->selectByParamsMonitoring($statement);

      $IdentitasUjian = new JadwalTes();
      $statement=' and jadwal_tes_id='. $reqId;
      $IdentitasUjian=$IdentitasUjian->selectByParamsMonitoring($statement)->first();

      if(empty($reqDetilId)){
        $query='';
      }
      else{
        $query = new JadwalAsesor();
        $statement=' and a.jadwal_acara_id='. $reqDetilId;
        $query=$query->selectByParamsMonitoring($statement);        
      }

      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      $pg='setting_jadwal_asesor';
      return view('app/setting_jadwal_asesor', compact('queryhead','reqId','pg','reqDetilId','query','IdentitasUjian'));
    }

    public function addviewasesordetil(request $request)
    {
      $reqId=$request->route('id');
      $reqDetilId = $request->route('reqDetilId');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $queryhead = new JadwalAcara();
      $statement=' and a.jadwal_tes_id='. $reqId;
      $queryhead=$queryhead->selectByParamsMonitoring($statement);

      $IdentitasUjian = new JadwalTes();
      $statement=' and jadwal_tes_id='. $reqId;
      $IdentitasUjian=$IdentitasUjian->selectByParamsMonitoring($statement)->first();

      if(empty($reqDetilId)){
        $query='';
      }
      else{
        $query = new JadwalAsesor();
        $statement=' and a.jadwal_acara_id='. $reqDetilId;
        $query=$query->selectByParamsMonitoring($statement);        
      }

      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      $pg='setting_jadwal_asesor';
      return view('app/setting_jadwal_asesor_detil', compact('queryhead','reqId','pg','reqDetilId','query','IdentitasUjian'));
    }

    public function addviewpegawai(request $request)
    {
      $reqId=$request->route('id');
      $reqDetilId = $request->route('reqDetilId');
      $reqPenggalianId = $request->route('reqPenggalianId');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $query = '';

      $queryhead = new JadwalAsesor();
      $statement=' and a.jadwal_tes_id='. $reqId;
      $queryhead=$queryhead->selectByParamsMonitoring($statement);

      $IdentitasUjian = new JadwalTes();
      $statement=' and jadwal_tes_id='. $reqId;
      $IdentitasUjian=$IdentitasUjian->selectByParamsMonitoring($statement)->first();

      if(empty($reqDetilId)){
        $query='';
      }
      else{
        $query = new JadwalPegawai();
        $statement=' and a.jadwal_asesor_id='. $reqDetilId;
        $query=$query->selectByParamsMonitoring($statement);        
      }
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      $pg='setting_jadwal_pegawai';
      return view('app/setting_jadwal_pegawai', compact('query','reqId','pg','reqDetilId','queryhead','reqPenggalianId','IdentitasUjian'));
    }

    public function addviewpegawaidetil(request $request)
    {
      $reqId=$request->route('id');
      $reqDetilId = $request->route('reqDetilId');
      $reqPenggalianId = $request->route('reqPenggalianId');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $query = '';

      $queryhead = new JadwalAsesor();
      $statement=' and a.jadwal_tes_id='. $reqId;
      $queryhead=$queryhead->selectByParamsMonitoring($statement);

      $IdentitasUjian = new JadwalTes();
      $statement=' and jadwal_tes_id='. $reqId;
      $IdentitasUjian=$IdentitasUjian->selectByParamsMonitoring($statement)->first();

      if(empty($reqDetilId)){
        $query='';
      }
      else{
        $query = new JadwalPegawai();
        $statement=' and a.jadwal_asesor_id='. $reqDetilId;
        $query=$query->selectByParamsMonitoring($statement);        
      }
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      $pg='setting_jadwal_pegawai';
      return view('app/setting_jadwal_pegawai_detil', compact('query','reqId','pg','reqDetilId','queryhead','reqPenggalianId','IdentitasUjian'));
    }

    public function pegawaidetilkelompok(request $request)
    {
      $reqId=$request->route('id');
      $reqDetilId = $request->route('reqDetilId');
      $reqPenggalianId = $request->route('reqPenggalianId');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $query = '';

      $queryhead = new JadwalAsesor();
      $statement=' and a.jadwal_tes_id='. $reqId;
      $queryhead=$queryhead->selectByParamsMonitoring($statement);

      $IdentitasUjian = new JadwalTes();
      $statement=' and jadwal_tes_id='. $reqId;
      $IdentitasUjian=$IdentitasUjian->selectByParamsMonitoring($statement)->first();

      if(empty($reqDetilId)){
        $query='';
      }
      else{
        $query = new Kelompok();
        $statement=' and a.kelompok_id in(
          select kelompok_id from jadwal_pegawai where  id_jadwal = '.$reqId.' and penggalian_id='.$reqPenggalianId.' and jadwal_asesor_id='.$reqDetilId.'
        )';
        $query=$query->selectByParamsMonitoringLookupMaster($reqId,$statement);        
      }
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      $pg='setting_jadwal_pegawai';
      return view('app/setting_jadwal_pegawai_detil_kelompok', compact('query','reqId','pg','reqDetilId','queryhead','reqPenggalianId','IdentitasUjian'));
    }

    public function addviewkelompok(request $request)
    {
      $reqId=$request->route('reqId');
      $reqDetilId=$request->route('reqDetilId');

      $queryhead = new Kelompok();
      $statement=' and a.jadwal_tes_id='. $reqId;
      $queryhead=$queryhead->selectByParams();

      $query = new KelompokDetil();
      // $statement=' and a.jadwal_tes_id='. $reqId;
      $query=$query->selectByParams();

      $IdentitasUjian = new JadwalTes();
      $statement=' and jadwal_tes_id='. $reqId;
      $IdentitasUjian=$IdentitasUjian->selectByParamsMonitoring($statement)->first();

      $total= new Kelompok();
      $statement=' AND c.total != 0';
      $total=$total->selectByParamsMonitoringLookup($reqId, $statement);
      // print_r($total);exit;

      $pg='setting_jadwal_kelompok';

      return view('app/setting_jadwal_kelompok', compact('reqId','queryhead','query','IdentitasUjian','pg','reqDetilId','total'));
    }

    public function addviewfile(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $query = new SettingJadwal();
      $query=$query->selectByParamsMonitoring($reqId)->first();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_jadwal_add', compact('query',));
    }

    public function addviewrekapfile(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $query = new SettingJadwal();
      $query=$query->selectByParamsMonitoring($reqId)->first();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_jadwal_add', compact('query',));
    }

    public function addviewmulai(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $query = new SettingJadwal();
      $query=$query->selectByParamsMonitoring($reqId)->first();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      $pg='setting_jadwal_mulai';
      return view('app/setting_jadwal_mulai', compact('query','reqId','pg'));
    }

    public function addviewrekapasesor(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $query = new SettingJadwal();
      $query=$query->selectByParamsMonitoring($reqId)->first();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_jadwal_add', compact('query',));
    }

    public function addviewprogress(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $query = new SettingJadwal();
      $query=$query->selectByParamsMonitoring($reqId)->first();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_jadwal_add', compact('query',));
    }

    public function addviewrekappenggalian(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $query = new SettingJadwal();
      $query=$query->selectByParamsMonitoring($reqId)->first();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_jadwal_add', compact('query',));
    }

    public function addviewujian(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $query = new SettingJadwal();
      $query=$query->selectByParamsMonitoring($reqId)->first();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_jadwal_add', compact('query',));
    }

    public function addviewlihatdetil(request $request)
    {
      $reqId=$request->route('id');
      $reqTipeUjian = $request->route('tipeujianid');
// print_r($reqId);exit;
      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

        $arrTipeUjian=array();
        $statement=" AND a.formula_assesment_id = (select xx.formula_id from jadwal_tes x  LEFT JOIN formula_eselon xx on x. formula_eselon_id = xx.formula_eselon_id where jadwal_tes_id=". $reqId.") and parent_id='0'";
        $query = new FormulaAssesmentUjianTahap();
        $query=$query->selectByParamsMonitoring($statement);
        foreach ($query as $rowData) {
          array_push($arrTipeUjian, $rowData->tipe_ujian_id);
        }

        $arrayVal=array();

        $query= new HasilUjian();      
        $statement= "";
        $statementdetil= " AND A.JADWAL_TES_ID = ".$reqId;

        if (in_array(1, $arrTipeUjian)){
          $query=$query->selectByParamsMonitoringCfitHasilRekapA($reqId,1, $statement, $statementdetil);
        }
        if (in_array(2, $arrTipeUjian)){
          $query=$query->selectByParamsMonitoringCfitHasilRekapB($reqId,2, $statement, $statementdetil);
        }
        // print_r($query);exit;

        foreach ($query as $rowData) {
          $arrayVal[$rowData->pegawai_id]['pegawai_id']=$rowData->pegawai_id;
          $arrayVal[$rowData->pegawai_id]['nama_pegawai']=$rowData->nama_pegawai;
          $arrayVal[$rowData->pegawai_id]['nip_baru']=$rowData->nip_baru;
          $arrayVal[$rowData->pegawai_id]['last_jabatan']=$rowData->last_jabatan;
          $arrayVal[$rowData->pegawai_id]['nilai_hasil']=$rowData->nilai_hasil;
          if($rowData->nilai_hasil<79){
            $arrayVal[$rowData->pegawai_id]['rating1']='1';
          }
          else if($rowData->nilai_hasil>=80 and $rowData->nilai_hasil<=89){
            $arrayVal[$rowData->pegawai_id]['rating1']='2';
          }
          else if($rowData->nilai_hasil>=90 and $rowData->nilai_hasil<=109){
            $arrayVal[$rowData->pegawai_id]['rating1']='3';
          }
          else if($rowData->nilai_hasil>=110 and $rowData->nilai_hasil<=119){
            $arrayVal[$rowData->pegawai_id]['rating1']='4';
          }
          else if($rowData->nilai_hasil>=120){
            $arrayVal[$rowData->pegawai_id]['rating1']='5';
          }
          $arrayVal[$rowData->pegawai_id]['jumlah_benar_0102']=$rowData->jumlah_benar_0102;
          if($rowData->jumlah_benar_0102<=2){
            $arrayVal[$rowData->pegawai_id]['rating22']='1';
          }
          else if($rowData->jumlah_benar_0102>=3 and $rowData->jumlah_benar_0102<=5){
            $arrayVal[$rowData->pegawai_id]['rating22']='2';
          }
          else if($rowData->jumlah_benar_0102>=6 and $rowData->jumlah_benar_0102<=8){
            $arrayVal[$rowData->pegawai_id]['rating22']='3';
          }
          else if($rowData->jumlah_benar_0102>=9 and $rowData->jumlah_benar_0102<=10){
            $arrayVal[$rowData->pegawai_id]['rating22']='4';
          }
          else if($rowData->jumlah_benar_0102>=11){
            $arrayVal[$rowData->pegawai_id]['rating22']='5';
          }
          $arrayVal[$rowData->pegawai_id]['jumlah_benar_0103']=$rowData->jumlah_benar_0103;
          if($rowData->jumlah_benar_0103<=2){
            $arrayVal[$rowData->pegawai_id]['rating23']='1';
          }
          else if($rowData->jumlah_benar_0103>=3 and $rowData->jumlah_benar_0103<=5){
            $arrayVal[$rowData->pegawai_id]['rating23']='2';
          }
          else if($rowData->jumlah_benar_0103>=6 and $rowData->jumlah_benar_0103<=8){
            $arrayVal[$rowData->pegawai_id]['rating23']='3';
          }
          else if($rowData->jumlah_benar_0103>=9 and $rowData->jumlah_benar_0103<=11){
            $arrayVal[$rowData->pegawai_id]['rating23']='4';
          }
          else if($rowData->jumlah_benar_0103>=12){
            $arrayVal[$rowData->pegawai_id]['rating23']='5';
          }
        }


        $query= new HasilUjian();  
        $statement= " AND B.JADWAL_TES_ID = ".$reqId;
        $query=$query->selectByParamsMonitoringPapiHasil($reqId, $statement);     
        foreach ($query as $rowData) { 
          $arrayVal[$rowData->pegawai_id]['n']=$rowData->nilai_n;
          $arrayVal[$rowData->pegawai_id]['i']=$rowData->nilai_i;
          $arrayVal[$rowData->pegawai_id]['g']=$rowData->nilai_g;
          $arrayVal[$rowData->pegawai_id]['a']=$rowData->nilai_a;
          $arrayVal[$rowData->pegawai_id]['r']=$rowData->nilai_r;
          $arrayVal[$rowData->pegawai_id]['e']=$rowData->nilai_e;
          $arrayVal[$rowData->pegawai_id]['k']=$rowData->nilai_k;
          $arrayVal[$rowData->pegawai_id]['z']=$rowData->nilai_z;
          $arrayVal[$rowData->pegawai_id]['s']=$rowData->nilai_s;
          $arrayVal[$rowData->pegawai_id]['b']=$rowData->nilai_b;
          $arrayVal[$rowData->pegawai_id]['o']=$rowData->nilai_o;
          $arrayVal[$rowData->pegawai_id]['x']=$rowData->nilai_x;
        }

        foreach ($arrayVal as $key => $rowData) {
          // print_r($rowData['pegawai_id']);exit;
          $rating23 = isset($rowData['rating23']) ? $rowData['rating23'] : 0;
          $rating22 = isset($rowData['rating22']) ? $rowData['rating22'] : 0;

          $arrayVal[$rowData['pegawai_id']]['rating2']=(($rating22+$rating23)/2);
          $arrayVal[$rowData['pegawai_id']]['rating3']=((round((($rowData['n']+1)/2))+round((($rowData['i']+1)/2)))/2);
          $arrayVal[$rowData['pegawai_id']]['rating4']=((round((($rowData['n']+1)/2))+round((($rowData['g']+1)/2))+round((($rowData['a']+1)/2)))/3);
          $arrayVal[$rowData['pegawai_id']]['rating5']=((round((($rowData['n']+1)/2))+round((($rowData['r']+1)/2)))/2);
          $arrayVal[$rowData['pegawai_id']]['rating6']=((round((($rowData['e']+1)/2))+round((($rowData['k']+1)/2)))/2);
          $arrayVal[$rowData['pegawai_id']]['rating7']=((round((($rowData['z']+1)/2))+round((($rowData['r']+1)/2)))/2);
          $arrayVal[$rowData['pegawai_id']]['rating8']=((round((($rowData['s']+1)/2))+round((($rowData['b']+1)/2))+round((($rowData['o']+1)/2))+round((($rowData['x']+1)/2)))/4);
          $arrayVal[$rowData['pegawai_id']]['jpm_potensi']=((
            $rowData['rating1']+
            (($rating22+$rating23)/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['i']+1)/2)))/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['g']+1)/2))+round((($rowData['a']+1)/2)))/3)+
            ((round((($rowData['n']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['e']+1)/2))+round((($rowData['k']+1)/2)))/2)+
            ((round((($rowData['z']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['s']+1)/2))+round((($rowData['b']+1)/2))+round((($rowData['o']+1)/2))+round((($rowData['x']+1)/2)))/4))
          /24)*100;

          if(((
            $rowData['rating1']+
            (($rating22+$rating23)/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['i']+1)/2)))/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['g']+1)/2))+round((($rowData['a']+1)/2)))/3)+
            ((round((($rowData['n']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['e']+1)/2))+round((($rowData['k']+1)/2)))/2)+
            ((round((($rowData['z']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['s']+1)/2))+round((($rowData['b']+1)/2))+round((($rowData['o']+1)/2))+round((($rowData['x']+1)/2)))/4))
          /24)*100 < 78 ){
            $desc='Kurang Optimal';
          }else if(((
            $rowData['rating1']+
            (($rating22+$rating23)/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['i']+1)/2)))/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['g']+1)/2))+round((($rowData['a']+1)/2)))/3)+
            ((round((($rowData['n']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['e']+1)/2))+round((($rowData['k']+1)/2)))/2)+
            ((round((($rowData['z']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['s']+1)/2))+round((($rowData['b']+1)/2))+round((($rowData['o']+1)/2))+round((($rowData['x']+1)/2)))/4))
          /24)*100 >= 78 ){
            $desc='Optimal';
          }
          else{
            $desc='Cukup Optimal';
          }
          $arrayVal[$rowData['pegawai_id']]['hasil_potensi']= $desc;

        }

        $query= new HasilUjian();  
        $query=$query->selectByParamsHasilSJTKompetensi($reqId, $reqTipeUjian); 
        // print_r($query);exit;    
        foreach ($query as $rowData) { 
          $arrayVal[$rowData->pegawai_id][$rowData->kategori]=$rowData->konversi;
        }

        $query= new HasilUjian();  
        $query=$query->selectByParamsMonitoringSJT($reqId,$reqTipeUjian);
        foreach ($query as $rowData) { 
          $arrayVal[$rowData->pegawai_id]['nilai']=$rowData->nilai;
          $arrayVal[$rowData->pegawai_id]['jpm2']=$rowData->jpm;
          $arrayVal[$rowData->pegawai_id]['pengisian_jabatan']=$rowData->pengisian_jabatan;
          $arrayVal[$rowData->pegawai_id]['pemetaan_kompetensi']=$rowData->pemetaan_kompetensi;
        } 


      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_jadwal_lihat_detil', compact('query','arrayVal'));
    }

    public function addviewEdit(request $request)
    {
      $reqId=$request->route('id');
      $pg = $request->route('view');
      $iddll = $request->route('iddll');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $statement=" AND a.formula_assesment_id = (select xx.formula_id from jadwal_tes x  LEFT JOIN formula_eselon xx on x. formula_eselon_id = xx.formula_eselon_id where jadwal_tes_id=". $reqId.") and parent_id='0'";
      $query = new FormulaAssesmentUjianTahap();
      $query=$query->selectByParamsMonitoring($statement);
      //buat tes sqli

      $IdentitasUjian = new SettingJadwal();
      $statement=' and jadwal_tes_id='. $reqId;
      $IdentitasUjian=$IdentitasUjian->selectByParamsMonitoring($statement)->first();

      // print_r($IdentitasUjian);exit;
      
      $result = DB::select("SELECT to_regclass('cat_pegawai.ujian_pegawai_".$reqId."') as tbl");

      // Ambil hasil
      $cekTabel = $result[0]->tbl;
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_jadwal_edit', compact('query','reqId','pg','iddll','IdentitasUjian','cekTabel'));
    }

    
    public function deleteAsesor (request $request)
    {
      $reqId = $request->route('id');
      JadwalAsesor::where('jadwal_asesor_id', $reqId)
      ->delete();
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function deletePegawai (request $request)
    {
      $reqId = $request->route('id');
      JadwalPegawai::where('jadwal_pegawai_id', $reqId)
      ->delete();
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function deletePegawaiKelompok (request $request)
    {
      $id = $request->route('id');
      $ujianid = $request->route('ujianid');
      $asesorid = $request->route('asesorid');
      $penggalianid = $request->route('penggalianid');
      JadwalPegawai::where('kelompok_id', $id)
      ->where('id_jadwal', $ujianid)
      ->where('jadwal_asesor_id', $asesorid)
      ->where('penggalian_id', $penggalianid)
      ->delete();
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function deleteKelompokPegawai (request $request)
    {
      $reqId = $request->route('id');
      KelompokDetil::where('kelompok_detil_id', $reqId)
      ->delete();
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function deleteAcara (request $request)
    {
      $reqId = $request->route('id');
      JadwalAcara::where('jadwal_acara_id', $reqId)
      ->delete();
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function deleteKelompok (request $request)
    {
      $reqId = $request->route('id');
      Kelompok::where('kelompok_id', $reqId)
      ->delete();

      KelompokDetil::where('kelompok_id', $reqId)
      ->delete();
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function deleteUpload (request $request)
    {
      $reqId = $request->route('id');

      $cfile= new PermohonanFile();   
      $statement=" and A.permohonan_file_id='".$reqId. "'";
      $cfile=$cfile->selectByParams($statement)->first();
      // print_r($cfile);exit;

      if(!empty($cfile))
      {
        $infofilerowid= $cfile->permohonan_file_id;
        $infofilelokasi= $cfile->link_file;
        PermohonanFile::where('permohonan_file_id', $reqId)
        ->delete();
        unlink($infofilelokasi);
      }

      
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function reset (request $request)
    {
      $JadwalId = $request->route('JadwalId');
      $TipeUjianId = $request->route('TipeUjianId');
      $id = $request->route('id');
      UjianTahapStatusUjian::where('jadwal_tes_id', $JadwalId)
      ->where('pegawai_id', $id)
      ->where('tipe_ujian_id', $TipeUjianId)
      ->delete();

      
      return StringFunc::json_response(200, "Data berhasil Direset");

    }

    public function addAcara(request $request)
    {

      //  $validated = $request->validate([
      //       'reqPenggalian' => 'required',
      //       'reqPukulAwal' => 'required',
      //       'reqPukulAkhir' => 'required',
      //       'reqKeterangan' => 'required',
      // ]);
      $reqId= $request->reqId;
      $reqPenggalian= $request->reqPenggalian;
      $reqPukulAwal= $request->reqPukulAwal;
      $reqPukulAkhir= $request->reqPukulAkhir;
      $reqKeterangan= $request->reqKeterangan;
      $reqDetilId= $request->reqDetilId;
      $reqTanggal= $request->reqTanggal;

      // DB::enableQueryLog();
      if(empty($reqDetilId))
      {
        $maxId = JadwalAcara::NextId();
        $query = new JadwalAcara();
        // nama kolom yang di insert
        $query->jadwal_acara_id = $maxId;
        $query->last_create_user = $this->user->user_app_id;
        $query->last_create_date = Carbon::now();
        $reqDetilId=$maxId;
      }else{           
        $query = JadwalAcara::findOrFail($reqDetilId);
        $query->jadwal_acara_id = $reqDetilId;
        $query->last_update_user = $this->user->user_app_id;
        $query->last_update_date = Carbon::now();
      }

      $query->jadwal_tes_id= $reqId;
      $query->penggalian_id= $reqPenggalian;
      $query->pukul1= $reqPukulAwal;
      $query->pukul2= $reqPukulAkhir;
      $query->keterangan= $reqKeterangan;
      $query->tanggal= $reqTanggal;
        
      $query->save();

      return StringFunc::json_response(200, $reqId."-".$reqDetilId."-Data berhasil disimpan.");
      
    }

    public function addviewlookupAsesor(request $request) 
    {
      $filter = $request->route('filter');
      $reqId = $request->route('id');

      $query= new JadwalAsesor();
        $statement=' AND A.jadwal_acara_id = '.$reqId;
      $query=$query->selectByParamsMonitoring($statement)->first();

      return view('app/setting_jadwal_asesor_lookup', compact('filter','reqId','query'));
    }

    public function addAsesor(request $request)
    {

      //  $validated = $request->validate([
      //       'reqPenggalian' => 'required',
      //       'reqPukulAwal' => 'required',
      //       'reqPukulAkhir' => 'required',
      //       'reqKeterangan' => 'required',
      // ]);
      $reqId= $request->reqId;
      $reqDetilId= $request->reqDetilId;
      $reqAsesorId= $request->reqAsesorId;
      $reqAsesorUjianId= $request->reqAsesorUjianId;
      $reqBatas= $request->reqBatas;
      $reqKeterangan= $request->reqKeterangan;
      $reqTanggal= $request->reqTanggal;
      $reqPukulAwal= $request->reqPukulAwal;
      $reqPukulAkhir= $request->reqPukulAkhir;

      // Memeriksa nilai kosong
      $hasEmpty = in_array("", $reqBatas, true) || in_array(null, $reqBatas, true);
      // print_r($hasEmpty);exit;
      if($hasEmpty==1){
        return StringFunc::json_response(400, "xxx--Isi Batas Asesi.");
      }

      // DB::enableQueryLog();
      for($i=0;$i<count($reqAsesorId);$i++){
        if(empty($reqAsesorUjianId[$i]))
        {
          $maxId = JadwalAsesor::NextId();
          $query = new JadwalAsesor();
          // nama kolom yang di insert
          $query->jadwal_asesor_id = $maxId;
          $query->last_create_user = $this->user->user_app_id;
          $query->last_create_date = Carbon::now();
        }else{           
          $query = JadwalAsesor::findOrFail($reqAsesorUjianId[$i]);
          $query->jadwal_asesor_id = $reqAsesorUjianId[$i];
          $query->last_update_user = $this->user->user_app_id;
          $query->last_update_date = Carbon::now();
        }

        $query->jadwal_tes_id= $reqId;
        $query->jadwal_acara_id= $reqDetilId;
        $query->asesor_id= $reqAsesorId[$i];
        $query->batas_pegawai= $reqBatas[$i];
        $query->tanggal= $reqTanggal[$i];
        $query->waktu_mulai= $reqPukulAwal[$i];
        $query->waktu_selesai= $reqPukulAkhir[$i];
        if (isset($reqKeterangan[$i])) {
            $value = $reqKeterangan[$i];
        } else {
            // Handle the case when the key does not exist
            $value = null; // or some default value
        }
        $query->keterangan= $value;
          
        $query->save();
 
      }

      return StringFunc::json_response(200, $reqId."-".$reqDetilId."-Data berhasil disimpan.");
      
    }

    public function addviewlookupPegawai(request $request) 
    {
      $reqId=$request->route('reqId');
      $reqPenggalianId=$request->route('reqPenggalianId');
      return view('app/setting_jadwal_pegawai_lookup', compact('reqId','reqPenggalianId'));
    }

    public function addviewlookupPegawaiKelompok(request $request) 
    {
      $reqId=$request->route('reqId');
      return view('app/setting_jadwal_pegawai_kelompok_lookup', compact('reqId'));
    }

    public function addviewlookupPegawaiKelompokPilih(request $request) 
    {
      $reqId=$request->route('reqId');
      return view('app/setting_jadwal_pegawai_kelompok_lookup_pilih', compact('reqId'));
    }

    public function addviewlookupKegiatanFile(request $request) 
    {
      $reqTipe=$request->route('reqTipe');
      $filter=$request->route('filter');
      return view('app/setting_jadwal_kegiatan_file_lookup', compact('reqTipe','filter'));
    }

    public function AddPegawai(request $request)
    {
        
      //  $validated = $request->validate([
      //       'reqPenggalian' => 'required',
      //       'reqPukulAwal' => 'required',
      //       'reqPukulAkhir' => 'required',
      //       'reqKeterangan' => 'required',
      // ]);
      $reqId= $request->reqId;
      $reqDetilId= $request->reqDetilId;
      $reqPenggalianId= $request->reqPenggalianId;
      $reqPegawaiId= $request->reqPegawaiId;
      $reqJadwalPegawaiId= $request->reqJadwalPegawaiId;

      // DB::enableQueryLog();
      for($i=0;$i<count($reqPegawaiId);$i++){
        if(empty($reqJadwalPegawaiId[$i]))
        {
          $maxId = JadwalPegawai::NextId();
          $query = new JadwalPegawai();
          // nama kolom yang di insert
          $query->jadwal_pegawai_id = $maxId;
          $query->last_create_user = $this->user->user_app_id;
          $query->last_create_date = Carbon::now();
        }else{           
          $query = JadwalPegawai::findOrFail($reqJadwalPegawaiId[$i]);
          $query->jadwal_pegawai_id = $reqJadwalPegawaiId[$i];
          $query->last_update_user = $this->user->user_app_id;
          $query->last_update_date = Carbon::now();
        }

        $set = new KelompokDetil();
        $statement=' and jadwal_tes_id='. $reqId." and a.pegawai_id=".$reqPegawaiId[$i];
        $set=$set->selectByParams($statement)->first();
        
        if(empty($set->kelompok_id)){
            $cekPegawai = new Pegawai();
            $statement=" and a.pegawai_id=".$reqPegawaiId[$i];
            $cekPegawai=$cekPegawai->selectByParamsMonitoring($statement)->first();
            return StringFunc::json_response(200, "xxx---Masukkan Pegawai dengan NIP ".$cekPegawai->nip_baru." Kelompok Dahulu.");   
        }
        
        $query->kelompok_id= $set->kelompok_id;
        $query->id_jadwal= $reqId;
        $query->jadwal_asesor_id= $reqDetilId;
        $query->penggalian_id= $reqPenggalianId;
        $query->pegawai_id= $reqPegawaiId[$i];
          
        $query->save();
 
      }

      return StringFunc::json_response(200, $reqId."-".$reqDetilId."-".$reqPenggalianId."-Data berhasil disimpan.");
      
    }

    public function AddPegawaiKelompok(request $request)
    {

      $reqId= $request->reqId;
      $reqDetilId= $request->reqDetilId;
      $reqPenggalianId= $request->reqPenggalianId;
      $reqKelompokId= $request->reqKelompokId;
      $reqJadwalPegawaiId= $request->reqJadwalPegawaiId;
      $total=0;
      for($i=0;$i<count($reqKelompokId);$i++){
        $set = new Kelompok();
        $statement=' and a.kelompok_id='. $reqKelompokId[$i];
        $set=$set->selectByParamsMonitoringLookupMaster($reqId,$statement)->first();
        $total=$total+$set->total;
      }

      $query = new JadwalAsesor();
      $statement=' and a.jadwal_asesor_id='. $reqDetilId;
      $batas=$query->selectByParamsMonitoring($statement)->first();    
      // print_r($batas);exit;
      if($total>$batas->batas_pegawai){
        return StringFunc::json_response(200, "xxx---Data Gagal Disimpan. Jumlah peserta melebihi batas. Atur lagi batas dari peserta di setiap asesor");
        exit;
      }

      JadwalPegawai::where('jadwal_asesor_id', $reqDetilId)
      ->where('penggalian_id', $reqPenggalianId)
      ->where('id_jadwal', $reqId)
      ->delete();

      // DB::enableQueryLog();
      for($i=0;$i<count($reqKelompokId);$i++){
        $set = new KelompokDetil();
        $statement=' and kelompok_id='. $reqKelompokId[$i]." and jadwal_tes_id=". $reqId;
        $set=$set->selectByParams($statement);

        foreach ($set as $value) {
          $maxId = JadwalPegawai::NextId();
          $query = new JadwalPegawai();
          // nama kolom yang di insert
          $query->jadwal_pegawai_id = $maxId;
          $query->last_create_user = $this->user->user_app_id;
          $query->last_create_date = Carbon::now();
          
          $query->kelompok_id= $reqKelompokId[$i];
          $query->id_jadwal= $reqId;
          $query->jadwal_asesor_id= $reqDetilId;
          $query->penggalian_id= $reqPenggalianId;
          $query->pegawai_id= $value->pegawai_id;
            
          $query->save();
        }
      }

      return StringFunc::json_response(200, $reqId."-".$reqDetilId."-".$reqPenggalianId."-Data berhasil disimpan.");
      
    }

    public function addUpload(request $request)
    {
      $reqId= $request->reqId;
      $reqFileJenisId= $request->reqFileJenisId;
      $reqFileJenisKode= $request->reqFileJenisKode;
      $reqkuncijenis= $reqId;
      $reqfolderjenis= "jadwaltes".$reqkuncijenis;
      $reqJenis= $reqfolderjenis."-soal";
      $filedata= $_FILES["reqLinkFile"];
      // print_r($filedata);exit;
      $folderfilesimpan= "uploads/essay/".$reqfolderjenis;
      if(file_exists($folderfilesimpan)){}
      else
      {
        mkdir($folderfilesimpan);
      }

      for($i=0; $i < count($reqFileJenisKode); $i++)
      {
        $namafile= $filedata["name"][$i];
        $fileType= $filedata["type"][$i];
        $datafileupload= $filedata["tmp_name"][$i];
        $filepath= explode('.',$namafile);
        $longfilepath=count($filepath);
        $filepath=$filepath[$longfilepath-1];

        if($namafile == ""){}
        else
        {
          $namajenisfile= $reqFileJenisKode[$i];
          $penamaanfile= $reqkuncijenis."_".$namajenisfile."_";
          $linkfile= $penamaanfile.md5($penamaanfile.$namafile).".".strtolower($filepath);
          $targetsimpan= $folderfilesimpan."/".$linkfile;

          $cfile= new PermohonanFile();   
          $statement=" and A.PERMOHONAN_TABLE_ID='".$reqkuncijenis. "' and A.PERMOHONAN_TABLE_NAMA='". $reqJenis. "'  and A.PEGAWAI_ID='".$namajenisfile."'";
          $cfile=$cfile->selectByParams($statement)->first();
          // print_r($cfile);exit;

          if(!empty($cfile))
          {
            $infofilerowid= $cfile->permohonan_file_id;
            $infofilelokasi= $cfile->link_file;
            unlink($infofilelokasi);
          }

          if (move_uploaded_file($datafileupload, $targetsimpan))
          {

            if(!empty($cfile))
            {
              $infofilerowid= $cfile->permohonan_file_id;
              $infofilelokasi= $cfile->link_file;
              $query = PermohonanFile::findOrFail($infofilerowid);
              // unlink($infofilelokasi);
            }
            else{
              $maxId = PermohonanFile::NextId();
              $query = new PermohonanFile();
              // nama kolom yang di insert
              $query->permohonan_file_id = $maxId;
              
            }

            $query->pegawai_id = $namajenisfile;
            $query->permohonan_table_nama = $reqJenis;
            $query->permohonan_table_id = $reqkuncijenis;
            $query->nama = $linkfile;
            $query->keterangan = $namafile;
            $query->link_file = $targetsimpan;
            $query->tipe = strtolower($fileType);
            $query->user_login_id = $this->user->user_app_id;
            $query->user_login_pegawai_id = $this->user->user_app_id;
            $query->user_login_create_id = $this->user->user_app_id;
            $query->save();
          }

          // hapus file
          // $cfile= new PermohonanFile();
          // $cfile->selectByParams(array("A.PERMOHONAN_TABLE_ID"=>$reqkuncijenis, "A.PERMOHONAN_TABLE_NAMA"=>$reqJenis, "A.PEGAWAI_ID"=>$namajenisfile));
          // $cfile->firstRow();
          // // echo $cfile->query;exit;
          // $infofilerowid= $cfile->getField("PERMOHONAN_FILE_ID");
          // $infofilelokasi= $cfile->getField("LINK_FILE");
          // if(file_exists($infofilelokasi))
          // {
          //   $setfile= new PermohonanFile();
          //   $setfile->setField("PERMOHONAN_FILE_ID", $infofilerowid);
          //   $setfile->delete();
          //   // echo $setfile->query;exit;
          //   unlink($infofilelokasi);
          // }

          // if (move_uploaded_file($datafileupload, $targetsimpan))
          // {
          // }
        }
      }
      return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");
      
    }

    public function addEssay(request $request)
    {
      $reqId= $request->reqId;
      $reqKegiatanFile= $request->reqKegiatanFile;
      $reqKegiatanFileId= $request->reqKegiatanFileId;
      $reqEssaySoal= $request->reqEssaySoal;
      $reqFileJenisId= $request->reqFileJenisId;
      $reqBatas= $request->reqBatas;
      // print_r($reqFileJenisId);exit;
      for( $i=0; $i<count($reqFileJenisId);$i++)
      {
        if(!empty($reqEssaySoal[$i]))
        {
          $query = EssaySoal::findOrFail($reqEssaySoal[$i]);
          // unlink($infofilelokasi);
          $query->essay_soal_id = $reqEssaySoal[$i];
        }
        else{
          $maxId = EssaySoal::NextId();
          $query = new EssaySoal();
          // nama kolom yang di insert
          $query->essay_soal_id = $maxId;
          
        }

        $query->penggalian_id = $reqFileJenisId[$i];
        $query->kegiatan_file_id = $reqKegiatanFileId[$i];
        $query->ujian_id = $reqId;
        $query->save();      
      }

      $query = JadwalTes::findOrFail($reqId);
      $query->kompetensi_tanggal_selesai = $reqBatas;
      $query->save();

      return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");
      
    }

    public function addKelompok(request $request)
    {
      $idHead= $request->idHead;
      $id= $request->id;
      $reqNama= $request->reqNama;
      // print_r($reqFileJenisId);exit;
      if(!empty($id))
      {
        $query = Kelompok::findOrFail($id);
        // unlink($infofilelokasi);
        $query->kelompok_id = $id;
      }
      else{
        $maxId = Kelompok::NextId();
        $query = new Kelompok();
        // nama kolom yang di insert
        $query->kelompok_id = $maxId;
        $id=$maxId;
      }

      $query->nama = $reqNama;
      // $query->jadwal_tes_id = $idHead;
      $query->save();      

      return StringFunc::json_response(200, $id."-Data berhasil disimpan.");
      
    }

    public function addKelompokAnggota(request $request)
    {
      $id= $request->id;
      $reqKelompokDetilId= $request->reqKelompokDetilId;
      $reqPegawaiId= $request->reqPegawaiId;
      $idHead= $request->idHead;
      // print_r($reqFileJenisId);exit;

      for($i=0;$i<count($reqKelompokDetilId);$i++){
        if(!empty($reqKelompokDetilId[$i]))
        {
          $query = KelompokDetil::findOrFail($reqKelompokDetilId[$i]);
          // unlink($infofilelokasi);
        }
        else{
          $maxId = KelompokDetil::NextId();
          $query = new KelompokDetil();
          // nama kolom yang di insert
          $query->kelompok_detil_id = $maxId;
        }        

        $query->pegawai_id = $reqPegawaiId[$i];
        $query->kelompok_id = $id;
        $query->jadwal_tes_id = $idHead;
        $query->save();      
      }

      return StringFunc::json_response(200, $id."-Data berhasil disimpan.");
      
    }

    public function EditStatus(request $request)
    {

      $reqId= $request->reqId;
      $reqStatus= $request->reqStatus;
      $reqStatusJenis= $request->reqStatusJenis;
      $reqTtdAsesor= $request->reqTtdAsesor;
      $reqTtdPimpinan= $request->reqTtdPimpinan;
      $reqTanggalMulai= $request->reqTanggalMulai;
      $reqTanggalSelesai= $request->reqTanggalSelesai;
      $reqZoom= $request->reqZoom;
      $reqWaktuMulai= $request->reqWaktuMulai;
      $filedataAsesor= $_FILES["reqLinkFileAsesor"];
      $filedataPimpinan= $_FILES["reqLinkFilePimpinan"];
      // print_r($reqStatus);exit;
            
      $query = JadwalTes::findOrFail($reqId);
      $query->status_valid = $reqStatus;
      $query->status_jenis = $reqStatusJenis;
      $query->ttd_pimpinan = $reqTtdPimpinan;
      $query->ttd_asesor = $reqTtdAsesor;
      $query->kompetensi_tanggal_mulai = $reqTanggalMulai;
      $query->kompetensi_tanggal_selesai= $reqTanggalSelesai;
      $query->link_soal= $reqZoom;
      $query->waktu_mulai= $reqWaktuMulai;
      $query->last_update_user = $this->user->user_app_id;
      $query->last_update_date = Carbon::now();
      $query->save();

      $folderfilesimpan= "uploads/tes/".$reqId;
      if(file_exists($folderfilesimpan)){}
      else
      {
        mkdir($folderfilesimpan);
      }

      $datafileupload= $filedataAsesor["tmp_name"];
      $namafile= $filedataAsesor["name"];
      $filepath= explode('.',$namafile);
      $longfilepath=count($filepath);
      $filepath=$filepath[$longfilepath-1];
      $linkfile= "asesor_ttd.".strtolower($filepath);
      $targetsimpan= $folderfilesimpan."/".$linkfile;
      move_uploaded_file($datafileupload, $targetsimpan);

      $datafileupload= $filedataPimpinan["tmp_name"];
      $namafile= $filedataPimpinan["name"];
      $filepath= explode('.',$namafile);
      $longfilepath=count($filepath);
      $filepath=$filepath[$longfilepath-1];
      $linkfile= "pimpinan_ttd.".strtolower($filepath);
      $targetsimpan= $folderfilesimpan."/".$linkfile;
      move_uploaded_file($datafileupload, $targetsimpan);

      return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");
      
    }

    public function resetEssay(request $request)
    {

      $reqId = $request->route('id');
      $reqPegawaiId = $request->route('idpeg');
      $idsoal = $request->route('idsoal');

      $cfile= new EssayJawaban();   
      $statement=" and pegawai_id=".$reqPegawaiId. " and a.essay_soal_id=". $idsoal;
      $cfile=$cfile->selectByParamsMonitoring($statement)->first();

      if(!empty($cfile)){
        if($cfile->penggalian_kode='PE'||$cfile->penggalian_kode='ITR'){
          EssayJawaban::where('essay_jawaban_id', $cfile->essay_jawaban_id)
        ->delete();
        }
        else{
          $query = EssayJawaban::findOrFail($cfile->essay_jawaban_id);
          $query->submit = null;
          $query->save();        
        }
      }
              

      return StringFunc::json_response(200, $reqId."-Data berhasil Dibuka.");
      
    }

    public function deleteEssay(request $request)
    {

      $reqId = $request->route('id');
      $reqPegawaiId = $request->route('idpeg');
      $idsoal = $request->route('idsoal');

      $cfile= new EssayJawaban();   
      $statement=" and pegawai_id=".$reqPegawaiId. " and essay_soal_id=". $idsoal;
      $cfile=$cfile->selectByParamsMonitoring($statement)->first();

      if(!empty($cfile)){
        
        EssayJawaban::where('essay_jawaban_id', $cfile->essay_jawaban_id)
        ->delete();
      }
              

      return StringFunc::json_response(200, $reqId."-Data berhasil Dihapus.");
      
    }


    public function ImportExcelKelompok($id = null, $kelompokid = null)
    {
      // buat validasi
      // $validated = $request->validate([
      //       'reqTahun' => 'required',
      //       'reqFormula' => 'required',
      //       'reqKeterangan' => 'required',
      //       'reqTipeFormula' => 'required',
      // ]);
      $reqId= $id;
      $reqKelompokId= $kelompokid;

      $query = new Log();
      $query=$query->selectByParamsUniq()->first();
      $log_Uniq=$query->max;

      $excelFile= $_FILES["excelFile"];
      $fileTmpPath = $_FILES['excelFile']['tmp_name'];
      if(empty($fileTmpPath)){
        return StringFunc::json_response(200, "xxx--Lampirkan FIle.");
        exit;
      }
      
      // Baca file langsung dari lokasi sementara
      $spreadsheet = IOFactory::load($fileTmpPath);
      $worksheet = $spreadsheet->getActiveSheet();
      $i=1;
      foreach ($worksheet->getRowIterator() as $row) {
        if($i>1){
          $cell = $worksheet->getCell('A' . $row->getRowIndex()); // Ambil data dari kolom A
          $reqNip=htmlspecialchars($cell->getValue());

          $query = new Pegawai();
          $statement=" and nip_baru= '".$reqNip."'";
          $query=$query->selectByParamsMonitoring($statement)->first();
          if(empty($query)){
            $maxId = Log::NextId();
            $set = new Log();
            // nama kolom yang di insert
            $set->log_id = $maxId;
            $set->last_create_user = $this->user->user_app_id;
            $set->last_create_date = Carbon::now();
            $set->log_uniq =$log_Uniq;
            $set->input =$reqNip;
            $set->id =$reqId;
            $set->keterangan ='data tidak ada di database';
            $set->save(); 
            $eror=1;
          }
          else{
            $pegawai_id=$query->pegawai_id;
            
            $query = new JadwalAwalTesSimulasiPegawai();
            $statement=' and jadwal_awal_tes_simulasi_id= '.$reqId.' and a.pegawai_id='.$pegawai_id;
            $query=$query->selectByParamsMonitoring($statement)->first();
            if(!empty($query)){
              
              $query = new KelompokDetil();
              $statement=' and jadwal_tes_id='.$reqId.' and a.pegawai_id='.$pegawai_id;
              $query=$query->selectByParams($statement)->first();

              if(empty($query)){
                $maxId = KelompokDetil::NextId();
                $query = new KelompokDetil();
                // nama kolom yang di insert
                $query->kelompok_detil_id = $maxId;
                
                $query->pegawai_id = $pegawai_id;
                $query->kelompok_id = $reqKelompokId;
                $query->jadwal_tes_id = $reqId;
                $query->save();      
              }
              else{
                $maxId = Log::NextId();
                $set = new Log();
                // nama kolom yang di insert
                $set->log_id = $maxId;
                $set->last_create_user = $this->user->user_app_id;
                $set->last_create_date = Carbon::now();
                $set->log_uniq =$log_Uniq;
                $set->input =$reqNip;
                $set->id =$reqId;
                $set->keterangan ='data sudah terdaftar';
                $set->save(); 
                $eror=1;
              }
            }
            else{

              $maxId = Log::NextId();
              $set = new Log();
              // nama kolom yang di insert
              $set->log_id = $maxId;
              $set->last_create_user = $this->user->user_app_id;
              $set->last_create_date = Carbon::now();
              $set->log_uniq =$log_Uniq;
              $set->input =$reqNip;
              $set->id =$reqId;
              $set->keterangan ='data tidak Terdaftar di ujian ini';
              $set->save(); 
              $eror=1;
            }
          }          
        }
        $i++;
      }

        return StringFunc::json_response(200, $reqId."-xxx-Data berhasil disimpan.");
    }


    public function ImportExcelAsesi($reqId = null, $reqDetilId = null, $reqPenggalianId = null)
    {
      $reqId= $reqId;
      $reqDetilId= $reqDetilId;
      $reqPenggalianId= $reqPenggalianId;

      $excelFile= $_FILES["excelFile"];
      $fileTmpPath = $_FILES['excelFile']['tmp_name'];
      if(empty($fileTmpPath)){
        return StringFunc::json_response(200, "xxx--Lampirkan FIle.");
        exit;
      }
      
      // Baca file langsung dari lokasi sementara
      $spreadsheet = IOFactory::load($fileTmpPath);
      $worksheet = $spreadsheet->getActiveSheet();
      $highestRow = $worksheet->getHighestRow();

      $queryhead = new JadwalAsesor();
      $statement=' and a.jadwal_asesor_id='. $reqDetilId;
      $queryhead=$queryhead->selectByParamsMonitoring($statement)->first();
      $total=$queryhead->batas_pegawai;

      if($highestRow-1 > $total){
          return StringFunc::json_response(200, "xxx-Batas asesi dan data yang dimasukkan tidak sesuai.");
          exit;   
      }

      $i=1;
      foreach ($worksheet->getRowIterator() as $row) {
        if($i>1){
          $cell = $worksheet->getCell('A' . $row->getRowIndex()); // Ambil data dari kolom A
          $reqNip=htmlspecialchars($cell->getValue());

          $query = new Pegawai();
          $statement=" and nip_baru= '".$reqNip."'";
          $query=$query->selectByParamsMonitoring($statement)->first();
          if(empty($query)){
            // cek nip di simpeg.pegawai
          }
          else{
            $pegawai_id=$query->pegawai_id;

            $query = new JadwalAwalTesSimulasiPegawai();
            $statement=' and jadwal_awal_tes_simulasi_id= '.$reqId.' and a.pegawai_id='.$pegawai_id;
            $query=$query->selectByParamsMonitoring($statement)->first();
            if(!empty($query)){
            
              $set = new KelompokDetil();
              $statement=' and jadwal_tes_id='. $reqId." and a.pegawai_id=".$pegawai_id;
              $set=$set->selectByParams($statement)->first();
              // print_r($set);
              // echo'xxxx';
              if(empty($set)){
                  return StringFunc::json_response(200, "xxx-Masukkan Pegawai dengan NIP ".$reqNip." Kelompok Dahulu.");
                  exit;   
              }
              else{
                $reqKelompokId=$set->kelompok_id;
              }
              
              $query = new JadwalPegawai();
              $statement=' and a.id_jadwal= '.$reqId." and penggalian_id=".$reqPenggalianId." and a.pegawai_id=".$pegawai_id;
              $query=$query->selectByParamsMonitoring($statement)->first();
              // print_r($query);

              if(empty($query)){
                // echo $pegawai_id.'xxx';
                $maxId = JadwalPegawai::NextId();
                $set = new JadwalPegawai();
                // nama kolom yang di insert
                $set->jadwal_pegawai_id = $maxId;
                $set->id_jadwal =$reqId;
                $set->jadwal_asesor_id =$reqDetilId;
                $set->penggalian_id =$reqPenggalianId;
                $set->pegawai_id =$pegawai_id;
                $set->kelompok_id =$reqKelompokId;
                $set->save(); 
              }
              else{
                // cek nip di kelompok
              }
            }
          }          
        }
        $i++;
      }

        return StringFunc::json_response(200, $reqId."-xxx-Data berhasil disimpan.");
    }



    public function addKelompokSemua(request $request)
    {
      $reqId = $request->route('id');
      $reqDetil = $request->route('detilid');     

      $query = new JadwalAwalTesSimulasiPegawai();
      $statement=' and jadwal_awal_tes_simulasi_id= '.$reqId.' and a.pegawai_id not in
      (
        select pegawai_id 
        from kelompok_detil aa
        where aa.jadwal_tes_id = '.$reqId.'
      )';

      $query=$query->selectByParamsMonitoring($statement);

      foreach ($query as $key => $value) {
        $maxId = KelompokDetil::NextId();
        $query = new KelompokDetil();
        // nama kolom yang di insert
        $query->kelompok_detil_id = $maxId;
        
        $query->pegawai_id = $value->pegawai_id;
        $query->kelompok_id = $reqDetil;
        $query->jadwal_tes_id = $reqId;
        $query->save();      

      }
      
      return StringFunc::json_response(200, "Data berhasil disimpan.");
    }

}