<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Http\Request;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
// use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Casts\Attribute;


use Illuminate\Database\Eloquent\Model;

class UserApp extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'user_app';

    protected $primaryKey = 'user_app_id';
    protected $hidden = [
        'user_group_id'
    ];

    protected $fillable = [
        'username',
        'nama',
        'password'
    ];

    // public function getAuthPassword()
    // {
    //     return $this->user_pass;
    // }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'UserApp_id'
    // ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    public function scopeNextId($query)
    {
        return $query->max('user_app_id') + 1; 
    }

    public function scopeSelectByParamsView($query, $id)
    {
        return $query->where('user_app_id', $id);
    }

    public function scopeSelectByParamsMonitoring($query)
    {
       $query->select('user_app.*', 'user_group.nama as user_group_nama')
       ->leftJoin('user_group', 'user_app.user_group_id', '=', 'user_group.user_group_id');
        return $query; 
    }

    public function scopeSelectByParamsMonitoringUserGroup($query, $id)
    {
        $query = DB::table('user_group')
        ->select('*');
        if($id)
        {
            $query->where('user_group.user_group_id', $id);

        }
        return $query; 
    }

    // public function usergroup()
    // {
    //     return $this->belongsTo('App\Models\UserGroup','user_group_id','user_group_id');
    // }

    public static function selectByParamsCekUjian($statement="")
    {
        $query="
          SELECT 
              A.PEGAWAI_ID PELAMAR_ID, B.NIP_BARU, B.JADWAL_TES_ID, B.FORMULA_ASSESMENT_ID, B.FORMULA_ESELON_ID, B.UJIAN_ID
              , CAST(TANGGAL_TES || ' 00:00:01' AS TIMESTAMP WITHOUT TIME ZONE) PEGAWAI_TANGGAL_AWAL
              , CAST(TANGGAL_TES || ' 23:59:59' AS TIMESTAMP WITHOUT TIME ZONE) PEGAWAI_TANGGAL_AKHIR
              , B.UJIAN_PEGAWAI_DAFTAR_ID, link_soal, limit_drh, b.jadwal_awal_tes_id,waktu_mulai
          FROM user_app A
          INNER JOIN
          (
              SELECT
              A.UJIAN_PEGAWAI_DAFTAR_ID, A.PEGAWAI_ID, C.NIP_BARU, A.JADWAL_TES_ID, A.FORMULA_ASSESMENT_ID, A.FORMULA_ESELON_ID, A.UJIAN_ID, limit_drh
              , TO_CHAR(TGL_MULAI, 'YYYY-MM-DD') TANGGAL_TES, link_soal,jat.jadwal_awal_tes_id, status_valid, waktu_mulai
              FROM cat.ujian_pegawai_daftar A
              INNER JOIN cat.ujian B ON A.UJIAN_ID = B.UJIAN_ID
              INNER JOIN jadwal_tes B1 ON b.jadwal_tes_ID = B1.jadwal_tes_ID
              INNER JOIN simpeg.pegawai C ON A.PEGAWAI_ID = C.PEGAWAI_ID
              left join jadwal_awal_tes_simulasi jats on b1.jadwal_tes_ID=jats.jadwal_awal_tes_simulasi_id
              left join jadwal_awal_tes jat on jats.jadwal_awal_tes_id=jat.jadwal_awal_tes_id
              WHERE 1=1
            -- AND TO_DATE('2025-06-20', 'YYYY-MM-DD') = TO_DATE(TO_CHAR(TGL_MULAI, 'YYYY-MM-DD'), 'YYYY-MM-DD')
            AND CURRENT_DATE = TO_DATE(TO_CHAR(TGL_MULAI, 'YYYY-MM-DD'), 'YYYY-MM-DD')
          ) B ON A.PEGAWAI_ID = B.PEGAWAI_ID
          WHERE 1=1".$statement;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

   
}
