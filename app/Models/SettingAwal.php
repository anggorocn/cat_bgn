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



class SettingAwal extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'formula_assesment';

    protected $primaryKey = 'formula_id';

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
        return $query->max('formula_id') + 1; 
    }

    public function scopeSelectByParamsView($query, $id)
    {
        return $query->where('formula_id', $id);
    }

    public function execubahdata($pidlama, $pidbaru){
      DB::getPdo()->exec("begin pubahpegawai('".$pidlama."', '".$pidbaru."'); end;");
    }

    public static function selectByParamsMonitoring($statement="", $order=" ORDER BY A.TANGGAL_tes desc")
    {
        $query="
           select *,
           case when c.tipe_formula='1' then 'Assesment Center'
           when c.tipe_formula='2' then 'Rapid Tes'
           when c.tipe_formula='3' then 'SJT Tes'
           end nama_tipe
           from jadwal_awal_tes A 
           left join formula_eselon b on a.formula_eselon_id= b.formula_eselon_id
           left join formula_assesment c on c.formula_id= b.formula_id
           WHERE 1=1 
           ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);
        return $query;  
    }
}
