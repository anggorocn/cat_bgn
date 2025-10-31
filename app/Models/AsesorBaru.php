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



class AsesorBaru extends Model
{
  /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'asesor';

    protected $primaryKey = 'asesor_id';

    // protected $dates = ['tanggal_lahir'];

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
        return $query->max('asesor_id') + 1; 
    }

    public function selectByParamsJumlahAsesorPegawai($statement='',$asesorId='')
    {
      $query="
        SELECT TO_CHAR(A.TANGGAL_TES, 'YYYY-MM-DD') TANGGAL_TES, JUMLAH, 
        TO_CHAR(A.TANGGAL_TES, 'DD') d, TO_CHAR(A.TANGGAL_TES, 'MM') m, TO_CHAR(A.TANGGAL_TES, 'YYYY') y
        FROM
        (
          SELECT A.TANGGAL_TES, COUNT(1) JUMLAH
          FROM
          (
            SELECT
            JT.TANGGAL_TES, B.PEGAWAI_ID
            FROM jadwal_asesor A
            INNER JOIN jadwal_pegawai B ON A.JADWAL_ASESOR_ID = B.JADWAL_ASESOR_ID
            INNER JOIN jadwal_tes JT ON A.JADWAL_TES_ID = JT.JADWAL_TES_ID
            INNER JOIN formula_eselon FE ON FE.FORMULA_ESELON_ID = JT.FORMULA_ESELON_ID
            INNER JOIN formula_assesment FA ON FA.FORMULA_ID = FE.FORMULA_ID
            WHERE  A.ASESOR_ID = ".$asesorId." and status_valid =1
            GROUP BY JT.TANGGAL_TES, B.PEGAWAI_ID
          ) A
          GROUP BY A.TANGGAL_TES
        ) A
        WHERE 1=1 and JUMLAH is not null
        ".$statement;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public function selectByParamsDataAsesorPegawaiSuper($statement='',$sOrder="ORDER BY JA.NOMOR_URUT")
    {
      $query="
        SELECT
          JA.JADWAL_TES_ID,
          A.PEGAWAI_ID,
          jt.ACARA,
          A.NAMA AS NAMA_PEGAWAI,
          A.NIP_BARU,
          JA.NOMOR_URUT AS NOMOR_URUT_GENERATE,
          a.last_eselon_id,
          JA.asesor_id,
          string_agg(
            CASE 
              WHEN tugas.kode = 'CBI' THEN tugas.kode || ', NILAI AKHIR, KESIMPULAN, KOMPETENSI'
              ELSE tugas.kode
            END, 
            ', '
          ) AS kode -- Menggabungkan kode menjadi satu dengan koma
        FROM simpeg.pegawai A
        INNER JOIN (
          SELECT A.*, x.TANGGAL_TES, x.asesor_id
          FROM (
            SELECT
              A.JADWAL_TES_ID,
              JT.TANGGAL_TES,
              B.PEGAWAI_ID,
              a.asesor_id
            FROM jadwal_asesor A
            INNER JOIN jadwal_pegawai B ON A.JADWAL_ASESOR_ID = B.JADWAL_ASESOR_ID
            INNER JOIN jadwal_tes JT ON A.JADWAL_TES_ID = JT.JADWAL_TES_ID
            INNER JOIN formula_eselon FE ON FE.FORMULA_ESELON_ID = JT.FORMULA_ESELON_ID
            INNER JOIN formula_assesment FA ON FA.FORMULA_ID = FE.FORMULA_ID
            GROUP BY A.JADWAL_TES_ID, JT.TANGGAL_TES, B.PEGAWAI_ID, a.asesor_id
          ) X
          INNER JOIN (
            SELECT
              a.no_urut AS NOMOR_URUT,
              A.PEGAWAI_ID,
              A.LAST_UPDATE_DATE,
              JADWAL_TES_ID
            FROM jadwal_awal_tes_simulasi_pegawai A
            INNER JOIN jadwal_tes B ON JADWAL_AWAL_TES_SIMULASI_ID = JADWAL_TES_ID
          ) A ON A.JADWAL_TES_ID = X.JADWAL_TES_ID AND A.PEGAWAI_ID = X.PEGAWAI_ID
          WHERE 1=1
        ) JA ON JA.PEGAWAI_ID = A.PEGAWAI_ID
        LEFT JOIN (
          SELECT
            JADWAL_TES_ID,
            TANGGAL_TES,
            BATCH,
            ACARA,
            TEMPAT,
            ALAMAT,
            KETERANGAN,
            STATUS_PENILAIAN,
            STATUS_VALID,
            TTD_ASESOR,
            TTD_PIMPINAN,
            NIP_ASESOR,
            NIP_PIMPINAN,
            TTD_TANGGAL
          FROM jadwal_tes
        ) jt ON jt.JADWAL_TES_ID = ja.JADWAL_TES_ID
        LEFT JOIN (
          SELECT
            A.JADWAL_TES_ID,
            JT.TANGGAL_TES,
            JA.keterangan,
            B.PEGAWAI_ID,
            p.kode,
            a.asesor_id
          FROM jadwal_asesor A
          INNER JOIN jadwal_pegawai B ON A.JADWAL_ASESOR_ID = B.JADWAL_ASESOR_ID
          INNER JOIN jadwal_tes JT ON A.JADWAL_TES_ID = JT.JADWAL_TES_ID
          INNER JOIN formula_eselon FE ON FE.FORMULA_ESELON_ID = JT.FORMULA_ESELON_ID
          INNER JOIN formula_assesment FA ON FA.FORMULA_ID = FE.FORMULA_ID
          INNER JOIN jadwal_acara JA ON A.JADWAL_ACARA_ID = JA.JADWAL_ACARA_ID
          INNER JOIN penggalian p ON b.penggalian_id = p.penggalian_id
          WHERE 1=1
          GROUP BY A.JADWAL_TES_ID, JT.TANGGAL_TES, B.PEGAWAI_ID, JA.keterangan, p.kode, a.asesor_id
        ) tugas ON tugas.ASESOR_ID = ja.asesor_id AND JA.JADWAL_TES_ID = tugas.JADWAL_TES_ID AND A.PEGAWAI_ID = tugas.PEGAWAI_ID
        WHERE 1=1 ".$statement."
        GROUP BY
          JA.JADWAL_TES_ID,
          A.PEGAWAI_ID,
          jt.ACARA,
          A.NAMA,
          A.NIP_BARU,
          JA.NOMOR_URUT,
          a.last_eselon_id,
          JA.asesor_id
         ".$sOrder;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public function selectByParamsPenggalianAsesorPegawai($reqJadwalTesId='',$tempAsesorId='',$reqPegawaiId='',$sOrder="ORDER BY  C.penggalian_id desc")
    {
      $query="
        SELECT
          A.JADWAL_ASESOR_ID, A.ASESOR_ID,  z.nama nama_asesor, z.no_sk nip_asesor,  B.PENGGALIAN_ID
          , CASE B.PENGGALIAN_ID WHEN 0 THEN 'Psikotes' ELSE C.NAMA END PENGGALIAN_NAMA
          , CASE B.PENGGALIAN_ID WHEN 0 THEN 'Psikotes' ELSE C.KODE END PENGGALIAN_KODE
          , PENGGALIAN_KODE_ID
          , CASE WHEN PENGGALIAN_KODE_ID IS NOT NULL THEN 1 ELSE 0 END PENGGALIAN_KODE_STATUS
        FROM jadwal_asesor A
        INNER JOIN jadwal_acara B ON A.JADWAL_ACARA_ID = B.JADWAL_ACARA_ID
        LEFT JOIN penggalian C ON C.PENGGALIAN_ID = B.PENGGALIAN_ID
        LEFT JOIN asesor z ON z.asesor_ID = a.Asesor_ID
        LEFT JOIN
        (
          SELECT
            A.JADWAL_TES_ID JT_ID, A.PENGGALIAN_ID PENGGALIAN_KODE_ID
          FROM jadwal_acara A INNER JOIN penggalian C ON C.PENGGALIAN_ID = A.PENGGALIAN_ID
          WHERE 1=1
          AND UPPER(C.KODE) = 'CBI'
          AND EXISTS
          (
            SELECT 1
            FROM
            (
              SELECT JADWAL_ACARA_ID
              FROM jadwal_asesor A
              WHERE 1=1 AND A.JADWAL_TES_ID = ".$reqJadwalTesId."
              AND EXISTS
              (
              SELECT 1
              FROM jadwal_pegawai X 
              WHERE X.PEGAWAI_ID = ".$reqPegawaiId." AND A.JADWAL_ASESOR_ID = X.JADWAL_ASESOR_ID
              )
            ) X
            WHERE A.JADWAL_ACARA_ID = X.JADWAL_ACARA_ID
          )
        ) JT ON B.JADWAL_TES_ID = JT.JT_ID
        WHERE 1=1  
        -- AND CASE WHEN PENGGALIAN_KODE_ID IS NOT NULL THEN 1 ELSE 0 END = 1 
        AND A.JADWAL_TES_ID = ".$reqJadwalTesId."
        -- and a.asesor_id=".$tempAsesorId.
        " ".$sOrder;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
    
    

    public function selectByParamsMenu($reqJadwalTesId='',$tempAsesorId='',$reqPegawaiId='',$sOrder="ORDER BY penggalian_id desc")
    {
      $query="
        select xx.jadwal_asesor_id,a.* from 
        (
            SELECT a.PENGGALIAN_ID, TAHUN, KODE, a.NAMA, a.KETERANGAN, STATUS_GROUP, STATUS_CBI, STATUS_CAT,
            b.essay_soal_id, b.kegiatan_file_id, c.nama kegiatan_file_nama, c.file kegiatan_file_file
            FROM penggalian A 
            left join essay_soal b on b.penggalian_id=a.penggalian_id and ujian_id=26
            left join kegiatan_file c on b.kegiatan_file_id=c.kegiatan_file_id
            inner join (
				SELECT DISTINCT d.penggalian_id
				FROM jadwal_tes A 
				inner join formula_eselon B on a.formula_eselon_id = b.formula_eselon_id
				inner join formula_atribut C on b.formula_eselon_id = c.formula_eselon_id
				left join atribut_penggalian D on c.formula_atribut_id = d.formula_atribut_id
				WHERE A.JADWAL_TES_ID = ".$reqJadwalTesId."
			) d ON A.PENGGALIAN_ID = d.PENGGALIAN_ID
            WHERE 1=1  AND A.TAHUN = ".date('Y')."
			
			union all 
			
			SELECT a.PENGGALIAN_ID, TAHUN, KODE, a.NAMA, a.KETERANGAN, STATUS_GROUP, STATUS_CBI, STATUS_CAT,
            NULL AS essay_soal_id, NULL AS kegiatan_file_id, NULL AS kegiatan_file_nama, NULL AS kegiatan_file_file
            FROM penggalian A  
			where penggalian_id=0
		)a
		left join 
		(
			select y.jadwal_asesor_id, penggalian_id from jadwal_asesor x
			left join jadwal_pegawai y on x.jadwal_asesor_id=y.jadwal_asesor_id
			where pegawai_id=".$reqPegawaiId." and jadwal_tes_id=".$reqJadwalTesId."
		) xx on xx.penggalian_id= a.penggalian_id 

    where jadwal_asesor_id is not null ".$sOrder;
        // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public function selectByParamsPegawaiPenilaian($statement='',$statementInner="",$sOrder="ORDER BY C.KODE")
    {
      $query="
        SELECT 
          H.JADWAL_PEGAWAI_DETIL_ID, A.JADWAL_PEGAWAI_ID, A.JADWAL_ASESOR_ID
          , F.ATRIBUT_ID, F.ASPEK_ID, C1.PENGGALIAN_ID,
          G.INDIKATOR_ID, G.LEVEL_ID, D.FORM_PERMEN_ID,
          H.INDIKATOR_ID PEGAWAI_INDIKATOR_ID, H.LEVEL_ID PEGAWAI_LEVEL_ID,
          F.NAMA ATRIBUT_NAMA, G.NAMA_INDIKATOR, G1.JUMLAH_LEVEL
          , H.KETERANGAN PEGAWAI_KETERANGAN, B1.NAMA NAMA_ASESOR, B.ASESOR_ID
          , D.NILAI_STANDAR, H1.NILAI, H1.GAP
          , H1.CATATAN CATATAN
          , H1.JADWAL_PEGAWAI_DETIL_ATRIBUT_ID, UR.URUT
        FROM jadwal_pegawai A
        INNER JOIN jadwal_asesor B ON A.JADWAL_ASESOR_ID = B.JADWAL_ASESOR_ID
        INNER JOIN asesor B1 ON B.ASESOR_ID = B1.ASESOR_ID
        INNER JOIN jadwal_tes C ON B.JADWAL_TES_ID = C.JADWAL_TES_ID
        INNER JOIN jadwal_acara C1 ON C1.JADWAL_TES_ID = C.JADWAL_TES_ID AND B.JADWAL_ACARA_ID = C1.JADWAL_ACARA_ID
        INNER JOIN
        (
          SELECT A.*
          FROM formula_atribut A
          WHERE 
          EXISTS
          (
            SELECT 1
            FROM
            (
              SELECT
                MAX(A.FORMULA_ATRIBUT_ID) FORMULA_ATRIBUT_ID
                , A.FORMULA_ESELON_ID, A.LEVEL_ID, A.FORM_ATRIBUT_ID
                , A.FORM_PERMEN_ID, A.FORM_LEVEL
              FROM formula_atribut A
              WHERE 1=1
              GROUP BY A.FORMULA_ESELON_ID, A.LEVEL_ID, A.FORM_ATRIBUT_ID, A.FORM_PERMEN_ID, A.FORM_LEVEL
            ) X WHERE X.FORMULA_ATRIBUT_ID = A.FORMULA_ATRIBUT_ID
          )
        ) D ON C.FORMULA_ESELON_ID = D.FORMULA_ESELON_ID
        INNER JOIN atribut F ON D.FORM_ATRIBUT_ID = F.ATRIBUT_ID AND D.FORM_PERMEN_ID = F.PERMEN_ID
        INNER JOIN indikator_penilaian G ON G.LEVEL_ID = D.LEVEL_ID AND F.ATRIBUT_ID = G.INDIKATOR_ATRIBUT_ID AND F.PERMEN_ID = G.INDIKATOR_PERMEN_ID
        INNER JOIN
        (
          SELECT A.JADWAL_PEGAWAI_ID, G.LEVEL_ID, COUNT(1) JUMLAH_LEVEL
          FROM jadwal_pegawai A
          INNER JOIN jadwal_asesor B ON A.JADWAL_ASESOR_ID = B.JADWAL_ASESOR_ID
          INNER JOIN asesor B1 ON B.ASESOR_ID = B1.ASESOR_ID
          INNER JOIN jadwal_tes C ON B.JADWAL_TES_ID = C.JADWAL_TES_ID
          INNER JOIN
          (
            SELECT A.*
            FROM formula_atribut A
            WHERE 
            EXISTS
            (
              SELECT 1
              FROM
              (
                SELECT
                  MAX(A.FORMULA_ATRIBUT_ID) FORMULA_ATRIBUT_ID
                  , A.FORMULA_ESELON_ID, A.LEVEL_ID, A.FORM_ATRIBUT_ID
                  , A.FORM_PERMEN_ID, A.FORM_LEVEL
                FROM formula_atribut A
                WHERE 1=1
                GROUP BY A.FORMULA_ESELON_ID, A.LEVEL_ID, A.FORM_ATRIBUT_ID, A.FORM_PERMEN_ID, A.FORM_LEVEL
              ) X WHERE X.FORMULA_ATRIBUT_ID = A.FORMULA_ATRIBUT_ID
            )
          ) D ON C.FORMULA_ESELON_ID = D.FORMULA_ESELON_ID
          INNER JOIN atribut F ON D.FORM_ATRIBUT_ID = F.ATRIBUT_ID AND D.FORM_PERMEN_ID = F.PERMEN_ID
          INNER JOIN indikator_penilaian G ON G.LEVEL_ID = D.LEVEL_ID AND F.ATRIBUT_ID = G.INDIKATOR_ATRIBUT_ID AND F.PERMEN_ID = G.INDIKATOR_PERMEN_ID
          WHERE 1=1
          ".$statementInner."
          GROUP BY A.JADWAL_PEGAWAI_ID, G.LEVEL_ID
        ) G1 ON G1.LEVEL_ID = G.LEVEL_ID AND A.JADWAL_PEGAWAI_ID = G1.JADWAL_PEGAWAI_ID
        LEFT JOIN jadwal_pegawai_detil H ON H.JADWAL_PEGAWAI_ID = A.JADWAL_PEGAWAI_ID AND H.INDIKATOR_ID = G.INDIKATOR_ID AND D.FORM_PERMEN_ID = H.FORM_PERMEN_ID
        LEFT JOIN jadwal_pegawai_detil_atribut H1 ON H1.JADWAL_PEGAWAI_ID = A.JADWAL_PEGAWAI_ID AND H1.ATRIBUT_ID = D.FORM_ATRIBUT_ID AND D.FORM_PERMEN_ID = H1.FORM_PERMEN_ID
        LEFT JOIN 
        ( 
          SELECT * FROM formula_assesment_atribut_urutan
        ) UR ON f.ATRIBUT_ID = UR.ATRIBUT_ID AND UR.PERMEN_ID = F.PERMEN_ID and  UR.FORMULA_ESELON_ID = C.FORMULA_ESELON_ID
        WHERE 1=1 ".$statement." ".$sOrder;
        //   echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public function selectByParamsNilaiAkhir($statement='',$sOrder="ORDER BY ur.urut, A.ASPEK_ID , A.ATRIBUT_ID asc")
    {
      $query="
        SELECT
        A.PENILAIAN_ID, A.PENILAIAN_DETIL_ID, A.ATRIBUT_ID, A.ATRIBUT_ID_PARENT, A.NAMA, A.ATRIBUT_GROUP
        , A.NILAI_STANDAR, A.NILAI, A.GAP
        , CASE WHEN A.PROSENTASE > 100 THEN 100 ELSE A.PROSENTASE END PROSENTASE
        , STRIP_TAGS(A.BUKTI) BUKTI, STRIP_TAGS(A.CATATAN) CATATAN
        , A.LEVEL, A.LEVEL_KETERANGAN, A.JADWAL_TES_ID, A.PEGAWAI_ID, A.ASPEK_ID, A.CATATAN_STRENGTH,A.CATATAN_WEAKNES,A.KESIMPULAN,A.SARAN_PENGEMBANGAN,A.SARAN_PENEMPATAN,A.PROFIL_KEPRIBADIAN,A.KESESUAIAN_RUMPUN,A.RINGKASAN_PROFIL_KOMPETENSI,UR.URUT
        ,a.FORMULA_ESELON_ID
      FROM 
      (
        SELECT A.PENILAIAN_ID, B.PENILAIAN_DETIL_ID, C.ATRIBUT_ID, C.ATRIBUT_ID_PARENT, C.NAMA, C.ATRIBUT_ID_PARENT ATRIBUT_GROUP
        , B1.NILAI_STANDAR
        , LA.LEVEL, LA.KETERANGAN LEVEL_KETERANGAN
        , CASE WHEN B.NILAI IS NULL THEN 3 ELSE B.NILAI END NILAI, COALESCE(B.GAP,0) GAP, B.BUKTI, B.CATATAN
        , ROUND((B.NILAI / B1.NILAI_STANDAR) * 100,2) PROSENTASE
        , B.PERMEN_ID, A.JADWAL_TES_ID, A.PEGAWAI_ID, A.ASPEK_ID,A.CATATAN_STRENGTH,A.CATATAN_WEAKNES,A.KESIMPULAN,A.SARAN_PENGEMBANGAN,A.SARAN_PENEMPATAN,A.PROFIL_KEPRIBADIAN,A.KESESUAIAN_RUMPUN,A.RINGKASAN_PROFIL_KOMPETENSI
        ,b1.FORMULA_ESELON_ID
        FROM penilaian A
        LEFT JOIN penilaian_detil B ON A.PENILAIAN_ID = B.PENILAIAN_ID
        LEFT JOIN formula_atribut B1 ON B1.FORMULA_ATRIBUT_ID = B.FORMULA_ATRIBUT_ID
        LEFT JOIN atribut C ON B.ATRIBUT_ID = C.ATRIBUT_ID AND B.PERMEN_ID = C.PERMEN_ID
        LEFT JOIN level_atribut LA ON LA.LEVEL_ID = B1.LEVEL_ID
        WHERE 1=1
        UNION ALL
        SELECT B.PENILAIAN_ID, NULL PENILAIAN_DETIL_ID, A.ATRIBUT_ID, A.ATRIBUT_ID_PARENT, A.NAMA, A.ATRIBUT_ID ATRIBUT_GROUP
        , NULL NILAI_STANDAR
        , NULL AS LEVEL, '' LEVEL_KETERANGAN
        , NULL NILAI, NULL GAP, '' BUKTI, '' CATATAN
        , B.PROSENTASE, A.PERMEN_ID, B.JADWAL_TES_ID, B.PEGAWAI_ID, B.ASPEK_ID,B.CATATAN_STRENGTH,B.CATATAN_WEAKNES,B.KESIMPULAN,B.SARAN_PENGEMBANGAN,B.SARAN_PENEMPATAN,B.PROFIL_KEPRIBADIAN,B.KESESUAIAN_RUMPUN,B.RINGKASAN_PROFIL_KOMPETENSI
        ,b.FORMULA_ESELON_ID
        FROM atribut A
        LEFT JOIN
        (
          SELECT B.PENILAIAN_ID, SUBSTR(B.ATRIBUT_ID, 1, 2) ATRIBUT_ID, COUNT(1) JUMLAH_PENILAIAN_DETIL
          , ROUND((SUM(B.NILAI) / SUM(B1.NILAI_STANDAR)) * 100,2) PROSENTASE, PERMEN_ID, B2.JADWAL_TES_ID, B2.PEGAWAI_ID, B2.ASPEK_ID,B2.CATATAN_STRENGTH,B2.CATATAN_WEAKNES,B2.KESIMPULAN,B2.SARAN_PENGEMBANGAN,B2.SARAN_PENEMPATAN,B2.PROFIL_KEPRIBADIAN,B2.KESESUAIAN_RUMPUN,B2.RINGKASAN_PROFIL_KOMPETENSI,b1.FORMULA_ESELON_ID
          FROM penilaian_detil B
          LEFT JOIN formula_atribut B1 ON B1.FORMULA_ATRIBUT_ID = B.FORMULA_ATRIBUT_ID
          LEFT JOIN penilaian B2 ON B.PENILAIAN_ID = B2.PENILAIAN_ID
          WHERE 1=1
          GROUP BY B.PENILAIAN_ID, SUBSTR(B.ATRIBUT_ID, 1, 2), PERMEN_ID, B2.JADWAL_TES_ID, B2.PEGAWAI_ID, B2.ASPEK_ID,B2.CATATAN_STRENGTH,B2.CATATAN_WEAKNES,B2.KESIMPULAN,B2.SARAN_PENGEMBANGAN,B2.SARAN_PENEMPATAN,B2.PROFIL_KEPRIBADIAN,B2.KESESUAIAN_RUMPUN,B2.RINGKASAN_PROFIL_KOMPETENSI,b1.FORMULA_ESELON_ID
        ) B ON A.ATRIBUT_ID = B.ATRIBUT_ID AND A.PERMEN_ID = B.PERMEN_ID
        WHERE 1=1
      ) A
      LEFT JOIN 
      ( 
        SELECT * FROM formula_assesment_atribut_urutan
      ) UR ON a.ATRIBUT_ID = UR.ATRIBUT_ID AND UR.PERMEN_ID = a.PERMEN_ID and  UR.FORMULA_ESELON_ID = a.FORMULA_ESELON_ID
      WHERE 1=1 ".$statement." ".$sOrder;
          // echo  $query; exit;
      $str = DB::select($query);
  
      $query = $str;
      $query=collect($query);

      return $query; 
    }

    public function selectByParamsAsesor($statement='',$sOrder='')
    {
      $query="
        SELECT
        * from asesor
      WHERE 1=1 ".$statement." ".$sOrder;
          // echo  $query; exit;
      $str = DB::select($query);
  
      $query = $str;
      $query=collect($query);

      return $query; 
    }
}
