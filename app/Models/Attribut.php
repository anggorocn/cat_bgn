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



class Attribut extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'attribut';

    protected $primaryKey = 'attribut_id';

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
        return $query->max('attribut_id') + 1; 
    }

    public function scopeSelectByParamsView($query, $id)
    {
        return $query->where('attribut_id', $id);
    }

    public function selectByParamsMonitoring($formulaeselonid="",$statement='', $order=" ORDER BY A.ATRIBUT_ID ASC")
    {
      $query="
      SELECT
        FORMULA_ATRIBUT_ID,A.ATRIBUT_ID, A.ATRIBUT_ID_PARENT, A.ASPEK_ID
        , CASE A.ASPEK_ID WHEN '1' THEN 'Potensi' ELSE 'Komptensi' END ASPEK_NAMA
        , A.NAMA, A.KETERANGAN, B.FORMULA_ATRIBUT_ID, B.LEVEL_ID, B.NILAI_STANDAR
        , C.ATRIBUT_NILAI_STANDAR, C.ATRIBUT_BOBOT, C.ATRIBUT_SKOR, C.FORMULA_ATRIBUT_BOBOT_ID
      FROM atribut A
      LEFT JOIN
      (
        SELECT
          MAX(A.FORMULA_ATRIBUT_ID) FORMULA_ATRIBUT_ID
          , A.FORMULA_ESELON_ID, A.LEVEL_ID, A.FORM_ATRIBUT_ID
          , A.FORM_PERMEN_ID, A.FORM_LEVEL, nilai_standar
        FROM formula_atribut A
        WHERE 1=1 AND A.FORMULA_ESELON_ID = '".$formulaeselonid."'
        GROUP BY A.FORMULA_ESELON_ID, A.LEVEL_ID, A.FORM_ATRIBUT_ID, A.FORM_PERMEN_ID, A.FORM_LEVEL,nilai_standar
      ) B ON A.ATRIBUT_ID = B.FORM_ATRIBUT_ID
      LEFT JOIN
      (
        SELECT A.ASPEK_ID, A.ATRIBUT_ID, A.ATRIBUT_NILAI_STANDAR, A.ATRIBUT_BOBOT, A.ATRIBUT_SKOR
        , A.FORMULA_ATRIBUT_BOBOT_ID
        FROM formula_atribut_bobot A
        WHERE 1=1 AND A.FORMULA_ESELON_ID = '".$formulaeselonid."'
      ) C ON A.ATRIBUT_ID = C.ATRIBUT_ID
      
      WHERE 1=1 ". $statement. ' ' .$order;
      $str = DB::select($query);
    
          // echo  $query;exit;
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
