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



class FormulaAtributBobot extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'formula_atribut_bobot';

    protected $primaryKey = 'formula_atribut_bobot_id';

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
        return $query->max('formula_atribut_bobot_id') + 1; 
    }

    public function scopeSelectByParamsView($query, $id)
    {
        return $query->where('formula_atribut_bobot_id', $id);
    }
    
    public function selectByParamsMonitoring($formulaid="",$order=" ORDER BY A.ESELON_ID ASC")
    {

      $str = DB::select(" SELECT B.FORMULA_ESELON_ID, A.ESELON_ID, COALESCE((A.NOTE || ' ' || A.NAMA), A.NAMA) NAMA_ESELON, B.PROSEN_POTENSI, B.PROSEN_KOMPETENSI
    , COALESCE(COALESCE(B.PROSEN_POTENSI,0) + COALESCE(B.PROSEN_KOMPETENSI), 100) PROSEN_TOTALbak
    , B.PROSEN_POTENSI + B.PROSEN_KOMPETENSI PROSEN_TOTAL
    , FORM_PERMEN_ID, b.tahun
    FROM eselon A
    LEFT JOIN formula_eselon B ON A.ESELON_ID = B.ESELON_ID AND B.FORMULA_ID = ".$formulaid."
    LEFT JOIN
    (
      SELECT FORMULA_ESELON_ID FORM_ESELON_ID, FORM_PERMEN_ID
      FROM formula_atribut
      GROUP BY FORMULA_ESELON_ID, FORM_PERMEN_ID
    ) PA ON FORM_ESELON_ID = B.FORMULA_ESELON_ID
    WHERE 1=1");
    
          // echo  $str;exit;
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public function selectByParamsMenu($statement="",$order=" ORDER BY A.ESELON_ID ASC")
    {

      $str = DB::select(" SELECT * from formula_eselon a
      LEFT join eselon b on a.eselon_id= b.eselon_id  
    WHERE 1=1");
    
          // echo  $str;exit;
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}
