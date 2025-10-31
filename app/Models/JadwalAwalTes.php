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




class JadwalAwalTes extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'jadwal_awal_tes';

    protected $primaryKey = 'jadwal_awal_tes_id';

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
        return $query->max('jadwal_awal_tes_id') + 1; 
    }

      

    public static function selectByParamsMonitoring($statement="", $order=" ORDER BY A.jadwal_awal_tes_id ASC")
    {
        $query="
           select a.*, c.formula||'('||e.nama||')'  nama_formula 
           from jadwal_awal_tes A 
           left join formula_eselon b on a.formula_eselon_id = b.formula_eselon_id
           left join formula_assesment c on b.formula_id = c.formula_id
		    left join eselon e on b.eselon_id=e.eselon_id
           WHERE 1=1".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}
