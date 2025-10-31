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



class LevelAtribut extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'level_atribut';

    protected $primaryKey = 'level_id';

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
        return $query->max('level_id') + 1; 
    }

    public function scopeSelectByParamsView($query, $id)
    {
        return $query->where('level_id', $id);
    }


    
    public function selectByParamsDropdown($statement="",$order=" ORDER BY A.formula_atribut_id ASC")
    {
      $query="SELECT A.LEVEL_ID, A.ATRIBUT_ID, A.LEVEL , A.KETERANGAN FROM level_atribut A WHERE 1=1 AND EXISTS (SELECT 1 FROM (SELECT PERMEN_ID AKTIF_PERMENT FROM PERMEN WHERE STATUS = '1') X WHERE AKTIF_PERMENT = PERMEN_ID) ORDER BY A.LEVEL ASC";
      $str = DB::select($query);
    
          // echo $query  ;exit;
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public function selectByParamschecklist($statement="")
    {
      $query="SELECT PENGGALIAN_ID, TAHUN, KODE, NAMA, KETERANGAN, STATUS_GROUP, STATUS_CBI, STATUS_CAT,
        (CASE STATUS_GROUP WHEN '1' THEN 'Ya' ELSE 'Tidak' END) STATUS_GROUP_NAMA,
        (CASE STATUS_CBI WHEN '1' THEN 'Ya' ELSE 'Tidak' END) STATUS_CBI_NAMA,
        (CASE STATUS_CAT WHEN '1' THEN 'Ya' ELSE 'Tidak' END) STATUS_CAT_NAMA
        FROM penggalian A WHERE 1=1 and kode != 'PT' ".$statement." ORDER BY PENGGALIAN_ID ASC";
        
      $str = DB::select($query);
    
          // echo $query  ;exit;
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}
