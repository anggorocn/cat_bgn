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




class UjianTahapPegawai extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'cat.ujian_tahap_pegawai';

    protected $primaryKey = 'ujian_pegawai_daftar_id';

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
        return $query->max('ujian_pegawai_daftar_id') + 1; 
    }

    function selectByParams($statement='', $order="")
    {
        $query="
            select*
        FROM cat.ujian_tahap_pegawai A
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query;
    }

    function selectByParamsUjianPegawaiTahap($statement='', $order="ORDER BY ID")
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
        WHERE 1=1
        ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query;
    }
}
