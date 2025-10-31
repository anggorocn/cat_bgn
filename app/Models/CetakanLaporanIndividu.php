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

class CetakanLaporanIndividu extends Model
{

    public static function selectByParamsLookupJadwalPegawai($statement="", $jadwaltesid='')
    {
        $query="
           SELECT 
        A.NAMA PEGAWAI_NAMA, A.NIP_BARU PEGAWAI_NIP, A.PEGAWAI_ID ID
        , B.KODE PEGAWAI_GOL, A.LAST_TMT_PANGKAT TMT_GOL_AKHIR, C.NAMA PEGAWAI_ESELON
        , A.LAST_JABATAN PEGAWAI_JAB_STRUKTURAL
        , D.NAMA SATKER
        , ja.no_urut NOMOR_URUT_GENERATE
        , JA.TANGGAL_TES, JA.LAST_UPDATE_DATE
        , ja. nama_asesor_pj, ja. ttd_pimpinan, ja.status_jenis jenis_laporan
        FROM simpeg.pegawai A
        LEFT JOIN simpeg.pangkat B ON A.LAST_PANGKAT_ID = B.PANGKAT_ID
        LEFT JOIN eselon C ON A.LAST_ESELON_ID = C.ESELON_ID
        LEFT JOIN simpeg.satker D ON A.SATKER_ID = D.SATKER_ID
        INNER JOIN
        (
            SELECT B.TANGGAL_TES, A.*,  c.nama nama_asesor_pj, status_jenis, ttd_pimpinan 
            FROM jadwal_awal_tes_simulasi_pegawai A
            INNER JOIN jadwal_tes B ON JADWAL_AWAL_TES_SIMULASI_ID = JADWAL_TES_ID
            LEFT JOIN asesor c on b. ttd_asesor= cast(c.asesor_id as VARCHAR)
            WHERE JADWAL_AWAL_TES_SIMULASI_ID = ".$jadwaltesid."
        ) JA ON JA.PEGAWAI_ID = A.PEGAWAI_ID
        WHERE 1=1 ".$statement;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);
        return $query;  
    }

    public static function selectByParamsPenilaianAsesor($statement='', $sOrder="ORDER BY ur.urut ASC, atribut_id ASC")
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
        WHERE 1=1 ".$statement.' '.$sOrder;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }


