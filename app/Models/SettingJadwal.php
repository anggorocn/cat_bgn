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



class SettingJadwal extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'jadwal_tes';

    protected $primaryKey = 'jadwal_tes_id';

    // protected $dates = ['tanggal_lahir'];

    // protected $fillable = [
    //     'nama',
    //     'nip',
    //     'last_jabatan',
    // ];

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
        return $query->max('jadwal_tes_id') + 1; 
    }

    public function scopeSelectByParamsView($query, $id)
    {
        return $query->where('jadwal_tes_id', $id);
    }

    public static function selectByParamsMonitoring($statement="", $order=" ORDER BY A.tanggal_tes desc")
    {
        $query="
        select * from(
           select TO_CHAR(tanggal_tes, 'DD-MM-YYYY') tanggal_tes_nama, a.*, c. formula nama_formula, c.tipe_formula,
           case when c.tipe_formula='1' then 'Assesment Center'
           when c.tipe_formula='2' then 'Rapid Tes'
           when c.tipe_formula='3' then 'SJT Tes'
           end nama_tipe
           FROM jadwal_tes A 
           left join formula_eselon b on a.formula_eselon_id= b.formula_eselon_id
           left join formula_assesment c on c.formula_id= b.formula_id
        ) a
           WHERE 1=1".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}
