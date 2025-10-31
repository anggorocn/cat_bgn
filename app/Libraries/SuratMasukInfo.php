<?php
namespace App\Libraries;
use Illuminate\Support\Facades\Session;


class SuratMasukInfo
{

	public static function getAkses($suratMasukId="", $userId="", $infodivisi="", $infogantijabatan= ""){
		$user=Session::get('user');
		// dd($user);

		if(in_array("SURAT", explode(",",$this->USER_GROUP)))
		{
			$statement= " AND 
			(
			EXISTS
			(
			SELECT 1
			FROM
			(
			SELECT B.PEGAWAI_ID
			FROM USER_LOGIN A
			INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
			WHERE 
			B.SATUAN_KERJA_ID LIKE '".$this->CABANG_ID."%'
			) X WHERE X.PEGAWAI_ID = A.USER_ID
			)
			OR
			A.USER_ID LIKE '".$this->CABANG_ID."%'
			)
			";
		}
		else
		{
			$statement= "1";
		}
		
	}
}

?>