    public static function selectByParamsAtributPegawaiPenilaian($statementdetil="", $statement="", $sOrder="ORDER BY A.ATRIBUT_ID ASC")
    {
        $query="
           SELECT 
            CASE WHEN A.ATRIBUT_ID = '0407' THEN '0401'
            WHEN A.ATRIBUT_ID = '0401' THEN '0402'
            WHEN A.ATRIBUT_ID = '0410' THEN '0403'
            WHEN A.ATRIBUT_ID = '0406' THEN '0404'
            WHEN A.ATRIBUT_ID = '0402' THEN '0405'
            WHEN A.ATRIBUT_ID = '0606' THEN '0601'
            WHEN A.ATRIBUT_ID = '0607' THEN '0602'
            WHEN A.ATRIBUT_ID = '0608' THEN '0603'
            WHEN A.ATRIBUT_ID = '0610' THEN '0604'
            WHEN A.ATRIBUT_ID = '0609' THEN '0605'
            ELSE A.ATRIBUT_ID
            END ATRIBUT_KONDISI_ID
            , A.ATRIBUT_ID, A.ATRIBUT_ID_PARENT, A.ASPEK_ID, A.NAMA ATRIBUT_NAMA, B.NILAI_STANDAR, B.NILAI
            , CASE A.ASPEK_ID WHEN 2 THEN 'Aspek Kompetensi' ELSE 'Aspek Psikologi' END ASPEK_NAMA
            , CASE WHEN B.NILAI = 1 THEN 'Belum Kompeten' WHEN B.NILAI = 2 THEN 'Hampir Kompeten'
              WHEN B.NILAI = 3 THEN 'Cukup Kompeten' WHEN B.NILAI = 4 THEN 'Kompeten'
              WHEN B.NILAI = 5 THEN 'Sangat Kompeten' END KESIMPULAN
             ,B.LEVEL, B.CATATAN, ur.urut
        FROM atribut A
        INNER JOIN
        (
            SELECT a.FORMULA_ESELON_ID,A.ATRIBUT_ID, A.NILAI, A.PERMEN_ID, A.NILAI_STANDAR, A.LEVEL, A.CATATAN 
            FROM
            (
                SELECT a.FORMULA_ESELON_ID, A.ATRIBUT_ID, A.NILAI, A.PERMEN_ID, A.NILAI_STANDAR, A.LEVEL, A.CATATAN
                FROM
                (
                    SELECT fe.FORMULA_ESELON_ID, PD.ATRIBUT_ID, PD.NILAI, PD.PERMEN_ID, B1.NILAI_STANDAR, BL.LEVEL, PD.CATATAN
                    FROM penilaian_detil PD
                    left JOIN penilaian P ON PD.PENILAIAN_ID = P.PENILAIAN_ID
                    left JOIN formula_atribut B1 ON B1.FORMULA_ATRIBUT_ID = PD.FORMULA_ATRIBUT_ID
                    left JOIN formula_eselon FE ON FE.FORMULA_ESELON_ID = B1.FORMULA_ESELON_ID
                    left JOIN formula_assesment FA ON FA.FORMULA_ID = FE.FORMULA_ID
                    left JOIN level_atribut BL ON B1.LEVEL_ID = BL.LEVEL_ID
                    WHERE 1=1 ".$statementdetil."
                ) A
                UNION ALL
                SELECT a.FORMULA_ESELON_ID, A.ATRIBUT_ID, A.NILAI, A.PERMEN_ID, A.NILAI_STANDAR, NULL AS LEVEL, null AS CATATAN
                FROM
                (
                    SELECT a.FORMULA_ESELON_ID, A.ATRIBUT_ID, 0 NILAI, A.PERMEN_ID, 0 NILAI_STANDAR
                    FROM
                    (
                        SELECT SUBSTRING(PD.ATRIBUT_ID,1,2) ATRIBUT_ID, PD.PERMEN_ID,fe.FORMULA_ESELON_ID
                        FROM penilaian_detil PD
                        INNER JOIN penilaian P ON PD.PENILAIAN_ID = P.PENILAIAN_ID
                        INNER JOIN formula_atribut B1 ON B1.FORMULA_ATRIBUT_ID = PD.FORMULA_ATRIBUT_ID
                        INNER JOIN formula_eselon FE ON FE.FORMULA_ESELON_ID = B1.FORMULA_ESELON_ID
                        INNER JOIN formula_assesment FA ON FA.FORMULA_ID = FE.FORMULA_ID
                        WHERE 1=1 ".$statementdetil."
                        GROUP BY SUBSTRING(PD.ATRIBUT_ID,1,2), PD.PERMEN_ID,fe.FORMULA_ESELON_ID
                    ) A
                ) A
            ) A
        ) B ON A.ATRIBUT_ID = B.ATRIBUT_ID AND A.PERMEN_ID = B.PERMEN_ID
        LEFT JOIN 
        ( 
            SELECT * FROM formula_assesment_atribut_urutan
        ) UR ON a.ATRIBUT_ID = UR.ATRIBUT_ID AND UR.PERMEN_ID = b.PERMEN_ID and  UR.FORMULA_ESELON_ID = b.FORMULA_ESELON_ID
        WHERE 1=1 ".$statement.' '.$sOrder;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsSumPenilaian($statement="", $order='')
    {
        $query="
           select a.pegawai_id, sum(b.nilai) INDIVIDU_RATING, sum(b.gap), sum((b.nilai - b.gap)) STANDAR_RATING
                from penilaian a
                inner join penilaian_detil b on a.penilaian_id = b.penilaian_id
                where 1=1 ".$statement."
                group by a.pegawai_id ".$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsPenilaianJpmAkhir($statementdetil="", $statement='')
    {
        $query="
           SELECT PEGAWAI_ID, 
        ROUND(COALESCE(PSIKOLOGI_JPM,0),2) PSIKOLOGI_JPM, 
        ROUND(COALESCE(KOMPETEN_JPM,0),2) KOMPETEN_JPM, 
        (CASE WHEN COALESCE(PSIKOLOGI_IKK,0) <= 0 THEN 0 ELSE ROUND(COALESCE(PSIKOLOGI_IKK,0),2) END) PSIKOLOGI_IKK, 
        (CASE WHEN COALESCE(KOMPETEN_IKK,0) <= 0 THEN 0 ELSE ROUND(COALESCE(KOMPETEN_IKK,0),2) END) KOMPETEN_IKK, 
        ROUND(COALESCE(JPM,0),2) JPM, 
        (CASE WHEN COALESCE(IKK,0) <= 0 THEN 0 ELSE ROUND(COALESCE(IKK,0),2) END) IKK
        FROM 
        (
            SELECT PEGAWAI_ID,   
            SUM(PSIKOLOGI_JPM) PSIKOLOGI_JPM, 
            SUM(PSIKOLOGI_IKK) PSIKOLOGI_IKK, 
            SUM(KOMPETEN_JPM) KOMPETEN_JPM, 
            SUM(KOMPETEN_IKK) KOMPETEN_IKK,
            ROUND(((SUM(PSIKOLOGI_JPM) * PROSEN_POTENSI) /100) + ((SUM(KOMPETEN_JPM) * PROSEN_KOMPETENSI) /100),2)  JPM,
            100 - ROUND(((SUM(PSIKOLOGI_JPM) * PROSEN_POTENSI) /100) + ((SUM(KOMPETEN_JPM) * PROSEN_KOMPETENSI) /100),2) IKK
            FROM
            (
                SELECT 
                PEGAWAI_ID,  
                round((SUM(JPM))*100,2) JPM, 
                round((SUM(IKK))*100,2) IKK
                , CASE WHEN ASPEK_ID = 1 THEN round((SUM(JPM))*100,2) ELSE 0 END PSIKOLOGI_JPM 
                , CASE WHEN ASPEK_ID = 1 THEN round((SUM(IKK))*100,2) ELSE 0 END PSIKOLOGI_IKK
                , CASE WHEN ASPEK_ID = 2 THEN round((SUM(JPM))*100,2) ELSE 0 END KOMPETEN_JPM 
                , CASE WHEN ASPEK_ID = 2 THEN round((SUM(IKK))*100,2) ELSE 0 END KOMPETEN_IKK
                ,C.PROSEN_POTENSI, C.PROSEN_KOMPETENSI
                FROM penilaian A
                INNER JOIN JADWAL_TES B ON A.JADWAL_TES_ID = B.JADWAL_TES_ID
                INNER JOIN FORMULA_ESELON C ON B.FORMULA_ESELON_ID = C.FORMULA_ESELON_ID 
                WHERE 1=1
                ".$statementdetil."
                AND A.ASPEK_ID IN (1,2)
                GROUP BY A.PEGAWAI_ID, ASPEK_ID, C.PROSEN_POTENSI, C.PROSEN_KOMPETENSI
            ) A
            GROUP BY A.PEGAWAI_ID,   PROSEN_POTENSI, PROSEN_KOMPETENSI
        ) A 
        where 1=1 ".$statement;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsPenilaianRekomendasi($statement='')
    {
        $query="
           select * from penilaian_rekomendasi a
        where 1=1 ".$statement;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsTtdCbi($statement='')
    {
        $query="
           select a.nama from jadwal_pegawai jp
            left join jadwal_asesor ja on jp.jadwal_asesor_id=ja.jadwal_asesor_id
            left join penggalian p on jp.penggalian_id=p.penggalian_id
            left join asesor a on a.asesor_id=ja.asesor_id
            where p.kode ='CBI' ".$statement;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}
