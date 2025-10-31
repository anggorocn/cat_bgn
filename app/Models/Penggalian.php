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




class Penggalian extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'penggalian';

    protected $primaryKey = 'penggalian_id';

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
        return $query->max('penggalian_id') + 1; 
    }

    public static function selectByParamsMonitoring($reqId="")
    {
        $query="
        SELECT A.PENGGALIAN_ID, A.TAHUN, A.KODE, A.NAMA, A.KETERANGAN, A.STATUS_GROUP 
        FROM penggalian A 
        where penggalian_id = 0
        union all
        SELECT A.PENGGALIAN_ID, A.TAHUN, A.KODE, A.NAMA, A.KETERANGAN, A.STATUS_GROUP 
        FROM penggalian A 
        INNER JOIN ( 
        SELECT DISTINCT d.penggalian_id
        FROM jadwal_tes A 
        inner join formula_eselon B on a.formula_eselon_id = b.formula_eselon_id
        inner join formula_atribut C on b.formula_eselon_id = c.formula_eselon_id
        left join atribut_penggalian D on c.formula_atribut_id = d.formula_atribut_id
        WHERE A.JADWAL_TES_ID = ".$reqId.") B ON A.PENGGALIAN_ID = B.PENGGALIAN_ID
        where a.penggalian_id <> 0 and kode!='PT' and tahun=".date("Y")."
         ORDER BY PENGGALIAN_ID ASC";
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }


    public static function selectByParams($statement="")
    {
        $query="
        SELECT A.PENGGALIAN_ID, A.TAHUN, A.KODE, A.NAMA, A.KETERANGAN, A.STATUS_GROUP 
        FROM penggalian A 
        where a.penggalian_id <> 0 and kode!='PT' and tahun=".date("Y")." ".$statement."
         ORDER BY PENGGALIAN_ID ASC";
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}
