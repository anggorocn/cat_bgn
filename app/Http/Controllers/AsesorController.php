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
use App\Models\CetakanLaporanIndividu;
use App\Models\FormulaAssesmentUjianTahap;
use App\Models\JadwalAsesor;
use App\Models\PermohonanFile;
use App\Models\HasilUjian;
use App\Models\UserApp;
use App\Models\JadwalAwalTes;
use App\Models\SoalPe;
use App\Models\SoalIntray;

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
use Mpdf\Mpdf;


use Carbon\Carbon;

class AsesorController extends Controller
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
        Route::get('/app/asesor/index', [AsesorController::class,'index']);
        Route::get('/app/asesor/jadwalpenilaian/{tgl?}', [AsesorController::class,'jadwalpenilaian']);
        Route::get('/app/asesor/identitascat/{pegawai_id?}/{ujian_id?}/{tgl?}', [AsesorController::class,'identitascat']);
        Route::get('/app/asesor/penilaian/{id?}', [AsesorController::class,'penilaian']);
        Route::get('/app/asesor/psikotest/{id?}', [AsesorController::class,'psikotest']);
        Route::get('/app/asesor/nilaiakhir/{id?}', [AsesorController::class,'nilaiakhir']);
        Route::get('/app/asesor/kesimpulan/{id?}', [AsesorController::class,'kesimpulan']);

        //buat route proses
        Route::get('Asesor/json/{id?}', [AsesorController::class,'json']);
        Route::get('Asesor/asesorjson/{id?}', [AsesorController::class,'asesorjson']);

        Route::post('Asesor/addAsesor/{id?}', [AsesorController::class,'addAsesor']);
        Route::post('Asesor/addNilaiAkhir/{id?}', [AsesorController::class,'addNilaiAkhir']);
        Route::post('Asesor/addKesimpulan/{id?}', [AsesorController::class,'addKesimpulan']);
        Route::post('Asesor/add/{id?}', [AsesorController::class,'add']);
        
        Route::get('/app/asesor/generate-datadiri/{id?}', [AsesorController::class, 'datadiripdf']);
        Route::get('/app/asesor/generate-laporanindividu/{id?}', [AsesorController::class, 'laporanindividupdf']);

        Route::get('/app/asesor/hasilujian/{id?}', [AsesorController::class,'addviewlookupgasilujian']);
        Route::get('/app/asesor/add/{id?}', [AsesorController::class,'addview']);

        Route::delete('asesor/delete/{id}',[ AsesorController::class, "delete" ]);

    }

    public function index(request $request) {
     $satuan_kerja = new SatuanKerjaController();
     // $cabangid=$this->CABANG_ID;
     // $satker=$satuan_kerja->combo_cabang($request,$cabangid);

     // $jenis=$this->combojenis($request);
     $jenis=1;
     // dd($jenis);
     // return view("app/pegawai/index",compact('satker','cabangid','jenis'));
     return view("app/asesor",compact('jenis'));
    }

    public function json(request $request)
    {
        $reqUnitKerja = $request->input('reqUnitKerja');
        $reqJenis = $request->input('reqJenis');
        // dd($reqUnitKerja);
        $query= new Asesor();

        $query=$query->selectByParamsMonitoring();
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $btn = '<a href="'.url('app/pegawai/add/'.$row->user_app_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
          $btn .= '<a onclick=\'deletedata("'.$row->user_app_id.'")\' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->make(true);
    }

    public function asesorjson(request $request)
    {
        $reqUnitKerja = $request->input('reqUnitKerja');
        $reqJenis = $request->input('reqJenis');
        
        $reqPencarian = isset($_GET['reqPencarian']) ? $_GET['reqPencarian'] : null;
        
        // dd($reqPencarian);
        $statement=' and user_group_id != 6';
        if(!empty($reqPencarian)){
          $statement.=" and (UPPER(NAMA) like UPPER('%".$reqPencarian."%') )";
        }
        
        $query= new Asesor();

        $query=$query->selectByParamsMonitoringAsesor($statement);
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $btn='';
          $btn = '<a href="'.url('app/asesor/add/'.$row->user_app_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
          $btn .= '<a onclick=\'deletedata("'.$row->user_app_id.'")\' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->make(true);
    }

    public function identitascat(request $request)
    {
      if(!empty($request->route('pegawai_id'))){
        $reqUjianId=$request->route('ujian_id');
        $reqPegawaiId = $request->route('pegawai_id');
        $reqTgl = $request->route('tgl');

        $this->user->penilaian_pegawai_id=$reqPegawaiId;
        $this->user->penilaian_ujian_id=$reqUjianId;
        $this->user->penilaian_tgl=$reqTgl;
      }
      else{
        $reqPegawaiId=$this->user->penilaian_pegawai_id;
        $reqUjianId = $this->user->penilaian_ujian_id;
        $reqTgl = $this->user->penilaian_tgl;
      }

      $order="";

      $statement=' and pegawai_id='.$reqPegawaiId;
      $query = new Pegawai();
      $query=$query->selectByParamsMonitoring($statement)->first();

      $statement=' and jadwal_tes_id='.$reqUjianId;
      $queryJadwal = new JadwalTes();
      $queryJadwal=$queryJadwal->selectByParamsMonitoring($statement)->first();

      $statement=' and jadwal_awal_tes_id='.$queryJadwal->jadwal_awal_tes_id;
      $queryCekFile = new JadwalAwalTes();
      $queryCekFile=$queryCekFile->selectByParamsMonitoring($statement)->first();
      // print_r($queryCekFile);exit;
      $statement=" AND a.formula_assesment_id = (select xx.formula_id from jadwal_tes x  LEFT JOIN formula_eselon xx on x. formula_eselon_id = xx.formula_eselon_id where jadwal_tes_id=". $reqUjianId.") and parent_id='0'";
      $queryUjian = new FormulaAssesmentUjianTahap();
      $queryUjian=$queryUjian->selectByParamsMonitoring($statement);
      $queryUjian=json_decode(json_encode($queryUjian), true);
      // print_r($queryUjian);exit;
      $queryUjianHasil=array();
      for($i=0; $i<count($queryUjian); $i++){
        $reqTipeUjian=$queryUjian[$i]['tipe_ujian_id'];
        $reqNamaUjian=$queryUjian[$i]['nama_ujian'];
        $queryUjianHasil[$i]['nama']=$reqNamaUjian;
        if($reqTipeUjian=='1'){
          $query1= new HasilUjian();      
          $statement= "";
          $statementdetil= " AND A.JADWAL_TES_ID = ".$reqUjianId." and pegawai_id=".$reqPegawaiId;
          $query1=$query1->selectByParamsMonitoringCfitHasilRekapA($reqUjianId,$reqTipeUjian, $statement, $statementdetil)->first();
          $queryUjianHasil[$i]['hasil']=$query1->kesimpulan;
        }
        else if($reqTipeUjian=='2'){
          $query1= new HasilUjian();      
          $statement= "";
          $statementdetil= " AND A.JADWAL_TES_ID = ".$reqUjianId." and pegawai_id=".$reqPegawaiId;
          $query1=$query1->selectByParamsMonitoringCfitHasilRekapB($reqUjianId,$reqTipeUjian, $statement, $statementdetil)->first();
          $queryUjianHasil[$i]['hasil']=$query1->kesimpulan;
        }
        else if($reqTipeUjian=='40'){
          $query1= new HasilUjian();      
          $statement= " AND A.JADWAL_TES_ID = ".$reqUjianId." and a.pegawai_id=".$reqPegawaiId;
          $query1=$query1->selectByParamsMonitoringPf16($reqUjianId, $statement)->first();
          $queryUjianHasil[$i]['hasil']='<a href="/app/cetakan/addviewcetak16pf/'.$reqUjianId.'/'.$reqTipeUjian.'/'.$reqPegawaiId.'" target="_blank" class="btn btn-primary font-weight-bolder">
            Cetak
        </a>';
        }
        else if($reqTipeUjian=='18'){
          $query1= new HasilUjian();      
          $statement= " AND B.JADWAL_TES_ID = ".$reqUjianId." and a.pegawai_id=".$reqPegawaiId;
          $query1=$query1->selectByParamsMonitoringPapiHasil($reqUjianId, $statement)->first();
          $queryUjianHasil[$i]['hasil']='<a href="/app/cetakan/addviewcetakPapikostik/'.$reqUjianId.'/'.$reqTipeUjian.'/'.$reqPegawaiId.'" target="_blank" class="btn btn-primary font-weight-bolder">
            Cetak
        </a>';
        }
        else if($reqTipeUjian=='7'){
          $query1= new HasilUjian();      
          $statement= " AND a.JADWAL_TES_ID = ".$reqUjianId." and a.pegawai_id=".$reqPegawaiId;
          $query1=$query1->selectByParamsMonitoringIst($reqUjianId, $statement)->first();
          $queryUjianHasil[$i]['hasil']=$query1->iq;
        }
        else if($reqTipeUjian=='41'){
          $query1= new HasilUjian();      
          $statement= " AND a.JADWAL_TES_ID = ".$reqUjianId." and a.pegawai_id=".$reqPegawaiId;
          $query1=$query1->selectByParamsMonitoringMbtiNew($reqUjianId, $statement)->first();
          if($query1->konversi_info==''){
            $hasil='-';
          }
          else{
            $hasil=$query1->konversi_info;
          }
          $queryUjianHasil[$i]['hasil']=$hasil;
        }
        else if($reqTipeUjian=='42'){
          $query1= new HasilUjian();      
          $statement= " AND B.JADWAL_TES_ID = ".$reqUjianId." and a.pegawai_id=".$reqPegawaiId;
          $query1=$query1->selectByParamsMonitoringPapiHasil($reqUjianId, $statement)->first();
          $queryUjianHasil[$i]['hasil']='<a href="/app/cetakan/addviewcetakDISC/'.$reqUjianId.'/'.$reqTipeUjian.'/'.$reqPegawaiId.'" target="_blank" class="btn btn-primary font-weight-bolder">
            Cetak
        </a>';
        }
        else if($reqTipeUjian=='66'){
          $query1= new HasilUjian();      
          $statement= " AND B.JADWAL_TES_ID = ".$reqUjianId." and a.pegawai_id=".$reqPegawaiId;
          $query1=$query1->selectByParamsMonitoringPapiHasil($reqUjianId, $statement)->first();
          $queryUjianHasil[$i]['hasil']='<a href="/app/cetakan/addviewcetakMMPI/'.$reqUjianId.'/'.$reqTipeUjian.'/'.$reqPegawaiId.'" target="_blank" class="btn btn-primary font-weight-bolder">
            Cetak
        </a>';        
        }
        else{
          $queryUjianHasil[$i]['hasil']='-';
        }
      }

      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('asesor/identitas_cat', compact('query','queryJadwal','queryUjianHasil','reqPegawaiId','queryCekFile'));
    }

    public function penilaian(request $request)
    {
      $reqPegawaiId=$this->user->penilaian_pegawai_id;
      $reqUjianId = $this->user->penilaian_ujian_id;
      $reqTgl = $this->user->penilaian_tgl;
      $tempAsesorId = $this->user->pegawai_id;
      $reqId=$request->route('id');

      $statement="AND EXISTS
      (
        SELECT 1
        FROM
        (
          SELECT JADWAL_ACARA_ID
          FROM jadwal_asesor A
          WHERE 1=1 AND A.JADWAL_TES_ID = ".$reqUjianId." AND A.ASESOR_ID = ".$tempAsesorId."
          AND EXISTS
          (
          SELECT 1
          FROM jadwal_pegawai X 
          WHERE X.PEGAWAI_ID = ".$reqPegawaiId." AND A.JADWAL_ASESOR_ID = X.JADWAL_ASESOR_ID
          )
        ) X
        WHERE A.JADWAL_ACARA_ID = X.JADWAL_ACARA_ID
      )";
      
      $statement=' and pegawai_id='.$reqPegawaiId;
      $query = new Pegawai();
      $queryIdentitas=$query->selectByParamsMonitoring($statement)->first();

      $statement='';
      $statemenIdentitas=' and jadwal_asesor_id='.$reqId;
      $query = new Penilaian();
      $query=$query->selectByParamsPenggalianAsesorPegawai($statement,$statemenIdentitas)->first();
        // print_r($query);exit;
      $statement= "and C1.penggalian_id=".$query->penggalian_id." AND C.JADWAL_TES_ID = ".$reqUjianId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND C1.PENGGALIAN_ID > 0 AND F.ASPEK_ID = 2";
      $statementInner= "and penggalian_id=".$query->penggalian_id." AND C.JADWAL_TES_ID = ".$reqUjianId." AND a.PEGAWAI_ID = ".$reqPegawaiId." AND PENGGALIAN_ID > 0 AND ASPEK_ID = 2";
    //   $statement.= " AND EXISTS (SELECT 1 FROM atribut_penggalian X WHERE D.FORMULA_ATRIBUT_ID = X.FORMULA_ATRIBUT_ID AND C1.PENGGALIAN_ID = X.PENGGALIAN_ID)";
      $sOrder='ORDER BY UR.URUT , atribut_id asc';

      $queryPenialanPegawai = new AsesorBaru();
      $queryPenialanPegawai=$queryPenialanPegawai->selectByParamsPegawaiPenilaian($statement,$statementInner,$sOrder);
      $statement=" and pegawai_id=".$reqPegawaiId." and ujian_id=".$reqUjianId." and b.penggalian_id=".$query->penggalian_id;
      $queryPenialanPegawaiJawaban = new PermohonanFile();
      $queryPenialanPegawaiJawaban=$queryPenialanPegawaiJawaban->selectByParamsPenggalianAsesorJawaban($statement,$sOrder)->first();
      if($query->penggalian_kode=='PE'){
        $queryPenialanPegawaiJawaban = new SoalPe();
        $queryPenialanPegawaiJawaban=$queryPenialanPegawaiJawaban->selectByParamsSoalJawaban('',$reqPegawaiId, $reqUjianId);
      }
      else if($query->penggalian_kode=='ITR'){
        $statement=" and b.ujian_id= ".$reqUjianId."  and c.kode='ITR'";
        $queryPenialanPegawaiJawaban = new SoalIntray();
        $queryPenialanPegawaiJawaban=$queryPenialanPegawaiJawaban->selectByParamsSoalJawaban($statement,$reqPegawaiId);
      }
      $penggalian_kode=$query->penggalian_kode;
      if($query->penggalian_kode=='PE'){
        return view('asesor/penilaian_pe', compact('query','queryPenialanPegawai','reqId','queryPenialanPegawaiJawaban','penggalian_kode','queryIdentitas'));
      }
      else if($query->penggalian_kode=='ITR'){
        return view('asesor/penilaian_itr', compact('query','queryPenialanPegawai','reqId','queryPenialanPegawaiJawaban','penggalian_kode','queryIdentitas'));
      }
      else{
        return view('asesor/penilaian', compact('query','queryPenialanPegawai','reqId','queryPenialanPegawaiJawaban','penggalian_kode','queryIdentitas'));

      }
    }

    public function jadwalpenilaian(request $request)
    {
      $tgl=$request->route('tgl');
      $tempAsesorId = $this->user->pegawai_id;

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $query = new AsesorBaru();
      $statement= " AND TO_CHAR(jt.TANGGAL_TES, 'DD-MM-YYYY') = '".$tgl."' and ja.asesor_id=".$tempAsesorId;
      $query=$query->selectByParamsDataAsesorPegawaiSuper($statement);
      
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('asesor/jadwal_penilaian', compact('query','tgl'));
    }

    public function nilaiakhir(request $request)
    {
      $reqPegawaiId=$this->user->penilaian_pegawai_id;
      $reqUjianId = $this->user->penilaian_ujian_id;
      $reqTgl = $this->user->penilaian_tgl;
      $tempAsesorId = $this->user->pegawai_id;
      $reqId=$request->route('id');

      $statement="AND EXISTS
      (
        SELECT 1
        FROM
        (
          SELECT JADWAL_ACARA_ID
          FROM jadwal_asesor A
          WHERE 1=1 AND A.JADWAL_TES_ID = ".$reqUjianId." AND A.ASESOR_ID = ".$tempAsesorId."
          AND EXISTS
          (
          SELECT 1
          FROM jadwal_pegawai X 
          WHERE X.PEGAWAI_ID = ".$reqPegawaiId." AND A.JADWAL_ASESOR_ID = X.JADWAL_ASESOR_ID
          )
        ) X
        WHERE A.JADWAL_ACARA_ID = X.JADWAL_ACARA_ID
      )";

      $statemenIdentitas=' and jadwal_asesor_id='.$reqId;
      $query = new Penilaian();
      $query=$query->selectByParamsPenggalianAsesorPegawai($statement,$statemenIdentitas)->first();
      // print_r($query);exit;

      $statement="AND EXISTS
      (
        SELECT 1
        FROM
        (
          SELECT JADWAL_ACARA_ID
          FROM jadwal_asesor A
          WHERE 1=1 AND A.JADWAL_TES_ID = ".$reqUjianId." AND A.ASESOR_ID = ".$tempAsesorId."
          AND EXISTS
          (
          SELECT 1
          FROM jadwal_pegawai X 
          WHERE X.PEGAWAI_ID = ".$reqPegawaiId." AND A.JADWAL_ASESOR_ID = X.JADWAL_ASESOR_ID
          )
        ) X
        WHERE A.JADWAL_ACARA_ID = X.JADWAL_ACARA_ID
      )";

      $statement= " AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.JADWAL_TES_ID = ".$reqUjianId;

      $queryPenialanPegawai = new AsesorBaru();
      $queryPenialanPegawai=$queryPenialanPegawai->selectByParamsNilaiAkhir($statement);

      $statement= " AND A.PEGAWAI_ID = ".$reqPegawaiId." AND B.PENGGALIAN_ID > 0
      AND EXISTS
      (
        SELECT 1 FROM jadwal_asesor X WHERE JADWAL_TES_ID = ".$reqUjianId." AND A.JADWAL_ASESOR_ID = X.JADWAL_ASESOR_ID
      )";

      $arrPegawaiAsesor = new JadwalAsesor();
      $arrPegawaiAsesor=$arrPegawaiAsesor->selectByParamsPenggalianPegawai($statement);

      $statement= "  AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.JADWAL_TES_ID = ".$reqUjianId;

      $arrPegawaiPenilaian = new JadwalAsesor();
      $arrPegawaiPenilaian=$arrPegawaiPenilaian->selectByParamsPenilaianPegawaiAtribut($statement);

      $statement= " AND C.JADWAL_TES_ID = ".$reqUjianId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND C1.PENGGALIAN_ID > 0 AND F.ASPEK_ID = 2";
      $statement.= " AND EXISTS (SELECT 1 FROM atribut_penggalian X WHERE D.FORMULA_ATRIBUT_ID = X.FORMULA_ATRIBUT_ID AND C1.PENGGALIAN_ID = X.PENGGALIAN_ID)";

      $arrAsesorPenilaianKompetensi = new JadwalAsesor();
      $arrAsesorPenilaianKompetensi=$arrAsesorPenilaianKompetensi->selectByParamsAsesorKompetensi($statement);

      return view('asesor/nilai_akhir', compact('queryPenialanPegawai','query','reqId','arrPegawaiAsesor','arrPegawaiPenilaian','tempAsesorId','arrAsesorPenilaianKompetensi'));
    }

    public function psikotest(request $request)
    {
      $reqPegawaiId=$this->user->penilaian_pegawai_id;
      $reqUjianId = $this->user->penilaian_ujian_id;
      $reqTgl = $this->user->penilaian_tgl;
      $tempAsesorId = $this->user->pegawai_id;
      $reqId=$request->route('id');

      $statement="AND EXISTS
      (
        SELECT 1
        FROM
        (
          SELECT JADWAL_ACARA_ID
          FROM jadwal_asesor A
          WHERE 1=1 AND A.JADWAL_TES_ID = ".$reqUjianId." AND A.ASESOR_ID = ".$tempAsesorId."
          AND EXISTS
          (
          SELECT 1
          FROM jadwal_pegawai X 
          WHERE X.PEGAWAI_ID = ".$reqPegawaiId." AND A.JADWAL_ASESOR_ID = X.JADWAL_ASESOR_ID
          )
        ) X
        WHERE A.JADWAL_ACARA_ID = X.JADWAL_ACARA_ID
      )";

      $statemenIdentitas=' and jadwal_asesor_id='.$reqId;
      $query = new Penilaian();
      $query=$query->selectByParamsPenggalianAsesorPegawai($statement,$statemenIdentitas)->first();
      // print_r($query);exit;

      $statement="AND EXISTS
      (
        SELECT 1
        FROM
        (
          SELECT JADWAL_ACARA_ID
          FROM jadwal_asesor A
          WHERE 1=1 AND A.JADWAL_TES_ID = ".$reqUjianId." AND A.ASESOR_ID = ".$tempAsesorId."
          AND EXISTS
          (
          SELECT 1
          FROM jadwal_pegawai X 
          WHERE X.PEGAWAI_ID = ".$reqPegawaiId." AND A.JADWAL_ASESOR_ID = X.JADWAL_ASESOR_ID
          )
        ) X
        WHERE A.JADWAL_ACARA_ID = X.JADWAL_ACARA_ID
      )";

      $statement= " AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.JADWAL_TES_ID = ".$reqUjianId;

      $queryPenialanPegawai = new AsesorBaru();
      $queryPenialanPegawai=$queryPenialanPegawai->selectByParamsNilaiAkhir($statement);
      // print_r($query);exit;
      return view('asesor/psikotest', compact('queryPenialanPegawai','query','reqId'));
    }

    public function kesimpulan(request $request)
    {
      $reqPegawaiId=$this->user->penilaian_pegawai_id;
      $reqUjianId = $this->user->penilaian_ujian_id;
      $reqTgl = $this->user->penilaian_tgl;
      $tempAsesorId = $this->user->pegawai_id;
      $reqId=$request->route('id');

      $statement="AND EXISTS
      (
        SELECT 1
        FROM
        (
          SELECT JADWAL_ACARA_ID
          FROM jadwal_asesor A
          WHERE 1=1 AND A.JADWAL_TES_ID = ".$reqUjianId." AND A.ASESOR_ID = ".$tempAsesorId."
          AND EXISTS
          (
          SELECT 1
          FROM jadwal_pegawai X 
          WHERE X.PEGAWAI_ID = ".$reqPegawaiId." AND A.JADWAL_ASESOR_ID = X.JADWAL_ASESOR_ID
          )
        ) X
        WHERE A.JADWAL_ACARA_ID = X.JADWAL_ACARA_ID
      )";

      $statemenIdentitas=' and jadwal_asesor_id='.$reqId;
      $query = new Penilaian();
      $query=$query->selectByParamsPenggalianAsesorPegawai($statement,$statemenIdentitas)->first();

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      $satuan_kerja = new SatuanKerjaController();

      // $satker=$satuan_kerja->combo_cabang($request,$reqUnitKerjaId);

      $statement="and tipe='profil_kekuatan' and jadwal_tes_id=".$reqUjianId;
      $profil_kekuatan = new PenilaianRekomendasi();
      $profil_kekuatan=$profil_kekuatan->selectByParamsMonitoring($statement)->first();

      $statement="and tipe='profil_kelemahan' and jadwal_tes_id=".$reqUjianId;
      $profil_kelemahan = new PenilaianRekomendasi();
      $profil_kelemahan=$profil_kelemahan->selectByParamsMonitoring($statement)->first();

      $statement="and tipe='profil_rekomendasi' and jadwal_tes_id=".$reqUjianId;
      $profil_rekomendasi = new PenilaianRekomendasi();
      $profil_rekomendasi=$profil_rekomendasi->selectByParamsMonitoring($statement)->first();

      $statement="and tipe='profil_saran_pengembangan' and jadwal_tes_id=".$reqUjianId;
      $profil_saran_pengembangan = new PenilaianRekomendasi();
      $profil_saran_pengembangan=$profil_saran_pengembangan->selectByParamsMonitoring($statement)->first();

      $statement="and tipe='profil_saran_penempatan' and jadwal_tes_id=".$reqUjianId;
      $profil_saran_penempatan = new PenilaianRekomendasi();
      $profil_saran_penempatan=$profil_saran_penempatan->selectByParamsMonitoring($statement)->first();

      $statement="and tipe='profil_kepribadian' and jadwal_tes_id=".$reqUjianId;
      $profil_kepribadian = new PenilaianRekomendasi();
      $profil_kepribadian=$profil_kepribadian->selectByParamsMonitoring($statement)->first();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('asesor/kesimpulan', compact('profil_kekuatan','profil_kelemahan','profil_rekomendasi','profil_saran_pengembangan','profil_saran_penempatan','profil_kepribadian','query','reqId'));
    }

    public function addAsesor(request $request)
    {

      $reqActive= $request->reqActive;
      $reqJadwalPegawaiDetilId= $request->reqJadwalPegawaiDetilId;
      $reqPenggalianId= $request->reqPenggalianId;
      $reLevelId= $request->reLevelId;
      $reqIndikatorId= $request->reqIndikatorId;
      $reqJadwalPegawaiId= $request->reqJadwalPegawaiId;
      $reqJadwalAsesorId= $request->reqJadwalAsesorId;
      $reqAtributId= $request->reqAtributId;
      $reqFormPermenId= $request->reqFormPermenId;
      $reqJadwalTesId= $request->reqJadwalTesId;
      $reqPegawaiId= $request->reqPegawaiId;
      $reqAsesorId= $request->reqAsesorId;

      $reqJadwalPegawaiDetilAttributId=$request->reqJadwalPegawaiDetilAttributId;
      $reqJadwalTesId=$request->reqJadwalTesId;
      $reqPenggalianIdAttribut=$request->reqPenggalianIdAttribut;
      $reqJadwalPegawaiIdAttribut=$request->reqJadwalPegawaiIdAttribut;
      $reqJadwalAsesorIdAttribut=$request->reqJadwalAsesorIdAttribut;
      $reqAtributIdAttribut=$request->reqAtributIdAttribut;
      $reqPegawaiId=$request->reqPegawaiId;
      $reqAsesorId=$request->reqAsesorId;
      $reqFormPermenIdAttribut=$request->reqFormPermenIdAttribut;
      $reqNilaiStandartAttribut=$request->reqNilaiStandartAttribut;
      $reqNilaiAttribut=$request->reqNilaiAttribut;
      $reqCatatanAttribut=$request->reqCatatanAttribut;
      
      if(!empty($reqCatatanAttribut)){
          for($i=0;$i<count($reqCatatanAttribut);$i++){
              if(empty($reqCatatanAttribut[$i])){
                  return StringFunc::json_response(200,"xxx-Isi Evidance.");
              }
          }
      }
        
      // DB::enableQueryLog();
      for($i=0; $i<count($reqActive); $i++){
        if(empty($reqJadwalPegawaiDetilId[$i]))
        {
          if($reqActive[$i]==1){
            $maxId = JadwalPegawaiDetil::NextId();
            $query = new JadwalPegawaiDetil();
            // nama kolom yang di insert
            $query->jadwal_pegawai_detil_id = $maxId;
            $query->jadwal_tes_id = $reqJadwalTesId;
            $query->penggalian_id = $reqPenggalianId[$i];
            $query->level_id = $reLevelId[$i];
            $query->indikator_id = $reqIndikatorId[$i];
            $query->jadwal_pegawai_id = $reqJadwalPegawaiId[$i];
            $query->jadwal_asesor_id = $reqJadwalAsesorId[$i];
            $query->atribut_id = $reqAtributId[$i];
            $query->pegawai_id = $reqPegawaiId;
            $query->asesor_id = $reqAsesorId;
            $query->form_permen_id = $reqFormPermenId[$i];
            $query->last_create_user = $this->user->user_app_id;
            $query->last_create_date = Carbon::now();            
            $query->save();            
          }
        }else{
          if(empty($reqActive[$i])){
            JadwalPegawaiDetil::where('jadwal_pegawai_detil_id', $reqJadwalPegawaiDetilId[$i])
            ->delete();
          }    
        }
      }

      for($i=0; $i<count($reqJadwalPegawaiDetilAttributId); $i++){
        if(empty($reqJadwalPegawaiDetilAttributId[$i]))
        {
          $maxId = JadwalPegawaiDetilAtribut::NextId();
          $query = new JadwalPegawaiDetilAtribut();
          // nama kolom yang di insert
          $query->jadwal_pegawai_detil_atribut_id = $maxId;
          $query->last_create_user = $this->user->user_app_id;
          $query->last_create_date = Carbon::now();      
        }else{
          $query = JadwalPegawaiDetilAtribut::findOrFail($reqJadwalPegawaiDetilAttributId[$i]);
          $query->jadwal_pegawai_detil_atribut_id = $reqJadwalPegawaiDetilAttributId[$i];
          $query->last_update_user = $this->user->user_app_id;
          $query->last_update_date = Carbon::now();
        }
        
        $query->jadwal_tes_id = $reqJadwalTesId;
        $query->penggalian_id = $reqPenggalianIdAttribut[$i];
        $query->jadwal_pegawai_id = $reqJadwalPegawaiIdAttribut[$i];
        $query->jadwal_asesor_id = $reqJadwalAsesorIdAttribut[$i];
        $query->atribut_id = $reqAtributIdAttribut[$i];
        $query->pegawai_id = $reqPegawaiId;
        $query->asesor_id = $reqAsesorId;
        $query->form_permen_id = $reqFormPermenIdAttribut[$i];
        $query->nilai_standar = $reqNilaiStandartAttribut[$i];
        $query->nilai = $reqNilaiAttribut[$i];
        $query->gap = $reqNilaiAttribut[$i]-$reqNilaiStandartAttribut[$i];
        if(!empty($reqCatatanAttribut[$i])){
            $query->catatan = $reqCatatanAttribut[$i];
        }
       
        $query->save();            
      }

      return StringFunc::json_response(200,"10-Data berhasil disimpan.");
      
    }

    public function addNilaiAkhir(request $request)
    {
      $reqPenilaianDetilId= $request->reqPenilaianDetilId;
      $reqNilai= $request->reqNilai;
      $reqCatatan= $request->reqCatatan;
      $reqNilaiStandart= $request->reqNilaiStandart;
    //   print_r($reqCatatan);exit;
      for($i=0; $i<count($reqPenilaianDetilId);$i++){
        $query = PenilaianDetil::findOrFail($reqPenilaianDetilId[$i]);
        $query->nilai = $reqNilai[$i];
        // $query->catatan = $reqCatatan[$i];
        $query->gap = $reqNilai[$i]-$reqNilaiStandart[$i];
        $query->save();            
      }
      
    
      return StringFunc::json_response(200,"10-Data berhasil disimpan.");
      
    }

    public function addKesimpulan(request $request)
    {
      $reqPegawaiId=$this->user->penilaian_pegawai_id;
      $reqJadwalTesId = $this->user->penilaian_ujian_id;
      $reqPenilaianRekomendasiId = $request->reqPenilaianRekomendasiId;
      $reqKeterangan = $request->reqKeterangan;
      $reqTipeInputan = $request->reqTipeInputan;
      for($i=0; $i<count($reqPenilaianRekomendasiId);$i++){
        if(empty($reqPenilaianRekomendasiId[$i]))
        {
          $maxId = PenilaianRekomendasi::NextId();
          $query = new PenilaianRekomendasi();
          // nama kolom yang di insert
          $query->penilaian_rekomendasi_id = $maxId;
        }else{
          $query = PenilaianRekomendasi::findOrFail($reqPenilaianRekomendasiId[$i]);
        }
        $query->pegawai_id = $reqPegawaiId;
        $query->jadwal_tes_id = $reqJadwalTesId;
        $query->keterangan = $reqKeterangan[$i];
        $query->tipe = $reqTipeInputan[$i];
        $query->save();            
      }
      
    
      return StringFunc::json_response(200,"10-Data berhasil disimpan.");
      
    }

    public function add(request $request)
    {
      $reqNama = $request->reqNama;
      $reqRole = $request->reqRole;
      $reqUname = $request->reqUname;
      $reqPass = $request->reqPass;
      $reqId = $request->reqId;
      $reqPegawaiId = $request->reqPegawaiId;


      $statement=" and user_login='".$reqUname."'";
      $query= new Asesor();
      $query=$query->selectByParamsMonitoringAsesor($statement)->first();
      
      if(!empty($query)){
        return StringFunc::json_response(200,"xxx-Username Sudah Ada. Pilih Username Lain.");
        exit;
      }
      
      if($reqRole==2){
        if(empty($reqPegawaiId))
        {
            
          $maxId = AsesorBaru::NextId();
          $query = new AsesorBaru();
          // nama kolom yang di insert
          $query->asesor_id = $maxId;
          $reqPegawaiId=$maxId;
        }else{
          $query = AsesorBaru::findOrFail($reqPegawaiId);
          // echo 'xxx';exit;
        }
        $query->nama = $reqNama;
        $query->save();
      }
      else{
        AsesorBaru::where('asesor_id', $reqPegawaiId)
            ->delete();
      }

      if(empty($reqId))
      {
        $maxId = UserApp::NextId();
        $query = new UserApp();
        // nama kolom yang di insert
        $query->user_app_id = $maxId;
        $reqId = $maxId;
      }else{
        $query = UserApp::findOrFail($reqId);
      }
      $query->nama = $reqNama;
      $query->user_group_id = $reqRole;
      $query->user_login = $reqUname;
      if($reqRole==2){
        $query->pegawai_id = $reqPegawaiId;
      }
      else{
        $query->pegawai_id = null;
      }
      if(!empty($reqPass)){
        $query->user_pass = md5($reqPass);
      }
      $query->save();
    
      return StringFunc::json_response(200,$reqId."-Data berhasil disimpan.");
      
    }

    public function datadiripdf()
    {
        $data = [
            'title' => 'Contoh PDF',
            'content' => 'Ini adalah contoh konten untuk PDF yang dihasilkan menggunakan mPDF di Laravel.'
        ];

        $html = view('cetakan/data_diri', $data)->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('document.pdf', 'I');
    }

    public function laporanindividupdf(request $request)
    {
        $reqId= $request->route('id');
        $reqJadwalTesId=$this->user->penilaian_ujian_id;

        $statement= " AND A.PEGAWAI_ID = ".$reqId;
        $statement.= " AND EXISTS (SELECT 1 FROM jadwal_tes_simulasi_pegawai X WHERE 1=1 AND X.JADWAL_TES_ID = ".$reqJadwalTesId." AND X.PEGAWAI_ID = A.PEGAWAI_ID)";   
        $data1 = new CetakanLaporanIndividu();
        $data1=$data1->selectByParamsLookupJadwalPegawai($statement,$this->user->penilaian_ujian_id)->first();

        $statement= " AND A.PEGAWAI_ID = ".$reqId." AND A.JADWAL_TES_ID = ".$reqJadwalTesId." and aspek_id =1";
        $AspekPotensi = new CetakanLaporanIndividu();
        $AspekPotensi=$AspekPotensi->selectByParamsPenilaianAsesor($statement);

        $reqTanggalTes = explode(' ',$data1->tanggal_tes);
        $tempTahun = DateFunc::getDay($reqTanggalTes[0]);
        $statement= "  AND TO_CHAR(P.TANGGAL_TES, 'YYYY') = '".$tempTahun."' AND P.PEGAWAI_ID = ".$reqId." AND P.JADWAL_TES_ID = ".$reqJadwalTesId;
        $statementgroup= "  AND A.ASPEK_ID = '2'";
        $AspekKompetensi = new CetakanLaporanIndividu();
        $AspekKompetensi=$AspekKompetensi->selectByParamsAtributPegawaiPenilaian($statement,$statementgroup);

        $statement= "  AND A.JADWAL_TES_ID = '".$reqJadwalTesId."' AND A.PEGAWAI_ID = ".$reqId." and a.aspek_id=2";  
        $SumPenilaian = new CetakanLaporanIndividu();
        $SumPenilaian=$SumPenilaian->selectByParamsSumPenilaian($statement)->first();

        $statement= "  AND A.JADWAL_TES_ID = '".$reqJadwalTesId."' AND A.PEGAWAI_ID = ".$reqId; 
        $statementgroup= "";
        $JPM = new CetakanLaporanIndividu();
        $JPM=$JPM->selectByParamsPenilaianJpmAkhir($statement,$statementgroup)->first();

        $statement= "  AND A.JADWAL_TES_ID = '".$reqJadwalTesId."' AND A.PEGAWAI_ID = ".$reqId; 
        $statementgroup= "";
        $PenilaianRekomendasi = new CetakanLaporanIndividu();
        $PenilaianRekomendasi=$PenilaianRekomendasi->selectByParamsPenilaianRekomendasi($statement);

        $statement= " AND PEGAWAI_ID = ".$reqId; 
        $ttdCbi = new CetakanLaporanIndividu();
        $ttdCbi=$ttdCbi->selectByParamsTtdCbi($statement)->first();

        // print_r($AspekKompetensi);exit;
        $data = [
            'title' => 'Contoh PDF',
            'content' => 'Ini adalah contoh konten untuk PDF yang dihasilkan menggunakan mPDF di Laravel.',
            'data1' => $data1,
            'AspekPotensi' => $AspekPotensi,
            'AspekKompetensi' => $AspekKompetensi,
            'SumPenilaian' => $SumPenilaian,
            'JPM' => $JPM,
            'PenilaianRekomendasi' => $PenilaianRekomendasi,
            'reqId' => $reqJadwalTesId,
            'ttdCbi' => $ttdCbi
        ];

        $html = view('cetakan/laporan_individu', $data)->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('document.pdf', 'I');
    }

    public function addviewlookupgasilujian(request $request) 
    {
      $reqFilter='';
      // return view('asesor/identitas_cat/', compact('reqFilter'));
      return view('asesor/identitas_cat', compact('reqFilter'));
    }

    public function addview(request $request) 
    {      
      $reqId= $request->route('id');
      if(empty($reqId)){
        $reqId='';
        $query='';
      }
      else{
        $statement=' and user_app_id='.$reqId;
        $query= new Asesor();
        $query=$query->selectByParamsMonitoringAsesor($statement)->first();
      }
      // return view('asesor/identitas_cat/', compact('reqFilter'));
      return view('app/asesor_add', compact('reqId','query'));
    }



    public function delete($request)
    {
      $reqId = $request;

      $statement=' and user_app_id='.$reqId;
        $query= new Asesor();
        $query=$query->selectByParamsMonitoringAsesor($statement)->first();
        $pegawai_id=$query->pegawai_id;

      AsesorBaru::where('asesor_id', $pegawai_id)
      ->delete();

      UserApp::where('user_app_id', $reqId)
      ->delete();
      
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }
}