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



class FormulaAssesmentUjianTahap extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'formula_assesment_ujian_tahap';

    protected $primaryKey = 'formula_assesment_ujian_tahap_id';

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
        return $query->max('formula_assesment_ujian_tahap_id') + 1; 
    }

    public function scopeSelectByParamsView($query, $id)
    {
        return $query->where('formula_assesment_ujian_tahap_id', $id);
    }
    
    public function selectByParamsMonitoring($statement="",$order=" ORDER BY A.urutan_tes ASC, b.id ASC")
    {
      $query="select a.*, b.tipe nama_ujian, b.parent_id, (select count(x.tipe_ujian_id) from cat.tipe_ujian x where b.id=x.parent_id) anak from formula_assesment_ujian_tahap a
      left join cat.tipe_ujian b on a.tipe_ujian_id = b.tipe_ujian_id where 1=1". $statement.' '. $order;
      $str = DB::select($query);
    
          // echo $query  ;exit;
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public function selectByParamsGenerateSoal($formulasassesmentid="",$lastcreatedate="")
    {
      $query="SELECT SIMULASIUJIANBANKSOAL(".$formulasassesmentid.", '".$lastcreatedate."') AS ROWCOUNT";
      $str = DB::select($query);
    
          // echo $query  ;exit;
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}
