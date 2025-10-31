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



class FormulaAtribut extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'formula_atribut';

    protected $primaryKey = 'formula_atribut_id';

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
        return $query->max('formula_atribut_id') + 1; 
    }

    public function scopeSelectByParamsView($query, $id)
    {
        return $query->where('formula_atribut_id', $id);
    }
    
    public function selectByParamsMonitoring($statement="",$order=" ORDER BY A.formula_atribut_id ASC")
    {
      $query="select * from formula_atribut where 1=1". $statement;
      $str = DB::select($query);
    
          // echo $query  ;exit;
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public function selectByParamsLevelAtribut($statement="",$order=" ORDER BY A.LEVEL_ID ASC")
    {
      $query="SELECT A.LEVEL_ID, A.ATRIBUT_ID, A.LEVEL
        , A.KETERANGAN
        FROM level_atribut A
        WHERE 1=1 ". $statement;

      $str = DB::select($query);
    
          // echo $query  ;exit;
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}
