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



class SettingPelaksanaan extends Model
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

    public function selectByParamsMonitoring($statement='',$reqUnitKerja='',$reqJenis='', $order='order by a.formula_id desc')
    {
       $query="
            SELECT
                a.*, count( jadwal_tes_id) terpakai,
                case 
                    when tipe_formula = '1' then 'Assesmet Center'
                    when tipe_formula = '2' then 'Rapid Tes'
                    when tipe_formula = '3' then 'SJT Tes'
                end nama_tipe
            FROM
                formula_assesment a
                left join formula_eselon b on a.formula_id=b.formula_id
                left join jadwal_tes c on b.formula_eselon_id=c.formula_eselon_id
            WHERE 1=1 ".$statement.' GROUP BY a.formula_id  '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }



    public function selectByParamsMonitoringLookop($statement='',$reqUnitKerja='',$reqJenis='', $order=' order by fa.formula_id desc')
    {
       $query="
           select formula_eselon_id, e.nama nama, fa.formula formula_nama,
           case 
            when tipe_formula = '1' then 'Assesmet Center'
            when tipe_formula = '2' then 'Rapid Tes'
            when tipe_formula = '3' then 'SJT Tes'
            end Tipe
           from formula_eselon a 
           left join formula_assesment fa on a. formula_id=fa.formula_id
           left join eselon e on a.eselon_Id=e.ESELON_ID
           WHERE 1=1 ".$statement.' '.$order;
          // echo  $query;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}
