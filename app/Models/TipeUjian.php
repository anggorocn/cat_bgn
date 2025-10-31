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




class TipeUjian extends Model
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
    public static function SelectByParamsView($id)
    {
        $query = DB::table('cat.tipe_ujian as a ')
        ->select('*');
        if(!empty($id))
        {
           $query->where('tipe_ujian_id', $id);
        }
        // dd($query);
        return $query;
    }


    public static function selectByParamsMonitoring($statement="", $order=" ORDER BY A.id ASC")
    {
        $query="
        select * from 
        (
           select a.*, COALESCE(a.waktu, 0)waktu, (select count(x.tipe_ujian_id) from cat.tipe_ujian x where a.id=x.parent_id) anak, COALESCE( a.total_soal,0) total_soal_update, a.id id_sendiri,
                     case when b.tipe is null then a.tipe
                     else b.tipe||' '||a.tipe end nama_gabung  , a.kategori
           FROM cat.tipe_ujian A 
                     left join cat.tipe_ujian b on a.parent_id =b. id
        ) a WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);
        return $query;  
    }

    public static function selectByParamsUjianPilihan($statement="", $order="ORDER BY B.URUTAN_TES ASC,  B.FORMULA_ASSESMENT_UJIAN_TAHAP_ID, ID")
    {
        $query="
           SELECT 
           row_number() OVER () as urutan_ujian,
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
            , URUT, UP.BANK_SOAL_PILIHAN_ID, UP.UJIAN_PEGAWAI_ID
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
            SELECT COUNT(1) JUMLAH_DATA, PEGAWAI_ID, UJIAN_ID, UJIAN_BANK_SOAL_ID
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid."
            WHERE BANK_SOAL_PILIHAN_ID IS NOT NULL
            GROUP BY PEGAWAI_ID, UJIAN_ID, UJIAN_BANK_SOAL_ID
        ) UPX ON UPX.PEGAWAI_ID = A.PEGAWAI_ID AND A.UJIAN_ID = UPX.UJIAN_ID AND UPX.UJIAN_BANK_SOAL_ID = B.FORMULA_ASSESMENT_UJIAN_TAHAP_BANK_SOAL_ID
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsTotalSoal($statement="",$order='')
    {
        $query="
           SELECT a.TIPE_UJIAN_ID, count(BANK_SOAL_ID) total_soal
           from cat.TIPE_UJIAN a 
           LEFT join cat.bank_soal b on a.tipe_ujian_id= b.TIPE_UJIAN_ID
        WHERE 1=1 ".$statement.' group by a.tipe_ujian_id'.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}
