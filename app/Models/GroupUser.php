<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use App\Models\UserLogin;
use Illuminate\Support\Facades\DB;
use App\Models\SatuanKerjaFix;
use Illuminate\Support\Str;

class GroupUser extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'user_group';

    protected $primaryKey = 'user_group_id';

    // protected $dates = ['tanggal_lahir'];

    protected $fillable = [
        'nama',
    ];

    protected $dateFormat = 'd-m-Y';
    // buat ubah primary key ke string
    protected $keyType = 'string';

    // protected $casts = [
    //    'tanggal_lahir' => 'date:d-m-Y',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'users_id'
    // ];


    public function scopeNextId($query)
    {
        return $query->max('pegawai_id') + 1; 
    }

    public function scopeSelectByParamsView($query, $id)
    {
        return $query->where('pegawai_id', $id);
    }

    public function execubahdata($pidlama, $pidbaru){
      DB::getPdo()->exec("begin pubahpegawai('".$pidlama."', '".$pidbaru."'); end;");
    }

    public function selectByParamsMonitoring($statement='',$reqUnitKerja='',$reqJenis='', $order='')
    {
      // \DB::enableQueryLog();
      $query = DB::table('user_group as a');
      
      if(!empty($order))
      {
          $query->orderByRaw($order);
      }

      if(!empty($statement))
      {
          $query->whereRaw("A.user_group_id = ? ",[$statement]);
          // vuln sqli
          // query->whereRaw("A.PEGAWAI_ID = to_char(".$statement.") ");
      }

      // dd(\DB::getQueryLog());   
      return $query; 
    }

    public function selectByParamsMonitoringCekUser($statement='', $order='')
    {
      // \DB::enableQueryLog();
      $query = DB::table('PEGAWAI AS A')
      ->select('A.PEGAWAI_ID', 'A.NIP', 'A.NAMA', 'JENIS_KELAMIN', 'ALAMAT', 'TEMPAT_LAHIR', 'TANGGAL_LAHIR', 
       'A.EMAIL', 'PHONE', 'A.JABATAN', 'A.SATUAN_KERJA_ID', 'B.NAMA AS SATUAN_KERJA', 'A.DEPARTEMEN_ID', 'A.DEPARTEMEN', 'A.JENIS_PEGAWAI')
      ->Join('SATUAN_KERJA AS B', 'A.SATUAN_KERJA_ID', '=', 'B.SATUAN_KERJA_ID')
      ->Join('USER_LOGIN AS UL', 'A.PEGAWAI_ID', '=', 'UL.PEGAWAI_ID');
      if(!empty($order))
      {
          $query->orderByRaw($order);
      }

        $rawquery = Str::replaceArray('?', $query->getBindings(), $query->toSql()); 
         // print_r( $rawquery);exit;
      return $query; 
    }

    public function selectByParamsMonitoringNonPegawai($statement='',$reqUnitKerja='',$reqJenis='', $order='')
    {
      // \DB::enableQueryLog();
      $query = DB::table('PEGAWAI AS A')
      ->select('A.PEGAWAI_ID', 'A.NIP', 'A.NAMA', 'JENIS_KELAMIN', 'ALAMAT', 'TEMPAT_LAHIR', 'TANGGAL_LAHIR', 
       'A.EMAIL', 'PHONE', 'A.JABATAN', 'A.SATUAN_KERJA_ID', 'B.NAMA AS SATUAN_KERJA', 'A.DEPARTEMEN_ID', 'A.DEPARTEMEN', 'A.JENIS_PEGAWAI')
      ->Join('SATUAN_KERJA AS B', 'A.SATUAN_KERJA_ID', '=', 'B.SATUAN_KERJA_ID');
      if(!empty($reqUnitKerja))
      {
          $query->where('A.SATUAN_KERJA_ID', $reqUnitKerja);
      }
      if(!empty($reqJenis))
      {
          $query->where('A.JENIS_PEGAWAI', $reqJenis);
      }

      if(!empty($order))
      {
          $query->orderByRaw($order);
      }

      $query->whereRaw("A.SOURCE_DATA = ? ",'IMPORT');
      if(!empty($statement))
      {
          $query->whereRaw("A.PEGAWAI_ID = ? ",[$statement]);
          // vuln sqli
          // query->whereRaw("A.PEGAWAI_ID = to_char(".$statement.") ");
      }
        // echo ( $rawquery);exit;

      // dd(\DB::getQueryLog());   
      return $query; 
    }

    public function satker_model()
    {
       return $this->hasOne(SatuanKerjaFix::class,'nip','pegawai_id');
    }

    public function selectByParamsTesSpeed($username='')
    {
      $str = "
      SELECT PEGAWAI_ID, A.NIP, A.NAMA, JENIS_KELAMIN, ALAMAT, TEMPAT_LAHIR, TANGGAL_LAHIR, 
      A.EMAIL, PHONE, A.JABATAN, A.SATUAN_KERJA_ID, B.NAMA SATUAN_KERJA, A.DEPARTEMEN_ID, A.DEPARTEMEN, A.JENIS_PEGAWAI
      FROM PEGAWAI A INNER JOIN 
      SATUAN_KERJA B ON A.SATUAN_KERJA_ID = B.SATUAN_KERJA_ID ";

      $query = DB::select( $str);
      $query =collect( $query);
      return  $query; 
    }

    public function selectByParamsSqlI($username='')
    {
      $str = "
      SELECT PEGAWAI_ID, A.NIP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, PHONE, A.SATUAN_KERJA_ID,
      B.NAMA SATUAN_KERJA, A.DEPARTEMEN_ID, A.DEPARTEMEN, A.JENIS_PEGAWAI, A.EMAIL
      FROM PEGAWAI A INNER JOIN SATUAN_KERJA B ON A.SATUAN_KERJA_ID = B.SATUAN_KERJA_ID 
      where a.pegawai_id = to_char(".$username.")";

      $query = DB::select( $str);
      $query =collect( $query);
      return  $query; 
    }

    public function selectByPegawai($username='')
    {
      $str = "
      SELECT
          COALESCE(B.SATUAN_KERJA_ID, A.DEPARTEMEN_ID) SATUAN_KERJA_ID,  COALESCE(B.NAMA, C.NAMA) SATUAN_KERJA, 
          COALESCE(B.KODE_LEVEL, C.KODE_LEVEL) KODE_LEVEL, AMBIL_HIRARKI(COALESCE(B.SATUAN_KERJA_ID, A.DEPARTEMEN_ID)) HIRARKI,
          B.KODE_LEVEL KODE_LEVEL_PEJABAT, 
          A.JABATAN SATUAN_KERJA_JABATAN,
          B.KELOMPOK_JABATAN, C.KODE_PARENT
          , ambildirektoratid2(A.DEPARTEMEN_ID) DEPARTEMEN_PARENT_ID
          , B.KODE_SURAT
          , CASE WHEN COALESCE(NULLIF(P.DIVISI_ID, ''), NULL) IS NOT NULL THEN ambil_hirarki_so(P.DIVISI_ID) WHEN COALESCE(JUMLAH_SO,0) > 0 THEN ambil_hirarki_so(A.DEPARTEMEN_ID) ELSE ambil_hirarki_so(C.KODE_PARENT) END SATUAN_KERJA_SO      
          --, CASE WHEN COALESCE(JUMLAH_SO,0) > 0 THEN ambil_hirarki_so(A.DEPARTEMEN_ID) ELSE ambil_hirarki_so(C.KODE_PARENT) END SATUAN_KERJA_SO
      FROM PEGAWAI A 
      LEFT JOIN SATUAN_KERJA_FIX B ON A.PEGAWAI_ID = B.NIP
      LEFT JOIN SATUAN_KERJA_FIX C ON A.DEPARTEMEN_ID = C.SATUAN_KERJA_ID
      LEFT JOIN
      (
            SELECT
                    KODE_PARENT, COUNT(1) JUMLAH_SO
            FROM SATUAN_KERJA X
            GROUP BY KODE_PARENT
      ) SS ON SS.KODE_PARENT = A.DEPARTEMEN_ID
      LEFT JOIN
      (
        SELECT DIVISI_ID, PEGAWAI_ID INFO_PEGAWAI_ID FROM USER_LOGIN
      ) P ON A.PEGAWAI_ID = P.INFO_PEGAWAI_ID
      WHERE A.PEGAWAI_ID = '".$username."' AND B.AN_TAMBAHAN IS NULL ";

       $query = DB::select( $str);
       return collect($query); 
    }

    public function getCountByParams($statement="",$limit=-1,$from=-1, $order=" ")
    {   
        $str = "SELECT COUNT(1) AS ROWCOUNT FROM PEGAWAI A WHERE 1 = 1 ";

        $str .=$statement." ".$order;

        $query = DB::select( $str);

        $query = collect($query);

        return $query; 
    }

    public function selectByPegawainew($statement='',$reqPegawaiId='')
    {
      // \DB::enableQueryLog();
      $query = DB::table('PEGAWAI AS A')
      ->selectRaw(" COALESCE(B.SATUAN_KERJA_ID, A.DEPARTEMEN_ID) SATUAN_KERJA_ID,  COALESCE(B.NAMA, C.NAMA) SATUAN_KERJA, 
          COALESCE(B.KODE_LEVEL, C.KODE_LEVEL) KODE_LEVEL, AMBIL_HIRARKI(COALESCE(B.SATUAN_KERJA_ID, A.DEPARTEMEN_ID)) HIRARKI,
          B.KODE_LEVEL KODE_LEVEL_PEJABAT, 
          A.JABATAN SATUAN_KERJA_JABATAN,
          B.KELOMPOK_JABATAN, C.KODE_PARENT
          , ambildirektoratid2(A.DEPARTEMEN_ID) DEPARTEMEN_PARENT_ID
          , B.KODE_SURAT
          , CASE WHEN COALESCE(NULLIF(P.DIVISI_ID, ''), NULL) IS NOT NULL THEN ambil_hirarki_so(P.DIVISI_ID) WHEN A.PEGAWAI_ID LIKE 'ADM%' THEN ambil_hirarki_so(C.KODE_PARENT) WHEN COALESCE(JUMLAH_SO,0) > 0 THEN ambil_hirarki_so(A.DEPARTEMEN_ID) ELSE ambil_hirarki_so(C.KODE_PARENT) END SATUAN_KERJA_SO")
      ->leftJoin('SATUAN_KERJA_FIX AS B', 'A.PEGAWAI_ID', '=', 'B.NIP')
      ->leftJoin('SATUAN_KERJA_FIX AS C', 'A.DEPARTEMEN_ID', '=', 'C.SATUAN_KERJA_ID')
      ->leftJoin(DB::raw('(SELECT
            KODE_PARENT, COUNT(1) JUMLAH_SO
        FROM SATUAN_KERJA X
        GROUP BY KODE_PARENT)  SS'),
        'SS.KODE_PARENT', '=', 'A.DEPARTEMEN_ID')
      ->leftJoin(DB::raw('(SELECT DIVISI_ID, PEGAWAI_ID INFO_PEGAWAI_ID FROM USER_LOGIN)  P'),
        'A.PEGAWAI_ID', '=', 'P.INFO_PEGAWAI_ID')
      ->where('A.PEGAWAI_ID', $reqPegawaiId)
      ->whereNull('B.AN_TAMBAHAN')
      ->orderByRaw(" COALESCE(B.SATUAN_KERJA_ID, A.DEPARTEMEN_ID)")
      ;

      $rawquery = Str::replaceArray('?', $query->getBindings(), $query->toSql()); 
      // print_r($rawquery);exit;

      // dd(\DB::getQueryLog());   
      return $query; 
    }

    function selectmutasicari($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY A.NAMA, A.NIP")
    { 
      $str = "
      SELECT 
      A.PEGAWAI_ID, A.NAMA, A.DEPARTEMEN_ID, INFO_DEPARTEMEN_NAMA
      , B.NAMA SATUAN_KERJA, A.JABATAN
      FROM PEGAWAI A
      INNER JOIN SATUAN_KERJA B ON A.SATUAN_KERJA_ID = B.SATUAN_KERJA_ID
      LEFT JOIN 
      (
        SELECT NAMA INFO_DEPARTEMEN_NAMA, SATUAN_KERJA_ID INFO_DEPARTEMEN_ID FROM SATUAN_KERJA
      ) DEP ON A.DEPARTEMEN_ID = DEP.INFO_DEPARTEMEN_ID
      WHERE 1 = 1
      "; 

      $str .= $statement." AND ROWNUM < ".$limit+$from." ".$order;
      // echo $str;exit;

      $query = DB::select( $str);
      $query = collect($query);
      // $query = collect($query)->slice($from, $limit);

      // dd($query);

      return $query; 
    }

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY A.NAMA, A.NIP")
    { 
      $str = "
      SELECT 
      PEGAWAI_ID, A.NAMA, A.NIP, A.JENIS_KELAMIN, ALAMAT, TEMPAT_LAHIR, TANGGAL_LAHIR, A.JABATAN, B.NAMA SATUAN_KERJA,
      A.EMAIL, PHONE, A.SATUAN_KERJA_ID
      , CASE WHEN JENIS_KELAMIN = 'L' THEN 'Laki - Laki' WHEN JENIS_KELAMIN = 'P' THEN 'Perempuan' END JENIS_KELAMIN_INFO
      , A.DEPARTEMEN, A.DEPARTEMEN_ID, INFO_DEPARTEMEN_NAMA, A.JENIS_PEGAWAI
      FROM PEGAWAI A 
      INNER JOIN SATUAN_KERJA B ON A.SATUAN_KERJA_ID = B.SATUAN_KERJA_ID
      LEFT JOIN 
      (
      SELECT NAMA INFO_DEPARTEMEN_NAMA, SATUAN_KERJA_ID INFO_DEPARTEMEN_ID FROM SATUAN_KERJA
      ) DEP ON A.DEPARTEMEN_ID = DEP.INFO_DEPARTEMEN_ID
      WHERE 1 = 1
      "; 

      $str .= $statement." ".$order;

      $query = DB::select( $str);

      $query = collect($query)->slice($from, $limit);

      // dd($query);

      return $query; 
    }

    function selectByParamsPengelola($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY A.NAMA, A.NIP")
    { 
      $str = "
      SELECT 
      PEGAWAI_ID, A.NAMA, A.NIP, A.JENIS_KELAMIN, ALAMAT, TEMPAT_LAHIR, TANGGAL_LAHIR, A.JABATAN, B.NAMA SATUAN_KERJA,
      A.EMAIL, PHONE, A.SATUAN_KERJA_ID
      , CASE WHEN JENIS_KELAMIN = 'L' THEN 'Laki - Laki' WHEN JENIS_KELAMIN = 'P' THEN 'Perempuan' END JENIS_KELAMIN_INFO
      , A.DEPARTEMEN, A.DEPARTEMEN_ID, INFO_DEPARTEMEN_NAMA, A.JENIS_PEGAWAI
      FROM PEGAWAI A 
      INNER JOIN SATUAN_KERJA B ON A.SATUAN_KERJA_ID = B.SATUAN_KERJA_ID
      LEFT JOIN 
      (
      SELECT NAMA INFO_DEPARTEMEN_NAMA, SATUAN_KERJA_ID INFO_DEPARTEMEN_ID FROM SATUAN_KERJA
      ) DEP ON A.DEPARTEMEN_ID = DEP.INFO_DEPARTEMEN_ID
      WHERE 1 = 1
      "; 

      $str .= $statement." ".$order;

      $query = DB::select( $str);

      $query = collect($query);

      // dd($query);

      return $query; 
    }

    function selectByParamsUserBantu($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY A.NAMA, A.NIP")
    { 
      $str = "
      SELECT 
      PEGAWAI_ID, A.NAMA, A.NIP, A.JENIS_KELAMIN, ALAMAT, TEMPAT_LAHIR, TANGGAL_LAHIR, A.JABATAN, B.NAMA SATUAN_KERJA,
      A.EMAIL, PHONE, A.SATUAN_KERJA_ID
      , CASE WHEN JENIS_KELAMIN = 'L' THEN 'Laki - Laki' WHEN JENIS_KELAMIN = 'P' THEN 'Perempuan' END JENIS_KELAMIN_INFO
      , A.DEPARTEMEN, A.DEPARTEMEN_ID,  A.JENIS_PEGAWAI, '' INFO_DEPARTEMEN_NAMA
      FROM PEGAWAI A 
      INNER JOIN SATUAN_KERJA B ON A.SATUAN_KERJA_ID = B.SATUAN_KERJA_ID
      WHERE 1 = 1
      "; 

      $str .= $statement." AND ROWNUM < ".$limit+$from." ".$order;
      // echo $str;exit;

      $query = DB::select( $str);
      $query = collect($query);
      // $query = collect($query)->slice($from, $limit);

      // dd($query);

      return $query; 
    }


    public function getCountByParamsUserBantu($statement="",$limit=-1,$from=-1, $order=" ")
    {   
      $str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PEGAWAI A
      INNER JOIN SATUAN_KERJA B ON A.SATUAN_KERJA_ID = B.SATUAN_KERJA_ID 
      WHERE 1 = 1 ";

      $str .=$statement." ".$order;

      $query = DB::select( $str);

      $query = collect($query);

      return $query; 
    }

    function selectByParamsUserPengelola($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY A.NAMA, A.NIP")
    { 
      $str = "
      SELECT 
      A.PEGAWAI_ID, A.NAMA, A.NIP, A.JENIS_KELAMIN, ALAMAT, TEMPAT_LAHIR, TANGGAL_LAHIR, A.JABATAN, B.NAMA SATUAN_KERJA,
      A.EMAIL, PHONE, A.SATUAN_KERJA_ID
      , CASE WHEN JENIS_KELAMIN = 'L' THEN 'Laki - Laki' WHEN JENIS_KELAMIN = 'P' THEN 'Perempuan' END JENIS_KELAMIN_INFO
      , A.DEPARTEMEN, A.DEPARTEMEN_ID,  A.JENIS_PEGAWAI
      FROM PEGAWAI A 
      INNER JOIN SATUAN_KERJA B ON A.SATUAN_KERJA_ID = B.SATUAN_KERJA_ID
      INNER JOIN USER_LOGIN UL ON A.PEGAWAI_ID = UL.PEGAWAI_ID
      WHERE 1 = 1
      "; 

      $str .= $statement." AND ROWNUM < ".$limit+$from." ".$order;
      // echo $str;exit;

      $query = DB::select( $str);
      $query = collect($query);
      // $query = collect($query)->slice($from, $limit);

      // dd($query);

      return $query; 
    }

    function getCountByParamsUserPengelola($statement="",$limit=-1,$from=-1, $order=" ")
    {   
      $str = "SELECT COUNT(1) AS ROWCOUNT FROM PEGAWAI A
      INNER JOIN SATUAN_KERJA B ON A.SATUAN_KERJA_ID = B.SATUAN_KERJA_ID 
      INNER JOIN USER_LOGIN UL ON A.PEGAWAI_ID = UL.PEGAWAI_ID
      WHERE 1 = 1 ";

      $str .=$statement." ".$order;

      $query = DB::select( $str);

      $query = collect($query);

      return $query; 
    }
   
}
