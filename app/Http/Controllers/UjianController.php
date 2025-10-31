<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\SatuanKerja;
use App\Models\UserLogin;
use App\Models\TipeUjian;
use App\Models\Ujian;
use App\Models\UjianTahapStatusUjian;
use App\Models\UjianTahapPegawai;
use App\Models\JadwalTes;
use App\Models\PermohonanFile;
use App\Models\EssayJawaban;
use App\Models\JadwalAwalTes;
use App\Models\SoalPe;
use App\Models\JawabanPe;
use App\Models\Penggalian;
use App\Models\EssaySoal;
use App\Models\SoalIntray;
use App\Models\JawabanItr;

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

use Illuminate\Support\Facades\Log;

class UjianController extends Controller
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
        Route::get('/app/ujian/dashboard', [UjianController::class,'dashboard']);
        Route::get('/app/ujian/persiapan', [UjianController::class,'persiapan']);
        Route::get('/app/ujian/pilihujian', [UjianController::class,'pilihujian']);
        Route::get('/app/ujian/pilihujianessay', [UjianController::class,'pilihujianessay']);
        Route::get('/app/ujian/popup_ujian/{id?}/{tahapid?}', [UjianController::class,'popup_ujian']);
        Route::get('/app/ujian/ujian_online/{id?}/{urutan?}', [UjianController::class,'ujian_online']);
        Route::get('/app/ujian/selesai/{id?}', [UjianController::class,'selesai']);
        Route::get('/app/ujian/lookup/{link?}/{id?}/{tahapid?}/{tipe?}/{urutan?}', [UjianController::class,'lookup']);
        Route::get('/app/ujian/lookup_itr/{link?}/{id?}/{tahapid?}/{tipe?}/{urutan?}', [UjianController::class,'lookup_itr']);
        Route::get('/app/ujian/ujian_online_essay/{id}',[ UjianController::class, "ujian_online_essay" ]);
        Route::get('/app/ujian/ujian_online_essay_new/{id}',[ UjianController::class, "ujian_online_essay_new" ]);
        Route::get('/app/ujian/ujian_online_essay_new_pe/{id}',[ UjianController::class, "ujian_online_essay_new_pe" ]);
        Route::get('/app/ujian/ujian_online_essay_new_pe',[ UjianController::class, "ujian_online_essay_new_pe" ]);
        Route::get('/app/ujian/ujian_online_essay_new_itr/{id}',[ UjianController::class, "ujian_online_essay_new_itr" ]);
        Route::get('/app/ujian/ujian_online_essay_new_itr',[ UjianController::class, "ujian_online_essay_new_itr" ]);
        Route::get('/app/ujian/uploaddrh/{id}',[ UjianController::class, "uploaddrh" ]);

        //buat route proses

        Route::post('Ujian/add/{id?}', [UjianController::class,'add']);
        Route::delete('Ujian/delete/{id}',[ UjianController::class, "delete" ]);
        Route::get('Ujian/ujian_online_finish/{id}',[ UjianController::class, "ujian_online_finish" ]);
        Route::get('Ujian/ujian_online_selesai_hafal/{id}',[ UjianController::class, "ujian_online_selesai_hafal" ]);

        Route::get('Ujian/petunjuk_cek/{tempUjianId?}/{tahapid?}', [UjianController::class,'petunjuk_cek']);
        Route::get('Ujian/ujian_tahap_mulai/{tipeujianid?}', [UjianController::class,'ujian_tahap_mulai']);
        Route::post('Ujian/addUpload', [UjianController::class,'addUpload']);
        Route::post('Ujian/essayJawaban', [UjianController::class,'essayJawaban']);
        Route::post('Ujian/jawabPe', [UjianController::class,'jawabPe']);
        Route::post('Ujian/jawabPeSemua', [UjianController::class,'jawabPeSemua']);
        Route::post('Ujian/jawabItr', [UjianController::class,'jawabItr']);
        Route::post('Ujian/jawabItrSatu', [UjianController::class,'jawabItrSatu']);
        Route::match(['get', 'post'],'Ujian/jawab/{reqId?}/{reqUjianId?}/{reqTipeUjianId?}/{reqBankSoalId?}/{reqBankSoalPilihanId?}/{reqPegawaiId?}', [UjianController::class,'jawab']);
        Route::get('Ujian/jawabdua/{reqId?}/{reqUjianId?}/{reqTipeUjianId?}/{reqBankSoalId?}/{reqBankSoalPilihanId?}/{reqPegawaiId?}', [UjianController::class,'jawabdua']);

    }

    public function dashboard(request $request) {
     $satuan_kerja = new SatuanKerjaController();
     // $cabangid=$this->CABANG_ID;
     // $satker=$satuan_kerja->combo_cabang($request,$cabangid);

     $jenis='1';
     // dd($jenis);
     // return view("app/pegawai/index",compact('satker','cabangid','jenis'));
     return view("ujian/dashboard",compact('jenis'));
    }

    public function persiapan(request $request) {
     $satuan_kerja = new SatuanKerjaController();
     // $cabangid=$this->CABANG_ID;
     // $satker=$satuan_kerja->combo_cabang($request,$cabangid);

     $jenis='1';
     $statement=" and jadwal_tes_id=".$this->user->jadwal_tes_id;
     $query = new JadwalTes();
     $query=$query->selectByParamsMonitoring($statement)->first();
     return view("ujian/persiapan",compact('query'));
    }

    public function pilihujian(request $request) {
      // print_r($this->user->ujian_id);exit;
      date_default_timezone_set("Asia/Jakarta"); 
      $sekarang = date("H:i");
      $user = Session::get('user');
      if ($sekarang < $user->waktu_mulai) {
        return redirect()->to('/app/index');
      }
      
      $set = new TipeUjian();
      $statement= " AND COALESCE(B.MENIT_SOAL,0) > 0 AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id;
      $tipe_ujian=$set->selectByParamsUjianPilihan($statement); 

      $identitas=$this->user;

      $statement=" and jadwal_tes_id=".$this->user->jadwal_tes_id;
      $query = new JadwalTes();
      $query=$query->selectByParamsMonitoring($statement)->first();
    //   print_r($query);exit;

      $reqTanggalTes = explode(' ',$query->tanggal_tes);
      $reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
      $tempTahun = DateFunc::getYear($reqTanggalTes);

      $soalessay = new PermohonanFile();
      $soalessay=$soalessay->selectByParamsPenggalianUjian($tempTahun,$this->user->jadwal_tes_id, $this->user->pegawai_id);
    //   print_r($soalessay);exit;

      return view("ujian/pilih_ujian",compact('tipe_ujian','identitas','soalessay','query'));
    }

    public function pilihujianessay(request $request) {
      // print_r($this->user);exit;
      $statement=" and jadwal_tes_id=".$this->user->jadwal_tes_id;
      $query = new JadwalTes();
      $query=$query->selectByParamsMonitoring($statement)->first();

      $reqTanggalTes = explode(' ',$query->tanggal_tes);
      $reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
      $tempTahun = DateFunc::getYear($reqTanggalTes);

      $query = new PermohonanFile();
      $tipe_ujian=$query->selectByParamsPenggalian($tempTahun,$this->user->jadwal_tes_id,'and b.link_file is not null',$this->user->pegawai_id);

      $identitas=$this->user;

      return view("ujian/pilih_ujian_essay",compact('tipe_ujian','identitas'),);
    }

    public function popup_ujian(request $request) {
      $reqId=$request->route('id');
      $satuan_kerja = new SatuanKerjaController();
     // $cabangid=$this->CABANG_ID;
     // $satker=$satuan_kerja->combo_cabang($request,$cabangid);

     $jenis='1';
     // dd($jenis);
     // return view("app/pegawai/index",compact('satker','cabangid','jenis'));
     return view("ujian/popup_ujian",compact('jenis','reqTipe'));
    }

    public function lookup(request $request,$link) 
    {
      $reqId = $request->route('id');
      $tahapid = $request->route('tahapid');
      $reqTipe = $request->route('tipe');
      $urutan = $request->route('urutan');
      return view('ujian/popup_ujian', compact('reqId','tahapid','reqTipe','urutan'));
    }

    public function lookup_itr(request $request,$link) 
    {
      $reqId = $request->route('id');
      $tahapid = $request->route('tahapid');
      $reqTipe = $request->route('tipe');
      $urutan = $request->route('urutan');

      $statement=" and essay_soal_id=".$reqId;
      $soalessay = new PermohonanFile();
      $tempTahun='2025';
      $soalessay=$soalessay->selectByParamsPenggalianNew($tempTahun,$this->user->jadwal_tes_id,$statement)->first();
      // print_r($soalessay);exit;
      return view('ujian/popup_itr', compact('reqId','tahapid','reqTipe','urutan','soalessay'));
    }

    public function ujian_online(request $request)
    {
      $reqId=$request->route('id');
      $urutan=$request->route('urutan');
      
      date_default_timezone_set("Asia/Jakarta"); 
      $sekarang = date("H:i");
      $user = Session::get('user');
      if($sekarang < $user->waktu_mulai) {
        return redirect()->to('/app/index');
      }

      // $satker=$satuan_kerja->combo_cabang($request,$reqUnitKerjaId);
      // print_r($this->user);exit;

      $statement= " AND A.UJIAN_ID = ".$this->user->ujian_id." AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_TAHAP_ID = ".$reqId;
      $set= new UjianTahapStatusUjian();
      $set=$set->selectByParamsCheck($statement,$this->user->jadwal_tes_id)->first();
    //   print_r($set);exit;
      $reqTipeUjianId=$set->tipe_ujian_id;
      $reqKeteranganUjian=$set->keterangan_ujian;
      // print_r($reqTipeUjianId);exit;

      $set = new TipeUjian();
      $statement= " AND COALESCE(B.MENIT_SOAL,0) > 0 AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id;
      $list_ujian = $set->selectByParamsUjianPilihan($statement);
      $tipe_ujian = $list_ujian->where('tipe_ujian_id', $reqTipeUjianId)->first(); 
      $list_ujian_tahap = $list_ujian->pluck('ujian_tahap_id');
      
      // cek apakah tahap sebelumnya sudah selesai dikerjakan
      $set2 = new UjianTahapStatusUjian();
      $urutan = $tipe_ujian->urutan_ujian;
      $sedangDikerjakan = $set2->checkPreviousTahap($this->user->pegawai_id, $this->user->jadwal_tes_id, $reqId, $urutan, $list_ujian_tahap);
      if ($sedangDikerjakan === false) {
        return redirect()->to('/app/ujian/pilihujian');
      }
      
      if($tipe_ujian->tipe_status==1){
        $set = new TipeUjian();
        $statement= " AND COALESCE(B.MENIT_SOAL,0) > 0 AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id;
        $tipe_ujian=$set->selectByParamsUjianPilihan($statement); 

        $identitas=$this->user;
        return view("ujian/pilih_ujian",compact('tipe_ujian','identitas','urutan'),);
      }


      $queryIdentitas = new Ujian();
      $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId;
      $queryIdentitas=$queryIdentitas->selectByParamsIdentitasUjian($statement)->first();
      
      if($reqTipeUjianId==8 || $reqTipeUjianId==9 || $reqTipeUjianId==10 || $reqTipeUjianId==11 || $reqTipeUjianId==12 || $reqTipeUjianId==13 || $reqTipeUjianId==14 || $reqTipeUjianId==15)
      {
        $querySoal = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND A.UJIAN_ID = ".$this->user->ujian_id;
        $statementujian= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id." AND A.UJIAN_TAHAP_ID = ".$reqId;
        $order=' order by bank_soal_id asc';
        $querySoal=$querySoal->selectByParamsSoalCFID($statement, $statementujian, $this->user->jadwal_tes_id, $order );

        $queryJawaban = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND A.UJIAN_ID = ".$this->user->ujian_id;
        $queryJawaban=$queryJawaban->selectByParamsJawabanCFID($statement, $this->user->ujian_id);

        $queryJawabanPeserta = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND a.UJIAN_TAHAP_ID = ".$reqId." and bank_soal_pilihan_id is not null" ;
        $queryJawabanPeserta=$queryJawabanPeserta->selectByParamsJawabanPesertaCFID($statement, $this->user->jadwal_tes_id);
      }
      // papikostik
      else if($reqTipeUjianId==7 ){
        $querySoal = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND A.UJIAN_ID = ".$this->user->ujian_id;
        $statementujian= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id." AND A.UJIAN_TAHAP_ID = ".$reqId;
        $querySoal=$querySoal->selectByParamsSoalPapi($this->user->jadwal_tes_id, $statement, $statementujian );

        $queryJawaban = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND COALESCE(NULLIF(D.JAWABAN, ''), NULL) IS NOT NULL AND A.UJIAN_ID = ".$this->user->ujian_id;
        $queryJawaban=$queryJawaban->selectByParamsJawabanSoalPapi($statement);

        $queryJawabanPeserta = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND a.UJIAN_TAHAP_ID = ".$reqId." and bank_soal_pilihan_id is not null" ;
        $queryJawabanPeserta=$queryJawabanPeserta->selectByParamsJawabanPesertaCFID($statement, $this->user->jadwal_tes_id);

      }
      else if($reqTipeUjianId==41 ){
        $querySoal = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND A.UJIAN_ID = ".$this->user->ujian_id;
        $statementujian= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id." AND A.UJIAN_TAHAP_ID = ".$reqId;
        $querySoal=$querySoal->selectByParamsSoalMBTI($this->user->jadwal_tes_id, $statement, $statementujian );

        $queryJawaban = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND COALESCE(NULLIF(D.JAWABAN, ''), NULL) IS NOT NULL AND A.UJIAN_ID = ".$this->user->ujian_id;
        $queryJawaban=$queryJawaban->selectByParamsJawabanSoalMBTI($statement);

        $queryJawabanPeserta = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND a.UJIAN_TAHAP_ID = ".$reqId." and bank_soal_pilihan_id is not null" ;
        $queryJawabanPeserta=$queryJawabanPeserta->selectByParamsJawabanPesertaCFID($statement, $this->user->jadwal_tes_id);

      }
      else if($reqTipeUjianId==42 ){
        $querySoal = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND A.UJIAN_ID = ".$this->user->ujian_id;
        $statementujian= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id." AND A.UJIAN_TAHAP_ID = ".$reqId;
        $querySoal=$querySoal->selectByParamsSoalDisc($this->user->jadwal_tes_id, $statement, $statementujian );

        $queryJawaban = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND COALESCE(NULLIF(D.JAWABAN, ''), NULL) IS NOT NULL AND A.UJIAN_ID = ".$this->user->ujian_id;
        $queryJawaban=$queryJawaban->selectByParamsJawabanSoalDisc($statement);

        $queryJawabanPeserta = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND a.UJIAN_TAHAP_ID = ".$reqId." and bank_soal_pilihan_id is not null" ;
        $queryJawabanPeserta=$queryJawabanPeserta->selectByParamsJawabanPesertaCFID($statement, $this->user->jadwal_tes_id);

      }
      else if($reqTipeUjianId==66 ){
        $querySoal = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND A.UJIAN_ID = ".$this->user->ujian_id;
        $statementujian= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id." AND A.UJIAN_TAHAP_ID = ".$reqId;
        $querySoal=$querySoal->selectByParamsSoalMMPI($this->user->jadwal_tes_id, $statement, $statementujian );

        $queryJawaban = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND COALESCE(NULLIF(D.JAWABAN, ''), NULL) IS NOT NULL AND A.UJIAN_ID = ".$this->user->ujian_id;
        $queryJawaban=$queryJawaban->selectByParamsJawabanSoalMMPI($statement);

        $queryJawabanPeserta = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND a.UJIAN_TAHAP_ID = ".$reqId." and bank_soal_pilihan_id is not null" ;
        $queryJawabanPeserta=$queryJawabanPeserta->selectByParamsJawabanPesertaCFID($statement, $this->user->jadwal_tes_id);

      }
      else if($reqTipeUjianId==95||$reqTipeUjianId==94 || $reqTipeUjianId==40|| $reqTipeUjianId==19|| $reqTipeUjianId==20 || $reqTipeUjianId==21|| $reqTipeUjianId==22|| $reqTipeUjianId==23 || $reqTipeUjianId==24|| $reqTipeUjianId==25|| $reqTipeUjianId==26|| $reqTipeUjianId==27 ){
        $querySoal = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND A.UJIAN_ID = ".$this->user->ujian_id;
        $statementujian= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id." AND A.UJIAN_TAHAP_ID = ".$reqId;
        $querySoal=$querySoal->selectByParamsBankSoal($this->user->jadwal_tes_id, $statement, $statementujian );

        $queryJawaban = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND COALESCE(NULLIF(D.JAWABAN, ''), NULL) IS NOT NULL AND A.UJIAN_ID = ".$this->user->ujian_id;
        $queryJawaban=$queryJawaban->selectByParamsJawabanBankSoal($statement);

        $queryJawabanPeserta = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND a.UJIAN_TAHAP_ID = ".$reqId." and bank_soal_pilihan_id is not null" ;
        $queryJawabanPeserta=$queryJawabanPeserta->selectByParamsJawabanPesertaCFID($statement, $this->user->jadwal_tes_id);
      }
      // pdf
      else if($reqKeteranganUjian='SJT'){
        // echo $this->user->jadwal_tes_id.'-'.$this->user->pegawai_id;
        // exit;
        DB::statement("
            INSERT INTO cat.bank_soal_pilihan_acak (
                bank_soal_pilihan_id,
                pegawai_id,
                tipe_ujian_id,
                ujian_id
            )
            SELECT * FROM (
                SELECT
                    b.bank_soal_pilihan_id,
                    a.pegawai_id,
                    a.tipe_ujian_id,
                    a.ujian_id
                FROM
                    cat_pegawai.ujian_pegawai_{$this->user->jadwal_tes_id} a
                LEFT JOIN
                    cat.bank_soal_pilihan b ON a.bank_soal_id = b.bank_soal_id
                WHERE
                    a.pegawai_id = '{$this->user->pegawai_id}'
                    AND NOT EXISTS (
                        SELECT 1
                        FROM cat.bank_soal_pilihan_acak x
                        WHERE
                            x.bank_soal_pilihan_id = b.bank_soal_pilihan_id AND
                            x.pegawai_id = a.pegawai_id AND
                            x.tipe_ujian_id = a.tipe_ujian_id AND
                            x.ujian_id = a.ujian_id
                    )
                ORDER BY random()
            ) AS sub;

        ");


        $querySoal = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND A.UJIAN_ID = ".$this->user->ujian_id;
        $statementujian= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id." AND A.UJIAN_TAHAP_ID = ".$reqId;
        // $order='ORDER BY RANDOM()';
        $querySoal=$querySoal->selectByParamsBankSoal($this->user->jadwal_tes_id, $statement, $statementujian );
        // print_r($querySoal);exit;
        $queryJawaban = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND COALESCE(NULLIF(D.JAWABAN, ''), NULL) IS NOT NULL AND A.UJIAN_ID = ".$this->user->ujian_id;
        $order='ORDER BY bank_soal_pilihan_acak_id asc';
        $queryJawaban=$queryJawaban->selectByParamsJawabanBankSoal($statement,$order);
// print_r($queryJawaban);exit;
        $queryJawabanPeserta = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND a.UJIAN_TAHAP_ID = ".$reqId." and bank_soal_pilihan_id is not null" ;
        $queryJawabanPeserta=$queryJawabanPeserta->selectByParamsJawabanPesertaCFID($statement, $this->user->jadwal_tes_id);
      }
      $statement= " AND UJIAN_TAHAP_ID = ".$reqId." AND UJIAN_ID = ".$this->user->ujian_id." AND PEGAWAI_ID = ".$this->user->pegawai_id." AND TIPE_UJIAN_ID = ".$queryIdentitas->tipe_ujian_id;
      $tahappegawai= new UjianTahapPegawai();
      $tahappegawai=$tahappegawai->selectByParams($statement)->first();

      $ujianbaru='';
      if(empty($tahappegawai)){
        // print_r($reqTipeUjianId);exit;
        if($reqTipeUjianId==27){
          return view('ujian/ujian_hafalan', compact('queryIdentitas','querySoal','queryJawaban','reqId','tipe_ujian','queryJawabanPeserta','ujianbaru','urutan'));
        }
        else{
          $set= new UjianTahapStatusUjian();
        $statement= " AND UJIAN_TAHAP_ID = ".$reqId." AND UJIAN_ID = ".$this->user->ujian_id." AND PEGAWAI_ID = ".$this->user->pegawai_id." AND a.TIPE_UJIAN_ID = ".$queryIdentitas->tipe_ujian_id;
          $set=$set->selectByParamsCheck($statement,$this->user->jadwal_tes_id)->first();
          // print_r($this->user);exit;
          $reqTipeUjianId=$set->tipe_ujian_id;
          $reqUjianPegawaiDaftarId=$set->ujian_pegawai_daftar_id;

          $set = new UjianTahapPegawai();
          // nama kolom yang di insert
          $set->ujian_pegawai_daftar_id =$reqUjianPegawaiDaftarId;
          $set->jadwal_tes_id = $this->user->jadwal_tes_id;
          $set->formula_assesment_id = $this->user->formula_assesment_id;
          $set->formula_eselon_id =$this->user->formula_eselon_id;
          $set->ujian_id =$this->user->ujian_id;
          $set->ujian_tahap_id =$reqId;
          $set->tipe_ujian_id =$reqTipeUjianId;
          $set->pegawai_id =$this->user->pegawai_id;
          $set->waktu_ujian = Carbon::now();
          $set->waktu_ujian_log = Carbon::now();
          $set->save();
          $ujianbaru='1';
        }
      }

      $statement= " AND COALESCE(B.MENIT_SOAL,0) > 0 AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId;
      $setWaktu= new UjianTahapPegawai();
      $setWaktu=$setWaktu->selectByParamsUjianPegawaiTahap($statement)->first();

      $set = new TipeUjian();
      $statement= " AND COALESCE(B.MENIT_SOAL,0) > 0 AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id." AND b.TIPE_UJIAN_ID = ".$queryIdentitas->tipe_ujian_id;
      $tipe_ujian=$set->selectByParamsUjianPilihan($statement)->first(); 

      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      if($tipe_ujian->tipe_ujian_id==9 || $tipe_ujian->tipe_ujian_id==13){
        return view('ujian/ujian_online_dua_jawaban', compact('queryIdentitas','querySoal','queryJawaban','reqId','setWaktu','tipe_ujian','queryJawabanPeserta','ujianbaru','urutan'));
      }
      if($reqTipeUjianId==23||$reqTipeUjianId==24){
        return view('ujian/ujian_online_dua_jawaban_text', compact('queryIdentitas','querySoal','queryJawaban','reqId','setWaktu','tipe_ujian','queryJawabanPeserta','ujianbaru','urutan'));
      }
      else if($tipe_ujian->tipe_ujian_id==7||$reqTipeUjianId==40|| $reqTipeUjianId==19|| $reqTipeUjianId==20|| $reqTipeUjianId==21|| $reqTipeUjianId==27|| $reqKeteranganUjian=='SJT'){
        return view('ujian/ujian_online_text', compact('queryIdentitas','querySoal','queryJawaban','reqId','setWaktu','tipe_ujian','queryJawabanPeserta','ujianbaru','urutan'));
      }
      else if($tipe_ujian->tipe_ujian_id==75||$tipe_ujian->tipe_ujian_id==77||$tipe_ujian->tipe_ujian_id==78){
        return view('ujian/ujian_online_pdf', compact('queryIdentitas','querySoal','queryJawaban','reqId','setWaktu','tipe_ujian','queryJawabanPeserta','ujianbaru','urutan'));
      }
      else if($tipe_ujian->tipe_ujian_id==42){
        return view('ujian/ujian_online_disc', compact('queryIdentitas','querySoal','queryJawaban','reqId','setWaktu','tipe_ujian','queryJawabanPeserta','ujianbaru','urutan'));
      }
      else if($tipe_ujian->tipe_ujian_id==22){
        return view('ujian/ujian_online_essay', compact('queryIdentitas','querySoal','queryJawaban','reqId','setWaktu','tipe_ujian','queryJawabanPeserta','ujianbaru','urutan'));
      }
      else{
        return view('ujian/ujian_online', compact('queryIdentitas','querySoal','queryJawaban','reqId','setWaktu','tipe_ujian','queryJawabanPeserta','ujianbaru','urutan'));

      }
    }

    public function ujian_online_essay(request $request)
    {
      $reqId=$request->route('id');
      $statement=" and jadwal_tes_id=".$this->user->jadwal_tes_id;
      $query = new JadwalTes();
      $query=$query->selectByParamsMonitoring($statement)->first();

      $reqTanggalTes = explode(' ',$query->tanggal_tes);
      $reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
      $tempTahun = DateFunc::getYear($reqTanggalTes);

      $query = new PermohonanFile();
      $tipe_ujian=$query->selectByParamsPenggalian($tempTahun,$this->user->jadwal_tes_id,'and b.permohonan_file_id='.$reqId,$this->user->pegawai_id)->first();
      return view('ujian/ujian_online_essay_baru', compact('reqId','tipe_ujian'));

    }

    public function ujian_online_essay_new(request $request)
    {
      $reqId=$request->route('id');
      $reqPegawaiId= $this->user->pegawai_id;
      
      $statement=" and kode not in ('ITR','PE')";
      $soalessay = new PermohonanFile();
      $soalessay=$soalessay->selectByParamsPenggalianUjian(2025,$this->user->jadwal_tes_id, $this->user->pegawai_id,$statement);
$essaySoalIds = array_map(function($item) {
    return $item->essay_soal_id;
}, $soalessay->toArray());

      $statement=" and pegawai_id=".$this->user->pegawai_id." and submit is null and ujian_id=".$this->user->jadwal_tes_id;
      $jawabanessaycek = new PermohonanFile();
      $jawabanessaycek=$jawabanessaycek->selectByParamsPenggalianJawaban($statement)->first();
      if(empty($jawabanessaycek)){
          $jawabanessaycekId=$reqId;
      }
      else{
          $jawabanessaycekId=$jawabanessaycek->essay_soal_id;
      }
        // print_r($jawabanessaycek);exit;

        if (!in_array($reqId, $essaySoalIds)) {

            $set = new TipeUjian();
            $statement= " AND COALESCE(B.MENIT_SOAL,0) > 0 AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id;
            $tipe_ujian=$set->selectByParamsUjianPilihan($statement); 
      
            $identitas=$this->user;
      
            $statement=" and jadwal_tes_id=".$this->user->jadwal_tes_id;
            $query = new JadwalTes();
            $query=$query->selectByParamsMonitoring($statement)->first();
          //   print_r($query);exit;
      
            $reqTanggalTes = explode(' ',$query->tanggal_tes);
            $reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
            $tempTahun = DateFunc::getYear($reqTanggalTes);
      
            $soalessay = new PermohonanFile();
            $soalessay=$soalessay->selectByParamsPenggalianUjian($tempTahun,$this->user->jadwal_tes_id, $this->user->pegawai_id);
          //   print_r($soalessay);exit;
      
            return view("ujian/pilih_ujian",compact('tipe_ujian','identitas','soalessay','query'));
        }
        else if( $jawabanessaycekId != $reqId){
             $set = new TipeUjian();
            $statement= " AND COALESCE(B.MENIT_SOAL,0) > 0 AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id;
            $tipe_ujian=$set->selectByParamsUjianPilihan($statement); 
      
            $identitas=$this->user;
      
            $statement=" and jadwal_tes_id=".$this->user->jadwal_tes_id;
            $query = new JadwalTes();
            $query=$query->selectByParamsMonitoring($statement)->first();
          //   print_r($query);exit;
      
            $reqTanggalTes = explode(' ',$query->tanggal_tes);
            $reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
            $tempTahun = DateFunc::getYear($reqTanggalTes);
      
            $soalessay = new PermohonanFile();
            $soalessay=$soalessay->selectByParamsPenggalianUjian($tempTahun,$this->user->jadwal_tes_id, $this->user->pegawai_id);
          //   print_r($soalessay);exit;
      
            return view("ujian/pilih_ujian",compact('tipe_ujian','identitas','soalessay','query'));
        }
        
      $statement=" and jadwal_tes_id=".$this->user->jadwal_tes_id;
      $query = new JadwalTes();
      $query=$query->selectByParamsMonitoring($statement)->first();

      $reqTanggalTes = explode(' ',$query->tanggal_tes);
      $reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
      $tempTahun = DateFunc::getYear($reqTanggalTes);

      $statement=" and essay_soal_id=".$reqId;
      $soalessay = new PermohonanFile();
      $soalessay=$soalessay->selectByParamsPenggalianNew($tempTahun,$this->user->jadwal_tes_id,$statement)->first();

      $statement=" and a.essay_soal_id=".$reqId." and pegawai_id=".$this->user->pegawai_id;
      $jawabanessay = new PermohonanFile();
      $jawabanessay=$jawabanessay->selectByParamsPenggalianJawaban($statement)->first();

      if(empty($jawabanessay->essay_jawaban_id)){  
        // $maxId = EssayJawaban::NextId();
        $query = new EssayJawaban();
        // nama kolom yang di insert
        // $query->essay_jawaban_id = $maxId;  
        $query->pegawai_id = $reqPegawaiId;
        $query->essay_soal_id = $reqId;
        $query->save();

        $statement=" and a.essay_soal_id=".$reqId." and pegawai_id=".$this->user->pegawai_id;
        $jawabanessay = new PermohonanFile();
        $jawabanessay=$jawabanessay->selectByParamsPenggalianJawaban($statement)->first();
      }
      else{
        if($jawabanessay->submit==1){
          $set = new TipeUjian();
          $statement= " AND COALESCE(B.MENIT_SOAL,0) > 0 AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id;
          $tipe_ujian=$set->selectByParamsUjianPilihan($statement); 
    
          $identitas=$this->user;
    
          $statement=" and jadwal_tes_id=".$this->user->jadwal_tes_id;
          $query = new JadwalTes();
          $query=$query->selectByParamsMonitoring($statement)->first();
        //   print_r($query);exit;
    
          $reqTanggalTes = explode(' ',$query->tanggal_tes);
          $reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
          $tempTahun = DateFunc::getYear($reqTanggalTes);
    
          $soalessay = new PermohonanFile();
          $soalessay=$soalessay->selectByParamsPenggalianUjian($tempTahun,$this->user->jadwal_tes_id, $this->user->pegawai_id);
        //   print_r($soalessay);exit;
    
          return view("ujian/pilih_ujian",compact('tipe_ujian','identitas','soalessay','query'));
        }
      }

      return view('ujian/ujian_online_essay_new', compact('reqId','soalessay','jawabanessay'));

    }

    public function ujian_online_essay_new_pe(request $request)
    {
      $reqId=$request->route('id');
      $reqUjianId= $this->user->jadwal_tes_id;
      $reqPegawaiId= $this->user->pegawai_id;
      // print_r($this->user);exit;
      // $statement=" and jadwal_tes_id=".$this->user->jadwal_tes_id;
      // $query = new JadwalTes();
      // $query=$query->selectByParamsMonitoring($statement)->first();

      // $reqTanggalTes = explode(' ',$query->tanggal_tes);
      // $reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
      // $tempTahun = DateFunc::getYear($reqTanggalTes);

      // $statement=" and essay_soal_id=".$reqId;
      $soalessay = new SoalPe();
      $soalessay=$soalessay->selectByParamsMonitoring();

      $statement=" and ujian_id=".$reqUjianId." and pegawai_id=".$reqPegawaiId;
      $jawabanessay = new JawabanPe();
      $jawabanessay=$jawabanessay->selectByParamsMonitoring($statement);
      // if(empty($jawabanessay->essay_jawaban_id)){  
      //   $maxId = EssayJawaban::NextId();
      //   $query = new EssayJawaban();
      //   // nama kolom yang di insert
      //   $query->essay_jawaban_id = $maxId;  
      //   $query->pegawai_id = $reqPegawaiId;
      //   $query->essay_soal_id = $reqId;
      //   $query->save();

      //   $statement=" and essay_soal_id=".$reqId." and pegawai_id=".$this->user->pegawai_id;
      //   $jawabanessay = new PermohonanFile();
      //   $jawabanessay=$jawabanessay->selectByParamsPenggalianJawaban($statement)->first();
      // }
        
      $statement=" and pegawai_id=".$this->user->pegawai_id." and submit is null and ujian_id=".$this->user->jadwal_tes_id;
      $jawabanessaycek = new PermohonanFile();
      $jawabanessaycek=$jawabanessaycek->selectByParamsPenggalianJawaban($statement)->first();
    //   print_r($jawabanessaycek);exit;
      if(!empty($jawabanessaycek)){
          // echo $jawabanessaycek->essay_soal_id.'-'.$reqId; exit;
          
          $ceksoalessay = new PermohonanFile();
          $statement=" and kode='PE'";
          $ceksoalessay=$ceksoalessay->selectByParamsPenggalianUjian(2025,$this->user->jadwal_tes_id, $this->user->pegawai_id,$statement)->first();
        //   print_r($ceksoalessay);exit;
          
          if($jawabanessaycek->essay_soal_id!=$reqId || $jawabanessaycek->essay_soal_id!=$ceksoalessay->essay_soal_id){
            $set = new TipeUjian();
            $statement= " AND COALESCE(B.MENIT_SOAL,0) > 0 AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id;
            $tipe_ujian=$set->selectByParamsUjianPilihan($statement); 
      
            $identitas=$this->user;
      
            $statement=" and jadwal_tes_id=".$this->user->jadwal_tes_id;
            $query = new JadwalTes();
            $query=$query->selectByParamsMonitoring($statement)->first();
          //   print_r($query);exit;
      
            $reqTanggalTes = explode(' ',$query->tanggal_tes);
            $reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
            $tempTahun = DateFunc::getYear($reqTanggalTes);
      
            $soalessay = new PermohonanFile();
            $soalessay=$soalessay->selectByParamsPenggalianUjian($tempTahun,$this->user->jadwal_tes_id, $this->user->pegawai_id);
          //   print_r($soalessay);exit;
      
            return view("ujian/pilih_ujian",compact('tipe_ujian','identitas','soalessay','query'));
          }
      }

      $statement=" and kode= 'PE' ";
      $cekPenggalian = new Penggalian();
      $cekPenggalian=$cekPenggalian->selectByParams($statement)->first();

      $statement=" and penggalian_id= ".$cekPenggalian->penggalian_id." and ujian_id=".$reqUjianId;
      $ceksoal = new EssaySoal();
      $ceksoal=$ceksoal->selectByParamsMonitoring($statement)->first();
        // print_r($ceksoal);exit;
      if(empty($ceksoal)){  
        // $maxId = EssaySoal::NextId();
        $query = new EssaySoal();
        // nama kolom yang di insert
        // $query->essay_soal_id = $maxId;  
        $query->ujian_id = $reqUjianId;
        $query->penggalian_id = $cekPenggalian->penggalian_id;
        $query->save();
        
        $statement=" and ujian_id =".$reqUjianId." and penggalian_id=".$cekPenggalian->penggalian_id;
        $cekSoalId = new EssaySoal();
        
        $cekSoalId=$cekSoalId->selectByParamsMonitoring($statement)->first();
        $maxIdsoal=$cekSoalId->essay_soal_id;
      }else{
        $maxIdsoal=$ceksoal->essay_soal_id;
      }

      $statement=" and a.essay_soal_id=".$maxIdsoal." and pegawai_id=".$this->user->pegawai_id;
      $cekjawaban = new PermohonanFile();
      $cekjawaban=$cekjawaban->selectByParamsPenggalianJawaban($statement)->first();
      // print_r($cekjawaban);exit;
      if(empty($cekjawaban)){  
        // $maxId = EssayJawaban::NextId();
        $query = new EssayJawaban();
        // nama kolom yang di insert
        // $query->essay_jawaban_id = $maxId;  
        $query->pegawai_id = $reqPegawaiId;
        $query->essay_soal_id = $maxIdsoal;
        $query->save();
        
        $statement=" and pegawai_id =".$reqPegawaiId." and a.essay_soal_id=".$maxIdsoal;
        $cekJawabanId = new EssayJawaban();
        $cekJawabanId=$cekJawabanId->selectByParamsMonitoring($statement)->first();
        $maxJawabanId=$cekJawabanId->essay_jawaban_id;
      }
      else{
        $maxJawabanId=$cekjawaban->essay_jawaban_id;
      }

      return view('ujian/ujian_online_essay_new_pe', compact('reqId','soalessay','jawabanessay','maxJawabanId','cekjawaban'));

    }

    public function ujian_online_essay_new_itr(request $request)
    {
      
      $reqId=$request->route('id');
      $reqPegawaiId= $this->user->pegawai_id;

      $statement=" and jadwal_tes_id=".$this->user->jadwal_tes_id;
      $query = new JadwalTes();
      $query=$query->selectByParamsMonitoring($statement)->first();

      $reqTanggalTes = explode(' ',$query->tanggal_tes);
      $reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
      $tempTahun = DateFunc::getYear($reqTanggalTes);
    
      $statement=" and essay_soal_id=".$reqId;
      $soalessay = new SoalIntray();
      $soalessay=$soalessay->selectByParamsSoal($statement);

      $statement=" and essay_soal_id=".$reqId." and pegawai_id=".$this->user->pegawai_id;
      $jawabanessay = new JawabanItr();
      $jawabanessay=$jawabanessay->selectByParamsPenggalianJawaban($statement);
      // print_r($jawabanessay);exit;
    
      $statement=" and pegawai_id=".$this->user->pegawai_id." and submit is null and ujian_id=".$this->user->jadwal_tes_id;
      $jawabanessaycek = new PermohonanFile();
      $jawabanessaycek=$jawabanessaycek->selectByParamsPenggalianJawaban($statement)->first();
            // print_r($jawabanessaycek);

      if(!empty($jawabanessaycek)){
          // echo $jawabanessaycek->essay_soal_id.'-'.$reqId; exit;
          
          $ceksoalessay = new PermohonanFile();
          $statement=" and kode='ITR'";
          $ceksoalessay=$ceksoalessay->selectByParamsPenggalianUjian(2025,$this->user->jadwal_tes_id, $this->user->pegawai_id,$statement)->first();
        //   print_r($ceksoalessay);exit;
          
        if($jawabanessaycek->essay_soal_id!=$reqId || $jawabanessaycek->essay_soal_id!=$ceksoalessay->essay_soal_id){
          $set = new TipeUjian();
          $statement= " AND COALESCE(B.MENIT_SOAL,0) > 0 AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id;
          $tipe_ujian=$set->selectByParamsUjianPilihan($statement); 
    
          $identitas=$this->user;
    
          $statement=" and jadwal_tes_id=".$this->user->jadwal_tes_id;
          $query = new JadwalTes();
          $query=$query->selectByParamsMonitoring($statement)->first();
        //   print_r($query);exit;
    
          $reqTanggalTes = explode(' ',$query->tanggal_tes);
          $reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
          $tempTahun = DateFunc::getYear($reqTanggalTes);
    
          $soalessay = new PermohonanFile();
          $soalessay=$soalessay->selectByParamsPenggalianUjian($tempTahun,$this->user->jadwal_tes_id, $this->user->pegawai_id);
        //   print_r($soalessay);exit;
    
          return view("ujian/pilih_ujian",compact('tipe_ujian','identitas','soalessay','query'));
        }
      }



      $statement=" and a.essay_soal_id=".$reqId." and pegawai_id=".$this->user->pegawai_id;
      $cekjawaban = new PermohonanFile();
      $cekjawaban=$cekjawaban->selectByParamsPenggalianJawaban($statement)->first();
      // print_r($cekjawaban);exit;
      if(empty($cekjawaban)){  
        // $maxId = EssayJawaban::NextId();
        $query = new EssayJawaban();
        // nama kolom yang di insert
        // $query->essay_jawaban_id = $maxId;  
        $query->pegawai_id = $reqPegawaiId;
        $query->essay_soal_id = $reqId;
        $query->save();
        
        $statement=" and pegawai_id =".$reqPegawaiId." and a.essay_soal_id=".$reqId;
        $cekJawabanId = new EssayJawaban();
        $cekJawabanId=$cekJawabanId->selectByParamsMonitoring($statement)->first();
        $maxJawabanId=$cekJawabanId->essay_jawaban_id;
      }
      else{
        $maxJawabanId=$cekjawaban->essay_jawaban_id;
      }

      return view('ujian/ujian_online_essay_new_itr', compact('reqId','soalessay','jawabanessay','maxJawabanId','cekjawaban'));
      // return view('ujian/ujian_online_essay_new_pe', compact('reqId','soalessay','jawabanessay','maxJawabanId','cekjawaban'));

    }

    public function uploaddrh(request $request)
    {
      $reqId=$request->route('id');
      $reqPegawaiId= $this->user->pegawai_id;

      $query = new JadwalAwalTes();
      $statement=" and jadwal_awal_tes_id = ".$reqId;
      $query=$query->selectByParamsMonitoring($statement)->first();

      // print_r($query);exit;
      return view('ujian/upload_drh', compact('reqId','reqPegawaiId','query'));

    }

    public function selesai(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $statement= " AND A.UJIAN_ID = ".$this->user->ujian_id." AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_TAHAP_ID = ".$reqId;
      $set= new UjianTahapStatusUjian();
      $set=$set->selectByParamsCheck($statement,$this->user->jadwal_tes_id)->first();
      // print_r($set->ujian_pegawai_daftar_id);exit;
      $reqTipeUjianId=$set->tipe_ujian_id;

      if($reqTipeUjianId=='66'){
        $querySoal = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND A.UJIAN_ID = ".$this->user->ujian_id;
        $statementujian= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id." AND A.UJIAN_TAHAP_ID = ".$reqId;
        $querySoal=$querySoal->selectByParamsSoalMMPI($this->user->jadwal_tes_id, $statement, $statementujian );
      }
      else{        
        $querySoal = new Ujian();
        $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ".$reqId." AND A.UJIAN_ID = ".$this->user->ujian_id;
        $statementujian= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_ID = ".$this->user->ujian_id." AND A.UJIAN_TAHAP_ID = ".$reqId;
        
        $order=' order by bank_soal_id asc';
        $querySoal=$querySoal->selectByParamsSoalCFID($statement, $statementujian, $this->user->jadwal_tes_id, $order );
      }
      // $satker=$satuan_kerja->combo_cabang($request,$reqUnitKerjaId);
      $queryJawabanPeserta = new Ujian();
      $statement= " AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND a.UJIAN_TAHAP_ID = ".$reqId." and bank_soal_pilihan_id is not null" ;
      $queryJawabanPeserta=$queryJawabanPeserta->selectByParamsJawabanPesertaCFID($statement, $this->user->jadwal_tes_id);
      // $query = new Pegawai();
      // $query=$query->selectByParamsMonitoring($reqId)->first();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('ujian/selesai', compact('querySoal','queryJawabanPeserta'));
    }

    public function petunjuk_cek(request $request)
    {
      $tempUjianId=$request->route('tempUjianId');
      $tahapid = $request->route('tahapid');

      $statement= " AND UJIAN_ID = ".$tempUjianId." AND PEGAWAI_ID = ".$this->user->pegawai_id." AND UJIAN_TAHAP_ID = ".$tahapid;
      $set= new Ujian();
      $set=$set->getCountByParamsPetunjukCek($statement)->first();
      // print_r($set);exit;
      return $set->rowcount;
    }

    public function ujian_tahap_mulai(request $request)
    {
      $tipeujianid=$request->route('tipeujianid');
      // print_r($this->user->jadwal_tes_id);
      $statement= "AND JADWAL_TES_ID = ".$this->user->jadwal_tes_id." AND TIPE_UJIAN_ID = ".$tipeujianid;
      $set= new Ujian();
      $set=$set->selectByParamsUjianTahapMulai($statement)->first();
      // print_r($set);exit;
      return $set->last_create_user;
    }

    public function jawab(request $request)
    {
      $reqId=$request->route('reqId');
      $reqUjianId=$request->route('reqUjianId');
      $reqTipeUjianId=$request->route('reqTipeUjianId');
      $reqBankSoalId=$request->route('reqBankSoalId');
      $reqBankSoalPilihanId=$request->route('reqBankSoalPilihanId');
      $reqPegawaiId=$request->route('reqPegawaiId');
      $reqKeterangan = $request->textarea_data;

      $updated = DB::table('cat_pegawai.ujian_pegawai_'.$this->user->jadwal_tes_id)
                  ->where('ujian_id', $reqUjianId)
                  ->where('tipe_ujian_id', $reqTipeUjianId)
                  ->where('bank_soal_id', $reqBankSoalId)
                  ->where('pegawai_id', $reqPegawaiId)
                  ->update([
                    'bank_soal_pilihan_id' => $reqBankSoalPilihanId
                  ]);
      if($reqKeterangan!=''){

        $updatedKeterangan = DB::table('cat_pegawai.ujian_pegawai_keterangan_'.$this->user->jadwal_tes_id)
          ->where('ujian_id', $reqUjianId)
          ->where('tipe_ujian_id', $reqTipeUjianId)
          ->where('bank_soal_id', $reqBankSoalId)
          ->where('pegawai_id', $reqPegawaiId)
          ->update([
            'keterangan' => $reqKeterangan
          ]);

        if ($updatedKeterangan) {
        } else {
           
            $datacek = DB::table('cat_pegawai.ujian_pegawai_'.$this->user->jadwal_tes_id)
          ->where('ujian_id', $reqUjianId)
          ->where('tipe_ujian_id', $reqTipeUjianId)
          ->where('bank_soal_id', $reqBankSoalId)
          ->where('pegawai_id', $reqPegawaiId)
          ->select('*') // Pilih kolom yang ingin diambil
          ->first();

          $inserted = DB::table('cat_pegawai.ujian_pegawai_keterangan_' . $this->user->jadwal_tes_id)->insert([
              'ujian_id' => $reqUjianId,
              'tipe_ujian_id' => $reqTipeUjianId,
              'bank_soal_id' => $reqBankSoalId,
              'pegawai_id' => $reqPegawaiId,
              'ujian_pegawai_daftar_id' => $reqUjianId,
              'jadwal_tes_id' => $datacek->jadwal_tes_id,
              'formula_assesment_id' => $datacek->formula_assesment_id,
              'ujian_pegawai_id' => $datacek->ujian_pegawai_id,
              'formula_eselon_id' => $datacek->formula_eselon_id,
              'ujian_bank_soal_id' => $datacek->ujian_bank_soal_id,
              'ujian_tahap_id' => $datacek->ujian_tahap_id,
              'keterangan' => $reqKeterangan,
          ]);
        } 

       
      }



      if ($updated) {
          return response()->json(['message' => 'User updated successfully']);
      } else {
          return response()->json(['message' => 'User not found or no changes made'], 404);
      }      
    }

    public function jawabdua(request $request)
    {
      $reqId=$request->route('reqId');
      $reqUjianId=$request->route('reqUjianId');
      $reqTipeUjianId=$request->route('reqTipeUjianId');
      $reqBankSoalId=$request->route('reqBankSoalId');
      $reqBankSoalPilihanId=$request->route('reqBankSoalPilihanId');
      $reqPegawaiId=$request->route('reqPegawaiId');

      $data = DB::table('cat_pegawai.ujian_pegawai_'.$this->user->jadwal_tes_id)
      ->where('ujian_id', $reqUjianId)
      ->where('tipe_ujian_id', $reqTipeUjianId)
      ->where('bank_soal_id', $reqBankSoalId)
      ->where('pegawai_id', $reqPegawaiId)
      ->where('bank_soal_pilihan_id', $reqBankSoalPilihanId)
      ->select('*') // Pilih kolom yang ingin diambil
      ->first();

      if(empty($data->ujian_pegawai_daftar_id)){
        $datacek = DB::table('cat_pegawai.ujian_pegawai_'.$this->user->jadwal_tes_id)
        ->where('ujian_id', $reqUjianId)
        ->where('tipe_ujian_id', $reqTipeUjianId)
        ->where('bank_soal_id', $reqBankSoalId)
        ->where('pegawai_id', $reqPegawaiId)
        ->select('*') // Pilih kolom yang ingin diambil
        ->first();

        $max = DB::table('cat_pegawai.ujian_pegawai_'.$this->user->jadwal_tes_id)
        ->max('ujian_pegawai_id');

        $inserted = DB::table('cat_pegawai.ujian_pegawai_'.$this->user->jadwal_tes_id)
        ->insert([
            'ujian_pegawai_daftar_id' => $datacek->ujian_pegawai_daftar_id,
            'jadwal_tes_id' => $datacek->jadwal_tes_id,
            'formula_assesment_id' => $datacek->formula_assesment_id,
            'formula_eselon_id' => $datacek->formula_eselon_id,
            // 'ujian_pegawai_id' => $max+1,
            'ujian_id' => $datacek->ujian_id,
            'ujian_bank_soal_id' => $datacek->ujian_bank_soal_id,
            'bank_soal_id' => $datacek->bank_soal_id,
            'ujian_tahap_id' => $datacek->ujian_tahap_id,
            'tipe_ujian_id' => $datacek->tipe_ujian_id,
            'pegawai_id' => $datacek->pegawai_id,
            'bank_soal_pilihan_id' => $reqBankSoalPilihanId,
            'tanggal' => $datacek->tanggal,
            'urut' => $datacek->urut,          
            'last_create_user' => $this->user->user_app_id,
            'last_create_date' => Carbon::now()
            // tambahkan kolom lain yang diperlukan jika ada
        ]);
      }
      else{
        $deleted = DB::table('cat_pegawai.ujian_pegawai_'.$this->user->jadwal_tes_id)
        ->where('ujian_id', $reqUjianId)
        ->where('tipe_ujian_id', $reqTipeUjianId)
        ->where('bank_soal_id', $reqBankSoalId)
        ->where('pegawai_id', $reqPegawaiId)
        ->where('bank_soal_pilihan_id', $reqBankSoalPilihanId)
        ->delete();


      }

      
          return response()->json(['message' => 'User updated successfully']);
            
    }

    public function ujian_online_finish(request $request)
    {
      $reqId= $request->id;
      $statement= " AND A.UJIAN_ID = ".$this->user->ujian_id." AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_TAHAP_ID = ".$reqId;
      $set= new UjianTahapStatusUjian();
      $set=$set->selectByParamsCheck($statement,$this->user->jadwal_tes_id)->first();
      // print_r($set->ujian_pegawai_daftar_id);exit;
      $reqTipeUjianId=$set->tipe_ujian_id;
      $reqUjianPegawaiDaftarId=$set->ujian_pegawai_daftar_id;

      // nama kolom yang di insert

      $maxId = UjianTahapStatusUjian::NextId();
      Log::emergency("Max ID run by K6: " . $maxId . "By " . $this->user->pegawai_id);
      $set = new UjianTahapStatusUjian();
    //   $set->ujian_tahap_status_ujian_id = $maxId;
      $set->ujian_pegawai_daftar_id = $reqUjianPegawaiDaftarId;
      $set->last_create_user = $this->user->user_app_id;
      $set->last_create_date = Carbon::now();

      $set->jadwal_tes_id =$this->user->jadwal_tes_id;
      $set->formula_assesment_id =$this->user->formula_assesment_id;
      $set->formula_eselon_id =$this->user->formula_eselon_id;
      $set->tipe_ujian_id =$reqTipeUjianId;
      $set->ujian_id =$this->user->ujian_id;
      $set->ujian_tahap_id =$reqId;
      $set->pegawai_id =$this->user->pegawai_id;
      $set->status =1;
      $set->save(); 
      return "Data berhasil disimpan";
    }

    public function ujian_online_selesai_hafal(request $request)
    {
      $reqId= $request->id;

      $set= new UjianTahapStatusUjian();
      $statement= " AND A.UJIAN_ID = ".$this->user->ujian_id." AND A.PEGAWAI_ID = ".$this->user->pegawai_id." AND A.UJIAN_TAHAP_ID = ".$reqId;
      $set=$set->selectByParamsCheck($statement,$this->user->jadwal_tes_id)->first();
      // print_r($this->user);exit;
      $reqTipeUjianId=$set->tipe_ujian_id;
      $reqUjianPegawaiDaftarId=$set->ujian_pegawai_daftar_id;

      $set = new UjianTahapPegawai();
      // nama kolom yang di insert
      $set->ujian_pegawai_daftar_id =$reqUjianPegawaiDaftarId;
      $set->jadwal_tes_id = $this->user->jadwal_tes_id;
      $set->formula_assesment_id = $this->user->formula_assesment_id;
      $set->formula_eselon_id =$this->user->formula_eselon_id;
      $set->ujian_id =$this->user->ujian_id;
      $set->ujian_tahap_id =$reqId;
      $set->tipe_ujian_id =$reqTipeUjianId;
      $set->pegawai_id =$this->user->pegawai_id;
      $set->waktu_ujian = Carbon::now();
      $set->waktu_ujian_log = Carbon::now();
      $set->save();
      return "Data berhasil disimpan";
    }

    public function addUpload(request $request)
    {
      $reqId= $this->user->jadwal_tes_id;
      $reqFileJenisKode= $request->reqFileJenisKode;
      $reqkuncijenis= $reqId;
      $reqfolderjenis= "jadwaltes".$reqkuncijenis;
      $reqJenis= $reqfolderjenis."-jawab";
      $filedata= $_FILES["reqLinkFile"];
      // print_r($filedata);exit;
      $folderfilesimpan= "uploads/essay/".$reqfolderjenis;
      if(file_exists($folderfilesimpan)){}
      else
      {
        mkdir($folderfilesimpan);
      }

      $namafile= $filedata["name"];
      $fileType= $filedata["type"];
      $datafileupload= $filedata["tmp_name"];
      $filepath= explode('.',$namafile);
      $longfilepath=count($filepath);
      $filepath=$filepath[$longfilepath-1];

      if($namafile == ""){}
      else
      {
        $namajenisfile= $reqFileJenisKode;
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

          $query->pegawai_id = $namajenisfile."-".$this->user->pegawai_id;
          $query->permohonan_table_nama = $reqJenis;
          $query->permohonan_table_id = $reqkuncijenis;
          $query->nama = $linkfile."-".$this->user->pegawai_id;
          $query->keterangan = $namafile;
          $query->link_file = $targetsimpan;
          $query->tipe = strtolower($fileType);
          $query->user_login_id = $this->user->pegawai_id;
          $query->user_login_pegawai_id = $this->user->pegawai_id;
          $query->user_login_create_id = $this->user->pegawai_id;
          $query->save();
        }
      }
      return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");
      
    }

    public function essayJawaban(request $request)
    {
      $reqId= $request->reqId;
      $reqJawaban= $request->reqJawaban;
      $reqJawaban_id= $request->reqJawaban_id;
      $reqSubmit= $request->reqSubmit;
      $reqPegawaiId= $this->user->pegawai_id;
     
      if(!empty($reqJawaban_id))
      {
        $query = EssayJawaban::findOrFail($reqJawaban_id);
        // unlink($infofilelokasi);
      }
      else{
        $maxId = EssayJawaban::NextId();
        $query = new EssayJawaban();
        // nama kolom yang di insert
        $query->essay_jawaban_id = $maxId;
        
      }
      
      $query->jawaban=$reqJawaban;

      $query->submit = $reqSubmit;
      $query->save();

      return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");
      
    }

    public function jawabPe(request $request)
    {
      $reqSituasi= $request->reqSituasi;
      $reqKendala= $request->reqKendala;
      $reqLangkah= $request->reqLangkah;
      $reqHasil= $request->reqHasil;
      $reqSoalId= $request->reqSoalId;
      $reqUjianId= $this->user->jadwal_tes_id;
      $reqPegawaiId= $this->user->pegawai_id;

      $statement= " AND UJIAN_ID = ".$reqUjianId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.SOAL_PE_ID = ".$reqSoalId;
      $set= new JawabanPe();
      $set=$set->selectByParamsMonitoring($statement)->first();
 
      if(!empty($set))
      {
        $query = JawabanPe::findOrFail($set->jawaban_pe_id);
        // unlink($infofilelokasi);
      }
      else{
        // $maxId = JawabanPe::NextId();
        $query = new JawabanPe();
        // nama kolom yang di insert
        // $query->jawaban_pe_id = $maxId;
        
      }

      $query->situasi = $reqSituasi;
      $query->kendala = $reqKendala;
      $query->langkah = $reqLangkah;
      $query->hasil = $reqHasil;
      $query->soal_pe_id = $reqSoalId;
      $query->ujian_id = $reqUjianId;
      $query->pegawai_id = $reqPegawaiId;
      $query->save();

      return StringFunc::json_response(200, $reqSoalId."-Data berhasil disimpan.");
      
    }

    public function jawabPeSemua(request $request)
    {
      $reqSituasi= $request->reqSituasi;
      $reqKendala= $request->reqKendala;
      $reqLangkah= $request->reqLangkah;
      $reqHasil= $request->reqHasil;
      $reqSoalId= $request->reqSoalId;
      $reqUjianId= $this->user->jadwal_tes_id;
      $reqPegawaiId= $this->user->pegawai_id;

      for($i=0;$i<count($reqSoalId);$i++){

        $statement= " AND UJIAN_ID = ".$reqUjianId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.SOAL_PE_ID = ".$reqSoalId[$i];
        $set= new JawabanPe();
        $set=$set->selectByParamsMonitoring($statement)->first();
   
        if(!empty($set))
        {
          $query = JawabanPe::findOrFail($set->jawaban_pe_id);
          // unlink($infofilelokasi);
        }
        else{
          // $maxId = JawabanPe::NextId();
          $query = new JawabanPe();
          // nama kolom yang di insert
          // $query->jawaban_pe_id = $maxId;
          
        }

        $query->situasi = $reqSituasi[$i];
        $query->kendala = $reqKendala[$i];
        $query->langkah = $reqLangkah[$i];
        $query->hasil = $reqHasil[$i];
        $query->soal_pe_id = $reqSoalId[$i];
        $query->ujian_id = $reqUjianId;
        $query->pegawai_id = $reqPegawaiId;
        $query->save();

      }

      return StringFunc::json_response(200, '000'."-Data berhasil disimpan.");
      
    }

    public function jawabItr(request $request)
    {
      $reqJawaban= $request->reqJawaban;
      $reqJawabanId= $request->reqJawabanId;
      $reqSoalId= $request->reqSoalId;
      $reqId= $request->reqId;
      $reqUjianId= $this->user->jadwal_tes_id;
      $reqPegawaiId= $this->user->pegawai_id;

      for($i=0;$i<count($reqJawaban);$i++){

        $statement= " AND UJIAN_ID = ".$reqUjianId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.kegiatan_file_itr_ID = ".$reqSoalId[$i];
        $set= new JawabanItr();
        $set=$set->selectByParamsMonitoring($statement)->first();
   
        if(!empty($set))
        {
          $query = JawabanItr::findOrFail($set->jawaban_itr_id);
          // unlink($infofilelokasi);
        }
        else{
          // $maxId = JawabanPe::NextId();
          $query = new JawabanItr();
          // nama kolom yang di insert
          // $query->jawaban_pe_id = $maxId;
          
        }

        $query->jawaban = $reqJawaban[$i];
        $query->kegiatan_file_itr_id = $reqSoalId[$i];
        $query->ujian_id = $reqUjianId;
        $query->pegawai_id = $reqPegawaiId;
        $query->save();
        
      }
        return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");

    }

    public function jawabItrSatu(request $request)
    {
      $reqJawaban= $request->reqJawaban;
      $reqJawabanId= $request->reqJawabanId;
      $reqSoalId= $request->reqSoalId;
      $reqId= $request->reqId;
      $reqUjianId= $this->user->jadwal_tes_id;
      $reqPegawaiId= $this->user->pegawai_id;

      $statement= " AND UJIAN_ID = ".$reqUjianId." AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.kegiatan_file_itr_ID = ".$reqSoalId;
      $set= new JawabanItr();
      $set=$set->selectByParamsMonitoring($statement)->first();
 
      if(!empty($set))
      {
        $query = JawabanItr::findOrFail($set->jawaban_itr_id);
        // unlink($infofilelokasi);
      }
      else{
        // $maxId = JawabanPe::NextId();
        $query = new JawabanItr();
        // nama kolom yang di insert
        // $query->jawaban_pe_id = $maxId;
        
      }

      $query->jawaban = $reqJawaban;
      $query->kegiatan_file_itr_id = $reqSoalId;
      $query->ujian_id = $reqUjianId;
      $query->pegawai_id = $reqPegawaiId;
      $query->save();
      
      return StringFunc::json_response(200, "0000-Data berhasil disimpan.");

    }
}