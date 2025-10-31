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




class JadwalTes extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'jadwal_tes';

    protected $primaryKey = 'jadwal_tes_id';

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
        return $query->max('jadwal_tes_id') + 1; 
    }

    public static function selectByParamsMonitoring($statement="", $order=" ORDER BY A.jadwal_tes_id ASC")
    {
        $query="
           select a.*, c.jadwal_awal_tes_id, fa.tipe_formula
           FROM jadwal_tes A 
           left join jadwal_awal_tes_simulasi b on a. jadwal_tes_id = b.jadwal_awal_tes_simulasi_id
           left join jadwal_awal_tes c on b. jadwal_awal_tes_id = c.jadwal_awal_tes_id
           left join formula_eselon fe on fe. formula_eselon_id = a.formula_eselon_id
           left join formula_assesment fa on fa.formula_id = fe.formula_id
           WHERE 1=1".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsLihatJawabanCFID($jadwaltesid='',$statement="", $order=" ORDER BY a.tipe_ujian_id asc, A.bank_soal_id ASC, c.bank_soal_pilihan_id ASC")
    {
        $query="
            select b.bank_soal_id, b.path_gambar, b.path_soal, b.TIPE_UJIAN_ID
            , c.jawaban path_jawaban,c.bank_soal_pilihan_id bank_jawaban_id, c.grade_prosentase nilai, t. tipe
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A 
            left join cat.bank_soal b on a.bank_soal_id=b.bank_soal_id
            left join cat.tipe_ujian t on b.tipe_ujian_id=t.tipe_ujian_id
            LEFT JOIN cat.bank_soal_pilihan c ON c.bank_soal_id = b.bank_soal_id 
            WHERE 1=1".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsSoalCfid($jadwaltesid='',$statement="", $order="ORDER BY A.UJIAN_ID, A.PEGAWAI_ID, B.TIPE_UJIAN_ID, B.BANK_SOAL_ID, UP.URUT")
    {
        $query="
            
        SELECT
            A.UJIAN_ID, A.PEGAWAI_ID, B.BANK_SOAL_ID, C.PERTANYAAN
            , REPLACE(C.PATH_GAMBAR, 'main', 'cat/main') PATH_GAMBAR, C.PATH_SOAL
            , C.TIPE_SOAL, B.TIPE_UJIAN_ID, TU.TIPE TIPE_UJIAN_NAMA, UP.URUT
        FROM
        (
            SELECT * FROM cat.ujian_pegawai_daftar A
        ) A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.bank_soal C ON B.BANK_SOAL_ID = C.BANK_SOAL_ID
        INNER JOIN
        (
            SELECT A.PEGAWAI_ID, A.JADWAL_TES_ID, A.UJIAN_ID, A.BANK_SOAL_ID, A.TIPE_UJIAN_ID, A.URUT
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
            WHERE 1=1
            GROUP BY A.PEGAWAI_ID, A.JADWAL_TES_ID, A.UJIAN_ID, A.BANK_SOAL_ID, A.TIPE_UJIAN_ID, A.URUT
        ) UP ON A.PEGAWAI_ID = UP.PEGAWAI_ID AND A.JADWAL_TES_ID = UP.JADWAL_TES_ID AND A.UJIAN_ID = UP.UJIAN_ID AND B.BANK_SOAL_ID = UP.BANK_SOAL_ID AND B.TIPE_UJIAN_ID = UP.TIPE_UJIAN_ID
        INNER JOIN cat.tipe_ujian TU ON B.TIPE_UJIAN_ID = TU.TIPE_UJIAN_ID
        WHERE 1=1
        AND A.JADWAL_TES_ID = ".$jadwaltesid."
        AND B.TIPE_UJIAN_ID NOT IN (7, 17) ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsJawabanCfid($jadwaltesid='',$statement="", $order="ORDER BY A.UJIAN_ID, A.PEGAWAI_ID, B.TIPE_UJIAN_ID, B.BANK_SOAL_ID, UP.URUT")
    {
        $query="
        SELECT
            A.UJIAN_ID, A.PEGAWAI_ID, B.BANK_SOAL_ID
            , C1.JAWABAN
            , REPLACE(C.PATH_GAMBAR, 'main', 'cat/main') PATH_GAMBAR, C1.PATH_GAMBAR PATH_SOAL
            , C.TIPE_SOAL, B.TIPE_UJIAN_ID, UP.URUT
        FROM
        (
            SELECT * FROM cat.ujian_pegawai_daftar A
        ) A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.bank_soal C ON B.BANK_SOAL_ID = C.BANK_SOAL_ID
        INNER JOIN
        (
            SELECT A.PEGAWAI_ID, A.JADWAL_TES_ID, A.UJIAN_ID, A.BANK_SOAL_ID, A.TIPE_UJIAN_ID, A.URUT
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
            WHERE 1=1
            GROUP BY A.PEGAWAI_ID, A.JADWAL_TES_ID, A.UJIAN_ID, A.BANK_SOAL_ID, A.TIPE_UJIAN_ID, A.URUT
        ) UP ON A.PEGAWAI_ID = UP.PEGAWAI_ID AND A.JADWAL_TES_ID = UP.JADWAL_TES_ID AND A.UJIAN_ID = UP.UJIAN_ID AND B.BANK_SOAL_ID = UP.BANK_SOAL_ID AND B.TIPE_UJIAN_ID = UP.TIPE_UJIAN_ID
        INNER JOIN cat.bank_soal_pilihan C1 ON B.BANK_SOAL_ID = C1.BANK_SOAL_ID
        WHERE 1=1
        AND A.JADWAL_TES_ID = ".$jadwaltesid."
        AND B.TIPE_UJIAN_ID NOT IN (7, 17) ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsJawabanPegawaiCfid($jadwaltesid='',$statement="", $order="ORDER BY A.UJIAN_ID, A.PEGAWAI_ID, B.TIPE_UJIAN_ID, B.BANK_SOAL_ID, UP.URUT, C1.PATH_GAMBAR")
    {
        $query="
        SELECT
            A.UJIAN_ID, A.PEGAWAI_ID, B.BANK_SOAL_ID
            , C1.JAWABAN, c.kategori
            , REPLACE(C.PATH_GAMBAR, 'main', 'cat/main') PATH_GAMBAR, C1.PATH_GAMBAR PATH_SOAL
            , C.TIPE_SOAL, B.TIPE_UJIAN_ID, UP.URUT, c1.GRADE_PROSENTASE, SP.NAMA NAMA_PEGAWAI
        FROM
        (
            SELECT * FROM cat.ujian_pegawai_daftar A
        ) A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.bank_soal C ON B.BANK_SOAL_ID = C.BANK_SOAL_ID
        INNER JOIN SIMPEG.PEGAWAI SP ON A.PEGAWAI_ID = SP.PEGAWAI_ID
        INNER JOIN
        (
            SELECT A.PEGAWAI_ID, A.JADWAL_TES_ID, A.UJIAN_ID, A.BANK_SOAL_ID, A.BANK_SOAL_PILIHAN_ID, A.TIPE_UJIAN_ID, A.URUT
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
            WHERE 1=1
            AND A.BANK_SOAL_PILIHAN_ID IS NOT NULL
            GROUP BY A.PEGAWAI_ID, A.JADWAL_TES_ID, A.UJIAN_ID, A.BANK_SOAL_ID, A.BANK_SOAL_PILIHAN_ID, A.TIPE_UJIAN_ID, A.URUT
        ) UP ON A.PEGAWAI_ID = UP.PEGAWAI_ID AND A.JADWAL_TES_ID = UP.JADWAL_TES_ID AND A.UJIAN_ID = UP.UJIAN_ID AND B.BANK_SOAL_ID = UP.BANK_SOAL_ID AND B.TIPE_UJIAN_ID = UP.TIPE_UJIAN_ID
        INNER JOIN cat.bank_soal_pilihan C1 ON B.BANK_SOAL_ID = C1.BANK_SOAL_ID AND UP.BANK_SOAL_PILIHAN_ID = C1.BANK_SOAL_PILIHAN_ID
        WHERE 1=1
        AND A.JADWAL_TES_ID = ".$jadwaltesid."
        AND B.TIPE_UJIAN_ID NOT IN (7, 17) ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
    

    public static function selectByParamsDetilPenilaianSJT($jadwaltesid='',$statement="", $order="ORDER BY A.pegawai_id asc, a.BANK_SOAL_ID asc")
    {
        $query="
        select a.pegawai_id,SP.NAMA NAMA_PEGAWAI , COALESCE(BSP.GRADE_PROSENTASE,0) GRADE_PROSENTASE, bs.kategori
        from cat_pegawai.ujian_pegawai_".$jadwaltesid." a
        left JOIN SIMPEG.PEGAWAI SP ON A.PEGAWAI_ID = SP.PEGAWAI_ID
        left JOIN cat.BANK_SOAL_PILIHAN BSP ON A.BANK_SOAL_PILIHAN_ID = BSP.BANK_SOAL_PILIHAN_ID
        left JOIN cat.BANK_SOAL BS ON A.BANK_SOAL_ID = BS.BANK_SOAL_ID
        
         where  1=1 ".$statement.' '.$order;
        //   echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsCheckJawabanPegawai($jadwaltesid='',$statement="", $order="ORDER BY A.UJIAN_ID, A.PEGAWAI_ID, B.TIPE_UJIAN_ID, B.BANK_SOAL_ID, UP.URUT")
    {
        $query="
        SELECT
            A.UJIAN_ID, A.PEGAWAI_ID, B.BANK_SOAL_ID, B.TIPE_UJIAN_ID, UP.URUT
        FROM
        (
            SELECT * FROM cat.ujian_pegawai_daftar A
        ) A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.bank_soal C ON B.BANK_SOAL_ID = C.BANK_SOAL_ID
        INNER JOIN
        (
            SELECT A.PEGAWAI_ID, A.JADWAL_TES_ID, A.UJIAN_ID, A.BANK_SOAL_ID, A.TIPE_UJIAN_ID, A.URUT
            FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
            WHERE 1=1
            GROUP BY A.PEGAWAI_ID, A.JADWAL_TES_ID, A.UJIAN_ID, A.BANK_SOAL_ID, A.TIPE_UJIAN_ID, A.URUT
        ) UP ON A.PEGAWAI_ID = UP.PEGAWAI_ID AND A.JADWAL_TES_ID = UP.JADWAL_TES_ID AND A.UJIAN_ID = UP.UJIAN_ID AND B.BANK_SOAL_ID = UP.BANK_SOAL_ID AND B.TIPE_UJIAN_ID = UP.TIPE_UJIAN_ID
        INNER JOIN
        (
            SELECT A.*
            FROM
            (
                SELECT A.*
                FROM
                (
                    SELECT
                    A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2) ID, A.BANK_SOAL_ID
                    , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                    , COUNT(1) JUMLAH_CHECK
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                    INNER JOIN 
                    (
                        SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                        FROM cat.bank_soal_pilihan
                    ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                    GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                ) A
                INNER JOIN
                (
                    SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                    FROM cat.bank_soal_pilihan
                    WHERE GRADE_PROSENTASE > 0
                    GROUP BY BANK_SOAL_ID
                ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                WHERE GRADE_PROSENTASE = 100
                ORDER BY A.BANK_SOAL_ID
            ) A
            WHERE 1=1
        ) JWB ON A.PEGAWAI_ID = JWB.PEGAWAI_ID AND A.JADWAL_TES_ID = JWB.JADWAL_TES_ID AND A.UJIAN_ID = JWB.UJIAN_ID AND B.BANK_SOAL_ID = JWB.BANK_SOAL_ID AND B.TIPE_UJIAN_ID = JWB.TIPE_UJIAN_ID
        WHERE 1=1
        AND A.JADWAL_TES_ID = ".$jadwaltesid."
        AND B.TIPE_UJIAN_ID NOT IN (7, 17) ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsJawabanBenarCFID($jadwaltesid='',$statement="", $order="ORDER BY A.UJIAN_ID, A.PEGAWAI_ID, B.TIPE_UJIAN_ID, B.BANK_SOAL_ID, C1.PATH_GAMBAR, c1.bank_soal_pilihan_id")
    {
        $query="
        SELECT
            A.UJIAN_ID, A.PEGAWAI_ID, B.BANK_SOAL_ID
            , C1.JAWABAN
            , REPLACE(C.PATH_GAMBAR, 'main', 'cat/main') PATH_GAMBAR, C1.PATH_GAMBAR PATH_SOAL
            , C.TIPE_SOAL, B.TIPE_UJIAN_ID, C1.GRADE_PROSENTASE
        FROM
        (
            SELECT * FROM cat.ujian_pegawai_daftar A
        ) A
        INNER JOIN formula_assesment_ujian_tahap_bank_soal B ON A.FORMULA_ASSESMENT_ID = B.FORMULA_ASSESMENT_ID
        INNER JOIN cat.bank_soal C ON B.BANK_SOAL_ID = C.BANK_SOAL_ID
        INNER JOIN cat.bank_soal_pilihan C1 ON B.BANK_SOAL_ID = C1.BANK_SOAL_ID
        WHERE 1=1
        AND COALESCE(C1.GRADE_PROSENTASE,0) > 0
        AND B.TIPE_UJIAN_ID NOT IN (7, 17)
        AND A.JADWAL_TES_ID = ".$jadwaltesid." ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}
