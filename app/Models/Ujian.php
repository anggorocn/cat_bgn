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

class Ujian extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'cat.tipe_ujian';

    protected $primaryKey = 'tipe_ujian_id';

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
        return $query->max('tipe_ujian_id') + 1; 
    }

      public static function updatedata($arrUpdateValueKey=array(),$arrUpdateValue=array())
    {
      // DB::enableQueryLog();
      $query=DB::table('cat.tipe_ujian')->where($arrUpdateValueKey)->update($arrUpdateValue);

      // $queryLog = DB::getQueryLog();
      // $lastQuery = end($queryLog);
      // $rawquery = StringFunc::tampilQuery(1, $lastQuery['bindings'],$lastQuery['query']);

      // dd($rawquery);
       return $query; 

    }

    public static function selectByParamsIdentitasUjian($statement="", $order="")
    {
        $query="
           SELECT 
            A.UJIAN_ID, A.UJIAN_PEGAWAI_DAFTAR_ID, B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID UJIAN_TAHAP_ID
            , C.TIPE
            , case
            when c.KETERANGAN_UJIAN is null then c.tipe
            else C.KETERANGAN_UJIAN
                end KETERANGAN_UJIAN, D.TIPE_INFO
            , B.MENIT_SOAL, C.TIPE_UJIAN_ID, LENGTH(C.PARENT_ID) LENGTH_PARENT, C.PARENT_ID
            , (SELECT 1 FROM cat.UJIAN_TAHAP_STATUS_UJIAN X WHERE 1=1 AND X.UJIAN_ID = A.UJIAN_ID AND X.UJIAN_TAHAP_ID = B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID AND X.PEGAWAI_ID = A.PEGAWAI_ID AND X.TIPE_UJIAN_ID = C.TIPE_UJIAN_ID) TIPE_STATUS
            , CASE C.TIPE_UJIAN_ID WHEN 16 THEN 50 ELSE B.JUMLAH_SOAL END JUMLAH_SOAL
        FROM cat.ujian_pegawai_daftar A
        INNER JOIN 
        (
            SELECT A.*, JUMLAH_SOAL
            FROM formula_assesment_ujian_tahap A
            LEFT JOIN 
            (
                SELECT FORMULA_ASSESMENT_UJIAN_TAHAP_ID ROWID, COUNT(1) JUMLAH_SOAL
                FROM formula_assesment_ujian_tahap_bank_soal
                GROUP BY FORMULA_ASSESMENT_UJIAN_TAHAP_ID
            ) B ON FORMULA_ASSESMENT_UJIAN_TAHAP_ID = ROWID
        ) B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        LEFT JOIN cat.TIPE_UJIAN C ON B.TIPE_UJIAN_ID = C.TIPE_UJIAN_ID
        LEFT JOIN
        (
            SELECT
            A.ID ID_ROW, A.KETERANGAN_UJIAN TIPE_INFO
            FROM cat.TIPE_UJIAN A
            WHERE 1=1 AND PARENT_ID = '0'
        ) D ON C.PARENT_ID = D.ID_ROW
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsSoalCFID($statement="", $statementujian="", $jadwaltesid='', $order='ORDER BY URUT, RANDOM()')
    {
        $query="
           SELECT
            A.UJIAN_ID, B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID UJIAN_BANK_SOAL_ID, B.BANK_SOAL_ID, C.KEMAMPUAN, C.KATEGORI, C.PERTANYAAN
            , A.PEGAWAI_ID, A.STATUS_SETUJU, A.UJIAN_PEGAWAI_DAFTAR_ID
            , C.TIPE_SOAL, C.PATH_GAMBAR, C.PATH_SOAL
            , B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID UJIAN_TAHAP_ID
            , URUT
        FROM cat.ujian_pegawai_daftar A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.bank_soal C ON B.BANK_SOAL_ID = C.BANK_SOAL_ID
        LEFT JOIN
        (
            SELECT
            UJIAN_ID, UJIAN_BANK_SOAL_ID, UJIAN_PEGAWAI_DAFTAR_ID,  URUT, UJIAN_TAHAP_ID
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
            WHERE 1=1 ".$statementujian."
            GROUP by UJIAN_ID, UJIAN_BANK_SOAL_ID, UJIAN_PEGAWAI_DAFTAR_ID, URUT, UJIAN_TAHAP_ID
        ) UP ON B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID = UP.UJIAN_BANK_SOAL_ID
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function selectByParamsSoalPapi($jadwaltesid="", $statement="", $statementujian="", $order="ORDER BY A.UJIAN_ID, B.BANK_SOAL_ID, UP.UJIAN_PEGAWAI_ID")
    {
        $query = "
        SELECT
            A.UJIAN_ID, B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID UJIAN_BANK_SOAL_ID, B.BANK_SOAL_ID, '' KEMAMPUAN, '' KATEGORI, C.PERTANYAAN
            , A.PEGAWAI_ID, A.STATUS_SETUJU, A.UJIAN_PEGAWAI_DAFTAR_ID
            , '' TIPE_SOAL, '' PATH_GAMBAR, '' PATH_SOAL
            , B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID UJIAN_TAHAP_ID
            , URUT, UP.BANK_SOAL_PILIHAN_ID, UP.UJIAN_PEGAWAI_ID
            , CASE WHEN COALESCE(UPX.JUMLAH_DATA,0) > 0 THEN 1 ELSE 0 END JUMLAH_DATA
        FROM cat.ujian_pegawai_daftar A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.soal_papi C ON B.BANK_SOAL_ID = C.SOAL_PAPI_ID
        LEFT JOIN
        (
            SELECT
            UJIAN_ID, UJIAN_BANK_SOAL_ID, UJIAN_PEGAWAI_DAFTAR_ID, UJIAN_PEGAWAI_ID, URUT, BANK_SOAL_PILIHAN_ID, UJIAN_TAHAP_ID
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
            WHERE 1=1 ".$statementujian."
        ) UP ON B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID = UP.UJIAN_BANK_SOAL_ID
        LEFT JOIN
        (
            SELECT COUNT(1) JUMLAH_DATA, PEGAWAI_ID, UJIAN_ID, UJIAN_BANK_SOAL_ID
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." a
            WHERE BANK_SOAL_PILIHAN_ID IS NOT NULL ".$statementujian."
            GROUP BY PEGAWAI_ID, UJIAN_ID, UJIAN_BANK_SOAL_ID
        ) UPX ON UPX.PEGAWAI_ID = A.PEGAWAI_ID AND A.UJIAN_ID = UPX.UJIAN_ID AND UPX.UJIAN_BANK_SOAL_ID = B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID
        WHERE 1=1
        ".$statement.' '.$order;
          // echo  $query; exit;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function selectByParamsSoalMBTI($jadwaltesid="", $statement="", $statementujian="", $order="ORDER BY A.UJIAN_ID, B.BANK_SOAL_ID, UP.UJIAN_PEGAWAI_ID")
    {
        $query = "
        SELECT
            A.UJIAN_ID, B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID UJIAN_BANK_SOAL_ID, B.BANK_SOAL_ID, '' KEMAMPUAN, '' KATEGORI, C.PERTANYAAN
            , A.PEGAWAI_ID, A.STATUS_SETUJU, A.UJIAN_PEGAWAI_DAFTAR_ID
            , '' TIPE_SOAL, '' PATH_GAMBAR, '' PATH_SOAL
            , B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID UJIAN_TAHAP_ID
            , URUT, UP.BANK_SOAL_PILIHAN_ID, UP.UJIAN_PEGAWAI_ID
            , CASE WHEN COALESCE(UPX.JUMLAH_DATA,0) > 0 THEN 1 ELSE 0 END JUMLAH_DATA
        FROM cat.ujian_pegawai_daftar A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.mbti_soal C ON B.BANK_SOAL_ID = C.mbti_soal_id
        LEFT JOIN
        (
            SELECT
            UJIAN_ID, UJIAN_BANK_SOAL_ID, UJIAN_PEGAWAI_DAFTAR_ID, UJIAN_PEGAWAI_ID, URUT, BANK_SOAL_PILIHAN_ID, UJIAN_TAHAP_ID
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
            WHERE 1=1 ".$statementujian."
        ) UP ON B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID = UP.UJIAN_BANK_SOAL_ID
        LEFT JOIN
        (
            SELECT COUNT(1) JUMLAH_DATA, PEGAWAI_ID, UJIAN_ID, UJIAN_BANK_SOAL_ID
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid."
            WHERE BANK_SOAL_PILIHAN_ID IS NOT NULL
            GROUP BY PEGAWAI_ID, UJIAN_ID, UJIAN_BANK_SOAL_ID
        ) UPX ON UPX.PEGAWAI_ID = A.PEGAWAI_ID AND A.UJIAN_ID = UPX.UJIAN_ID AND UPX.UJIAN_BANK_SOAL_ID = B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID
        WHERE 1=1
        ".$statement.' '.$order;
          // echo  $query; exit;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function selectByParamsBankSoal($jadwaltesid="", $statement="", $statementujian="", $order="ORDER BY A.UJIAN_ID, B.BANK_SOAL_ID, UP.UJIAN_PEGAWAI_ID")
    {
        $query = "
        SELECT
            A.UJIAN_ID, B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID UJIAN_BANK_SOAL_ID, B.BANK_SOAL_ID, '' KEMAMPUAN, '' KATEGORI, C.PERTANYAAN
            , A.PEGAWAI_ID, A.STATUS_SETUJU, A.UJIAN_PEGAWAI_DAFTAR_ID
            , C.TIPE_SOAL, C.PATH_GAMBAR, C.PATH_SOAL
            , B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID UJIAN_TAHAP_ID
            , URUT, UP.BANK_SOAL_PILIHAN_ID, UP.UJIAN_PEGAWAI_ID, up1.keterangan
            , CASE WHEN COALESCE(UPX.JUMLAH_DATA,0) > 0 THEN 1 ELSE 0 END JUMLAH_DATA
        FROM cat.ujian_pegawai_daftar A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.bank_soal C ON B.BANK_SOAL_ID = C.BANK_SOAL_ID
        LEFT JOIN
        (
            SELECT
            UJIAN_ID, UJIAN_BANK_SOAL_ID, UJIAN_PEGAWAI_DAFTAR_ID, UJIAN_PEGAWAI_ID, URUT, BANK_SOAL_PILIHAN_ID, UJIAN_TAHAP_ID
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
            WHERE 1=1 ".$statementujian."
        ) UP ON B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID = UP.UJIAN_BANK_SOAL_ID
        LEFT JOIN
        (
            SELECT
            UJIAN_BANK_SOAL_ID, keterangan
            FROM cat_pegawai.ujian_pegawai_keterangan_".$jadwaltesid." A
            WHERE 1=1 ".$statementujian."
        ) UP1 ON B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID = UP1.UJIAN_BANK_SOAL_ID
        LEFT JOIN
        (
            SELECT COUNT(1) JUMLAH_DATA, PEGAWAI_ID, UJIAN_ID, UJIAN_BANK_SOAL_ID
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid."
            WHERE BANK_SOAL_PILIHAN_ID IS NOT NULL
            GROUP BY PEGAWAI_ID, UJIAN_ID, UJIAN_BANK_SOAL_ID
        ) UPX ON UPX.PEGAWAI_ID = A.PEGAWAI_ID AND A.UJIAN_ID = UPX.UJIAN_ID AND UPX.UJIAN_BANK_SOAL_ID = B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID
        WHERE 1=1
        ".$statement.' '.$order;
          // echo  $query; exit;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function selectByParamsJawabanSoalPapi($statement="", $order="ORDER BY A.UJIAN_ID, B.BANK_SOAL_ID, D.PAPI_PILIHAN_ID")
    {
        $query = "
        SELECT
            A.UJIAN_ID, B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID UJIAN_BANK_SOAL_ID, B.BANK_SOAL_ID, D.PAPI_PILIHAN_ID BANK_SOAL_PILIHAN_ID, D.JAWABAN
            , A.STATUS_SETUJU, A.UJIAN_PEGAWAI_DAFTAR_ID, C.TIPE_UJIAN_ID TIPE_SOAL, 
            '' PATH_GAMBAR1
            , '' PATH_GAMBAR
            , '' PATH_SOAL
            , '' PATH_SOAL1
        FROM cat.ujian_pegawai_daftar A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.soal_papi C ON B.BANK_SOAL_ID = C.SOAL_PAPI_ID
        INNER JOIN cat.papi_pilihan D ON B.BANK_SOAL_ID = D.SOAL_PAPI_ID
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function selectByParamsJawabanSoalMBTI($statement="", $order="ORDER BY A.UJIAN_ID, B.BANK_SOAL_ID, D.mbti_PILIHAN_ID")
    {
        $query = "
        SELECT
            A.UJIAN_ID, B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID UJIAN_BANK_SOAL_ID, B.BANK_SOAL_ID, D.mbti_PILIHAN_ID BANK_SOAL_PILIHAN_ID, D.JAWABAN
            , A.STATUS_SETUJU, A.UJIAN_PEGAWAI_DAFTAR_ID, C.TIPE_UJIAN_ID TIPE_SOAL, 
            '' PATH_GAMBAR1
            , '' PATH_GAMBAR
            , '' PATH_SOAL
            , '' PATH_SOAL1
        FROM cat.ujian_pegawai_daftar A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.mbti_soal C ON B.BANK_SOAL_ID = C.mbti_soal_id
        INNER JOIN cat.mbti_pilihan D ON B.BANK_SOAL_ID = D.mbti_soal_id
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function selectByParamsJawabanBankSoal($statement="", $order="ORDER BY A.UJIAN_ID, B.BANK_SOAL_ID, D.BANK_SOAL_PILIHAN_ID")
    {
        $query = "
        SELECT
            A.UJIAN_ID, B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID UJIAN_BANK_SOAL_ID, B.BANK_SOAL_ID, D.bank_soal_PILIHAN_ID BANK_SOAL_PILIHAN_ID, D.JAWABAN
            , A.STATUS_SETUJU, A.UJIAN_PEGAWAI_DAFTAR_ID, C.TIPE_UJIAN_ID TIPE_SOAL, 
            REPLACE(C.PATH_GAMBAR, '../', '../../angkasapura-admin/') PATH_GAMBAR1
            , C.PATH_GAMBAR
            , D.PATH_GAMBAR PATH_SOAL
            , C.PATH_SOAL PATH_SOAL1
        FROM cat.ujian_pegawai_daftar A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.bank_soal C ON B.BANK_SOAL_ID = C.BANK_SOAL_ID
        INNER JOIN cat.BANK_SOAL_pilihan D ON B.BANK_SOAL_ID = D.BANK_SOAL_ID
        left JOIN cat.BANK_SOAL_pilihan_acak e ON e.BANK_SOAL_pilihan_id = D.BANK_SOAL_pilihan_id and A.PEGAWAI_ID=e.PEGAWAI_ID and A.UJIAN_ID=e.UJIAN_ID
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsJawabanCFID($statement="",$ujianid='',$order='ORDER BY D.BANK_SOAL_PILIHAN_ID')
    {
        $query="
           SELECT
           A.UJIAN_ID, B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID UJIAN_BANK_SOAL_ID, B.BANK_SOAL_ID, D.BANK_SOAL_PILIHAN_ID, D.JAWABAN
            , A.STATUS_SETUJU, A.UJIAN_PEGAWAI_DAFTAR_ID, TIPE_SOAL, 
            REPLACE(C.PATH_GAMBAR, '../', '../../angkasapura-admin/') PATH_GAMBAR1
            , C.PATH_GAMBAR
            , D.PATH_GAMBAR PATH_SOAL
            , C.PATH_SOAL PATH_SOAL1
        FROM cat.ujian_pegawai_daftar A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.bank_soal C ON B.BANK_SOAL_ID = C.BANK_SOAL_ID
        INNER JOIN cat.bank_soal_pilihan D ON B.BANK_SOAL_ID = D.BANK_SOAL_ID
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsJawabanPesertaCFID($statement="",$ujianid='',$order='')
    {
        $query="
           SELECT
          *
        FROM cat_pegawai.ujian_pegawai_".$ujianid."  A
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function getCountByParamsPetunjukCek($statement="")
    {
        $query="
          SELECT COUNT(1) AS ROWCOUNT FROM cat.UJIAN_TAHAP_STATUS_UJIAN_PETUNJUK A WHERE 1=1 ".$statement;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsUjianTahapMulai($statement="")
    {
        $query="
          SELECT COUNT(1) AS ROWCOUNT FROM cat.UJIAN_TAHAP_STATUS_UJIAN_PETUNJUK A WHERE 1=1 ".$statement;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function selectByParamsSoalDisc($jadwaltesid="", $statement="", $statementujian="", $order="ORDER BY A.UJIAN_ID, B.BANK_SOAL_ID, UP.UJIAN_PEGAWAI_ID")
    {
        $query = "
        SELECT
            A.UJIAN_ID, B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID UJIAN_BANK_SOAL_ID, B.BANK_SOAL_ID, '' KEMAMPUAN, '' KATEGORI, C.PERTANYAAN
            , A.PEGAWAI_ID, A.STATUS_SETUJU, A.UJIAN_PEGAWAI_DAFTAR_ID
            , '' TIPE_SOAL, '' PATH_GAMBAR, '' PATH_SOAL
            , B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID UJIAN_TAHAP_ID
            , URUT, UP.BANK_SOAL_PILIHAN_ID, UP.UJIAN_PEGAWAI_ID
            , CASE WHEN COALESCE(UPX.JUMLAH_DATA,0) > 0 THEN 1 ELSE 0 END JUMLAH_DATA
        FROM cat.ujian_pegawai_daftar A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.disk_soal C ON B.BANK_SOAL_ID = C.disk_soal_id
        LEFT JOIN
        (
            SELECT
            UJIAN_ID, UJIAN_BANK_SOAL_ID, UJIAN_PEGAWAI_DAFTAR_ID, UJIAN_PEGAWAI_ID, URUT, BANK_SOAL_PILIHAN_ID, UJIAN_TAHAP_ID
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
            WHERE 1=1 ".$statementujian."
        ) UP ON B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID = UP.UJIAN_BANK_SOAL_ID
        LEFT JOIN
        (
            SELECT COUNT(1) JUMLAH_DATA, PEGAWAI_ID, UJIAN_ID, UJIAN_BANK_SOAL_ID
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid."
            WHERE BANK_SOAL_PILIHAN_ID IS NOT NULL
            GROUP BY PEGAWAI_ID, UJIAN_ID, UJIAN_BANK_SOAL_ID
        ) UPX ON UPX.PEGAWAI_ID = A.PEGAWAI_ID AND A.UJIAN_ID = UPX.UJIAN_ID AND UPX.UJIAN_BANK_SOAL_ID = B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID
        WHERE 1=1
        ".$statement.' '.$order;
          // echo  $query; exit;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function selectByParamsSoalMMPI($jadwaltesid="", $statement="", $statementujian="", $order="ORDER BY A.UJIAN_ID, B.BANK_SOAL_ID, UP.UJIAN_PEGAWAI_ID")
    {
        $query = "
        SELECT
            A.UJIAN_ID, B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID UJIAN_BANK_SOAL_ID, B.BANK_SOAL_ID, '' KEMAMPUAN, '' KATEGORI, C.PERTANYAAN
            , A.PEGAWAI_ID, A.STATUS_SETUJU, A.UJIAN_PEGAWAI_DAFTAR_ID
            , '' TIPE_SOAL, '' PATH_GAMBAR, '' PATH_SOAL
            , B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID UJIAN_TAHAP_ID
            , URUT, UP.BANK_SOAL_PILIHAN_ID, UP.UJIAN_PEGAWAI_ID
            , CASE WHEN COALESCE(UPX.JUMLAH_DATA,0) > 0 THEN 1 ELSE 0 END JUMLAH_DATA
        FROM cat.ujian_pegawai_daftar A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.mmpi_soal C ON B.BANK_SOAL_ID = C.mmpi_soal_id
        LEFT JOIN
        (
            SELECT
            UJIAN_ID, UJIAN_BANK_SOAL_ID, UJIAN_PEGAWAI_DAFTAR_ID, UJIAN_PEGAWAI_ID, URUT, BANK_SOAL_PILIHAN_ID, UJIAN_TAHAP_ID
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
            WHERE 1=1 ".$statementujian."
        ) UP ON B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID = UP.UJIAN_BANK_SOAL_ID
        LEFT JOIN
        (
            SELECT COUNT(1) JUMLAH_DATA, PEGAWAI_ID, UJIAN_ID, UJIAN_BANK_SOAL_ID
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid."
            WHERE BANK_SOAL_PILIHAN_ID IS NOT NULL
            GROUP BY PEGAWAI_ID, UJIAN_ID, UJIAN_BANK_SOAL_ID
        ) UPX ON UPX.PEGAWAI_ID = A.PEGAWAI_ID AND A.UJIAN_ID = UPX.UJIAN_ID AND UPX.UJIAN_BANK_SOAL_ID = B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID
        WHERE 1=1
        ".$statement.' '.$order;
          // echo  $query; exit;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
    
    function selectByParamsJawabanSoalDisc($statement="", $order="ORDER BY A.UJIAN_ID, B.BANK_SOAL_ID, D.disk_PILIHAN_ID")
    {
        $query = "
        SELECT
            A.UJIAN_ID, B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID UJIAN_BANK_SOAL_ID, B.BANK_SOAL_ID, D.disk_PILIHAN_ID BANK_SOAL_PILIHAN_ID, D.JAWABAN
            , A.STATUS_SETUJU, A.UJIAN_PEGAWAI_DAFTAR_ID, C.TIPE_UJIAN_ID TIPE_SOAL, 
            '' PATH_GAMBAR1
            , '' PATH_GAMBAR
            , '' PATH_SOAL
            , '' PATH_SOAL1
        FROM cat.ujian_pegawai_daftar A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.disk_soal C ON B.BANK_SOAL_ID = C.disk_soal_id
        INNER JOIN cat.disk_pilihan D ON B.BANK_SOAL_ID = D.disk_soal_id
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
    
    function selectByParamsJawabanSoalMMPI($statement="", $order="ORDER BY A.UJIAN_ID, B.BANK_SOAL_ID, D.mmpi_PILIHAN_ID")
    {
        $query = "
        SELECT
            A.UJIAN_ID, B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID UJIAN_BANK_SOAL_ID, B.BANK_SOAL_ID, D.mmpi_PILIHAN_ID BANK_SOAL_PILIHAN_ID, D.JAWABAN
            , A.STATUS_SETUJU, A.UJIAN_PEGAWAI_DAFTAR_ID, C.TIPE_UJIAN_ID TIPE_SOAL, 
            '' PATH_GAMBAR1
            , '' PATH_GAMBAR
            , '' PATH_SOAL
            , '' PATH_SOAL1
        FROM cat.ujian_pegawai_daftar A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.mmpi_soal C ON B.BANK_SOAL_ID = C.mmpi_soal_id
        INNER JOIN cat.mmpi_pilihan D ON B.BANK_SOAL_ID = D.mmpi_soal_id
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}
