<?php
namespace App\Helper;

class ComboArray
{

	public static function comboLevel(){
	
		$i = 0;
		$arr_json[$i]['id']		= "DIRUT";
		$arr_json[$i]['text']	= "Direktur Utama";
		$i++;
		$arr_json[$i]['id']		= "DIREKSI";
		$arr_json[$i]['text']	= "Direksi";
		$i++;
		$arr_json[$i]['id']		= "VP";
		$arr_json[$i]['text']	= "Setara VP";
		$i++;
		$arr_json[$i]['id']		= "SM";
		$arr_json[$i]['text']	= "Setara SM";
		$i++;
		$arr_json[$i]['id']		= "MAN";
		$arr_json[$i]['text']	= "Setara Manager";
		$i++;

		return $arr_json;
	}
	

	public static function comboLevelCabang() 
	{
		$i = 0;
		$arr_json[$i]['id']		= "GM";
		$arr_json[$i]['text']	= "General Manager";
		$i++;
		$arr_json[$i]['id']		= "SM";
		$arr_json[$i]['text']	= "Setara SM";
		$i++;
		$arr_json[$i]['id']		= "MANAGER";
		$arr_json[$i]['text']	= "Setara Manager";
		$i++;
		return $arr_json;
	}
}

?>