<?php
namespace App\Helper;
use Illuminate\Support\Str;

class StringFunc
{


	public static function multi_array_search($array, $search)
	{
		$result = array();

		foreach ($array as $key => $val)
		{
			foreach ($search as $k => $v)
			{
            // We check if the $k has an operator.
				$operator = '=';
				if (preg_match('(<|<=|>|>=|!=|=)', $k, $m) === 1)
				{
                // We change the operator.
					$operator = $m[0];

                // We trim $k to remove white spaces before and after.
					$k = trim(str_replace($m[0], '', $k));
				}

				switch ($operator)
				{
					case '=':

					$cond = (isset($val[$k]) != $v);
					break;

					case '!=':
					$cond = ($val[$k] == $v);
					break;

					case '>':
					$cond = ($val[$k] <= $v);
					break;

					case '<':
					$cond = ($val[$k] >= $v);
					break;

					case '>=':
					$cond = ($val[$k] < $sv);
					break;

					case '<=':
					$cond = ($val[$k] > $sv);
					break;
				}

				if (( ! isset($val[$k]) && isset($val[$k]) !== null) OR $cond)
				{
					continue 2;
				}
			}

			$result[] = $val ;
		}

		return $result;
	}  

	public static function checkSelectedArray($value,$arrData){
		$boleen = false;
		if(in_array($value,$arrData)){
			$boleen = true;
		}
		return $boleen;
	}
	public static function checkStringToArray($value,$arrData){

		$boleen = false;
		$arrData = StringFunc::getmultiseparator($arrData);
		if(in_array($value,$arrData)){
			$boleen = true;
		}
		return $boleen;
	}

	public static function _limit($sql, $limit, $offset)
    {
        $limit = $offset + $limit;
        
        if($limit > 0)
            $sqllimit = " WHERE rownum <= $limit ";
        else
            $sqllimit = "";
        
        $newsql = "SELECT * FROM (select inner_query.*, rownum rnum FROM ($sql) inner_query ".$sqllimit.")";

        if ($offset != 0)
        {
            $newsql .= " WHERE rnum >= $offset";
        }

        // remember that we used limits
       

        return $newsql;
    }
   
	public static function makedirs($dirpath, $mode=0777)
	{
	    return is_dir($dirpath) || mkdir($dirpath, $mode, true);
	}

	 
	public static function setInfoChecked($val1, $val2, $val="checked")
	{
		if($val1 == $val2)
			return $val;
		else
			return "";
	}

	public static function getsavequery($queries)
	{
		foreach ($queries as $key => $query) {
			$formattedBindings = array_map(function ($binding) {
				if (is_null($binding)) {
					return 'NULL'; // Convert null to string 'NULL'
				} elseif (is_string($binding)) {
					return "'{$binding}'"; // Add quotes around strings
				} else {
					return $binding; // Keep numeric or other types as-is
				}
			}, $query['bindings']);

			$fullQuery= Str::replaceArray('?', $formattedBindings, $query['query']);
	    }
	    return $fullQuery;
	}

	public static function in_array_column($text, $column, $array)
	{
		$arr= [];
	    if (!empty($array) && is_array($array))
	    {
	        for ($i=0; $i < count($array); $i++)
	        {
	            if ($array[$i][$column]==$text || strcmp($array[$i][$column],$text)==0) 
					$arr[] = $i;
	        }
			return $arr;
	    }
	    return "";
	}

	public static function currencyToPage($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
	{

	    if($value == "")
			$value = 0;
		$rupiah = number_format($value,0, ",",".");
	    $rupiah = $rupiah . ",-";
	    return $rupiah;
	}

	public static function nomorDigit($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
	{
		$arrValue = explode(".", $value);
		$value = $arrValue[0];
		if(count($arrValue) == 1)
			$belakang_koma = "";
		else
			$belakang_koma = $arrValue[1];
		if($value < 0)
		{
			$neg = "-";
			$value = str_replace("-", "", $value);
		}
		else
			$neg = false;
			
		$cntValue = strlen($value);
		//$cntValue = strlen($value);
		
		if($cntValue <= $digit)
			$resValue =  $value;
		
		$loopValue = floor($cntValue / $digit);
		
		for($i=1; $i<=$loopValue; $i++)
		{
			$sub = 0 - $i; //ubah jadi negatif
			$tempValue = $endValue;
			$endValue = substr($value, $sub*$digit, $digit);
			$endValue = $endValue;
			
			if($i !== 1)
				$endValue .= ".";
			
			$endValue .= $tempValue;
		}
		
		$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
		
		if($cntValue % $digit == 0)
			$resValue = $beginValue.$endValue;
		else if($cntValue > $digit)
			$resValue = $beginValue.".".$endValue;
		
		//additional
		if($belakang_koma == "")
			$resValue = $symbol." ".$resValue;
		else
			$resValue = $symbol." ".$resValue.",".$belakang_koma;
		
		
		if($minusToBracket && $neg)
		{
			$resValue = "(".$resValue.")";
			$neg = "";
		}
		
		if($minusLess == true)
		{
			$neg = "";
		}
		
		$resValue = $neg.$resValue;
		
		//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

		return $resValue;
	}


	public static function numberToIna($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
	{
		$arr_value = explode(".", $value);
		
		if(count($arr_value) > 1)
			$value = $arr_value[0];
		
		if($value < 0)
		{
			$neg = "-";
			$value = str_replace("-", "", $value);
		}
		else
			$neg = false;
			
		$cntValue = strlen($value);
		//$cntValue = strlen($value);
		
		if($cntValue <= $digit)
			$resValue =  $value;
		
		$loopValue = floor($cntValue / $digit);
		
		for($i=1; $i<=$loopValue; $i++)
		{
			$sub = 0 - $i; //ubah jadi negatif
			$tempValue = $endValue;
			$endValue = substr($value, $sub*$digit, $digit);
			$endValue = $endValue;
			
			if($i !== 1)
				$endValue .= ".";
			
			$endValue .= $tempValue;
		}
		
		$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
		
		if($cntValue % $digit == 0)
			$resValue = $beginValue.$endValue;
		else if($cntValue > $digit)
			$resValue = $beginValue.".".$endValue;
		
		//additional
		if($symbol == true && $resValue !== "")
		{
			$resValue = $resValue;
		}
		
		if($minusToBracket && $neg)
		{
			$resValue = "(".$resValue.")";
			$neg = "";
		}
		
		if($minusLess == true)
		{
			$neg = "";
		}

		if(count($arr_value) == 1)
			$resValue = $neg.$resValue;
		else
			$resValue = $neg.$resValue.",".$arr_value[1];
		
		if(substr($resValue, 0, 1) == ',')
			$resValue = '0'.$resValue;	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

		return $resValue;
	}

	public static function getNameValueYaTidak($number) {
		$number = (int)$number;
		$arrValue = array("0"=>"Tidak", "1"=>"Ya");
		return $arrValue[$number];
	}

	public static function getNameValueKategori($number) {
		$number = (int)$number;
		$arrValue = array("1"=>"Sangat Baik", "2"=>"Baik", "3"=>"Cukup", "4"=>"Kurang");
		return $arrValue[$number];
	}	

	public static function getNameValue($number) {
		$number = (int)$number;
		$arrValue = array("0"=>"Tidak", "1"=>"Ya");
		return $arrValue[$number];
	}	

	public static function getNameValueAktif($number) {
		$number = (int)$number;
		$arrValue = array("0"=>"Tidak Aktif", "1"=>"Aktif");
		return $arrValue[$number];
	}

	public static function getNameValidasi($number) {
		$number = (int)$number;
		$arrValue = array("0"=>"Menunggu Konfirmasi","1"=>"Disetujui", "2"=>"Ditolak");
		return $arrValue[$number];
	}	

	public static function getNameInputOutput($char) {
		$arrValue = array("I"=>"Datang", "O"=>"Pulang");
		return $arrValue[$char];
	}		
		
	public static function dotToComma($varId)
	{
		$newId = str_replace(".", ",", $varId);	
		return $newId;
	}

	public static function CommaToQuery($varId)
	{
		$newId = str_replace(",", "','", $varId);	
		return $newId;
	}


	public static function CommaToDot($varId)
	{
		$newId = str_replace(",", ".", $varId);	
		return $newId;
	}

	public static function dotToNo($varId)
	{
		$newId = str_replace(".", "", $varId);	
		$newId = str_replace(",", ".", $newId);	
		return $newId;
	}
	public static function CommaToNo($varId)
	{
		$newId = str_replace(",", "", $varId);	
		return $newId;
	}

	public static function CrashToNo($varId)
	{
		$newId = str_replace("#", "", $varId);	
		return $newId;
	}

	public static function StarToNo($varId)
	{
		$newId = str_replace("* ", "", $varId);	
		return $newId;
	}

	public static function NullDotToNo($varId)
	{
		$newId = str_replace(".00", "", $varId);
		return $newId;
	}

	public static function ExcelToNo($varId)
	{
		$newId = NullDotToNo($varId);
		$newId = StarToNo($newId);
		return $newId;
	}

	public static function ValToNo($varId)
	{
		$newId = NullDotToNo($varId);
		$newId = CommaToNo($newId);
		$newId = StarToNo($newId);
		return $newId;
	}

	public static function ValToNull($varId)
	{
		if($varId == '')
			return 0;
		else
			return $varId;
	}

	public static function ValToNullMenit($varId)
	{
		if($varId == '')
			return 00;
		else
			return $varId;
	}

	public static function ValToNullDB($varId)
	{
		if(empty($varId) || strtolower($varId) == 'null')
			return '';
		else
			return $varId;
		// return "'".$varId."'";
	}

	public static function setQuote($var, $status='')
	{	
		if($status == 1)
			$tmp= str_replace("\'", "''", $var);
		else
			$tmp= str_replace("'", "''", $var);
		return $tmp;
	}

	// fungsi untuk generate nol untuk melengkapi digit

	public static function generateZero($varId, $digitGroup, $digitCompletor = "0")
	{
		$newId = "";
		
		$lengthZero = $digitGroup - strlen($varId);
		
		for($i = 0; $i < $lengthZero; $i++)
		{
			$newId .= $digitCompletor;
		}
		
		$newId = $newId.$varId;
		
		return $newId;
	}

	// truncate text into desired word counts.
	// to support dropDirtyHtml public static function, include default.func.php
	public static function truncate($text, $limit, $dropDirtyHtml=true)
	{
		$tmp_truncate = array();
		$text = str_replace("&nbsp;", " ", $text);
		$tmp = explode(" ", $text);
		
		for($i = 0; $i <= $limit; $i++)		//truncate how many words?
		{
			$tmp_truncate[$i] = $tmp[$i];
		}
		
		$truncated = implode(" ", $tmp_truncate);
		
		if ($dropDirtyHtml == true and function_exists('dropAllHtml'))
			return ($truncated);
		else
			return $truncated;
	}

	public static function arrayMultiCount($array, $field_name, $search)
	{
		$summary = 0;
		for($i = 0; $i < count($array); $i++)
		{
			if($array[$i][$field_name] == $search)
				$summary += 1;
		}
		return $summary;
	}

	public static function getValueArray($var)
	{
		//$tmp = "";
		for($i=0;$i<count($var);$i++)
		{			
			if($i == 0)
				$tmp .= $var[$i];
			else
				$tmp .= ",".$var[$i];
		}
		
		return $tmp;
	}

	public static function getValueArrayMonth($var)
	{
		//$tmp = "";
		for($i=0;$i<count($var);$i++)
		{			
			if($i == 0)
				$tmp .= "'".$var[$i]."'";
			else
				$tmp .= ", '".$var[$i]."'";
		}
		
		return $tmp;
	}

	public static function getColoms($var)
	{
		$tmp = "";
		if($var == 0)	$tmp = 'D';
		elseif($var == 1)	$tmp = 'E';
		elseif($var == 2)	$tmp = 'F';
		elseif($var == 3)	$tmp = 'G';
		elseif($var == 4)	$tmp = 'H';
		elseif($var == 5)	$tmp = 'I';
		elseif($var == 6)	$tmp = 'J';
		elseif($var == 7)	$tmp = 'K';
		
		return $tmp;
	}

	public static function setNULL($var)
	{	
		if($var == '')
			$tmp = 'NULL';
		else
			$tmp = $var;
		
		return $tmp;
	}

	public static function setNULLModif($var)
	{	
		if($var == '')
			$tmp = 'NULL';
		else
			$tmp = "'".$var."'";
		
		return $tmp;
	}

	public static function setVal_0($var)
	{	
		if($var == '')
			$tmp = '0';
		else
			$tmp = $var;
		
		return $tmp;
	}

	public static function get_null_10($varId)
	{
		if($varId == '') return '';
		if($varId < 10)	$temp= '0'.$varId;
		else			$temp= $varId;
				
		return $temp;
	}

	public static function _ip( )
	{
	    return ( preg_match( "/^([d]{1,3}).([d]{1,3}).([d]{1,3}).([d]{1,3})$/", $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'] );
	}



	public static function toNumber($varId)
	{	
		return (float)$varId;
	}

	public static function searchWordDelimeter($varSource, $varSearch, $varDelimeter=",")
	{

		$arrSource = explode($varDelimeter, $varSource);
		
		for($i=0; $i<count($arrSource);$i++)
		{
			if(trim($arrSource[$i]) == $varSearch)
				return true;
		}
		
		return false;
	}

	public static function getZodiac($day,$month){
		if(($month==1 && $day>20)||($month==2 && $day<20)){
		$mysign = "Aquarius";
		}
		if(($month==2 && $day>18 )||($month==3 && $day<21)){
		$mysign = "Pisces";
		}
		if(($month==3 && $day>20)||($month==4 && $day<21)){
		$mysign = "Aries";
		}
		if(($month==4 && $day>20)||($month==5 && $day<22)){
		$mysign = "Taurus";
		}
		if(($month==5 && $day>21)||($month==6 && $day<22)){
		$mysign = "Gemini";
		}
		if(($month==6 && $day>21)||($month==7 && $day<24)){
		$mysign = "Cancer";
		}
		if(($month==7 && $day>23)||($month==8 && $day<24)){
		$mysign = "Leo";
		}
		if(($month==8 && $day>23)||($month==9 && $day<24)){
		$mysign = "Virgo";
		}
		if(($month==9 && $day>23)||($month==10 && $day<24)){
		$mysign = "Libra";
		}
		if(($month==10 && $day>23)||($month==11 && $day<23)){
		$mysign = "Scorpio";
		}
		if(($month==11 && $day>22)||($month==12 && $day<23)){
		$mysign = "Sagitarius";
		}
		if(($month==12 && $day>22)||($month==1 && $day<21)){
		$mysign = "Capricorn";
		}
		return $mysign;
	}

	public static function getValueANDOperator($var)
	{
		$tmp = ' AND ';
		
		return $tmp;
	}

	public static function getValueKoma($var)
	{
		if($var == '')
			$tmp = '';
		else
			$tmp = ',';	
		
		return $tmp;
	}

	public static function import_format($val)
	{
		if($val == ":02")
		{
			$temp= str_replace(":02","24:00",$val);
		}
		else
		{	
			$temp="";
			if($val == "[hh]:mm" || $val == "[h]:mm"){}
			else
				$temp= $val;
		}
		return $temp;
		//return $val;
	}

	public static function kekata($x) 
	{
		$x = abs($x);
		$angka = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($x <12) 
		{
			$temp = " ". $angka[$x];
		} 
		else if ($x <20) 
		{
			$temp = kekata($x - 10). " belas";
		} 
		else if ($x <100) 
		{
			$temp = kekata($x/10)." puluh". kekata($x % 10);
		} 
		else if ($x <200) 
		{
			$temp = " seratus" . kekata($x - 100);
		} 
		else if ($x <1000) 
		{
			$temp = kekata($x/100) . " ratus" . kekata($x % 100);
		} 
		else if ($x <2000) 
		{
			$temp = " seribu" . kekata($x - 1000);
		} 
		else if ($x <1000000) 
		{
			$temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
		} 
		else if ($x <1000000000) 
		{
			$temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
		} 
		else if ($x <1000000000000) 
		{
			$temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
		} 
		else if ($x <1000000000000000) 
		{
			$temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
		}      
		
		return $temp;
	}

	public static function terbilang($x, $style=4) 
	{
		if($x < 0) 
		{
			$hasil = "minus ". trim(kekata($x));
		} 
		else 
		{
			$hasil = trim(kekata($x));
		}      
		switch ($style) 
		{
			case 1:
				$hasil = strtoupper($hasil);
				break;
			case 2:
				$hasil = strtolower($hasil);
				break;
			case 3:
				$hasil = ucwords($hasil);
				break;
			default:
				$hasil = ucfirst($hasil);
				break;
		}      
		return $hasil;
	}

	public static function romanic_number($integer, $upcase = true)
	{
	    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
	    $return = '';
	    while($integer > 0)
	    {
	        foreach($table as $rom=>$arb)
	        {
	            if($integer >= $arb)
	            {
	                $integer -= $arb;
	                $return .= $rom;
	                break;
	            }
	        }
	    }

	    return $return;
	}

	public static function getExe($tipe)
	{
		switch ($tipe) {
		  case "application/pdf": $ctype="pdf"; break;
		  case "application/octet-stream": $ctype="exe"; break;
		  case "application/zip": $ctype="zip"; break;
		  case "application/msword": $ctype="doc"; break;
		  case "application/vnd.ms-excel": $ctype="xls"; break;
		  case "application/vnd.ms-powerpoint": $ctype="ppt"; break;
		  case "image/gif": $ctype="gif"; break;
		  case "image/png": $ctype="png"; break;
		  case "image/jpeg": $ctype="jpeg"; break;
		  case "image/jpg": $ctype="jpg"; break;
		  case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet": $ctype="xlsx"; break;
		  case "application/vnd.openxmlformats-officedocument.wordprocessingml.document": $ctype="docx"; break;
		  default: $ctype="application/force-download";
		} 
		
		return $ctype;
	} 

	public static function getExtension($varSource)
	{
		$temp = explode(".", $varSource);
		return end($temp);
	}


	public static function coalesce($varSource, $varReplace)
	{
		if($varSource == "")
			return $varReplace;
			
		return $varSource;
	}

	public static function unserialized($serialized)
	{
		$arrSerialized = str_replace('@', '"', $serialized);			
		return unserialize($arrSerialized);
	}



	public static function translate($id, $en)
	{
		if($_SESSION["lang"] == "en")
			return $en;	
		else
			return $id;
	}

	public static function getBahasa()
	{
		if($_SESSION["lang"] == "en")
			return "en";	
		else
			return "";
	}

	public static function getTerbilang($x)
	{
	  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	  if ($x < 12)
	    return " " . $abil[$x];
	  elseif ($x < 20)
	    return getTerbilang($x - 10) . " belas";
	  elseif ($x < 100)
	    return getTerbilang($x / 10) . " puluh" . getTerbilang($x % 10);
	  elseif ($x < 200)
	    return " seratus" . getTerbilang($x - 100);
	  elseif ($x < 1000)
	    return getTerbilang($x / 100) . " ratus" . getTerbilang($x % 100);
	  elseif ($x < 2000)
	    return " seribu" . getTerbilang($x - 1000);
	  elseif ($x < 1000000)
	    return getTerbilang($x / 1000) . " ribu" . getTerbilang($x % 1000);
	  elseif ($x < 1000000000)
	    return getTerbilang($x / 1000000) . " juta" . getTerbilang($x % 1000000);
	}


	public static function renameFile($varSource)
	{
		$varSource = str_replace(" ", "_",$varSource);
		$varSource = str_replace("'", "", $varSource);
		return $varSource;
	}

	public static function getColumnExcel($var)
	{
		$var = strtoupper($var);
		if($var == "")
			return 0;
			
		if($var == "A")	$tmp = 1;
		elseif($var == "B")	$tmp = 2;
		elseif($var == "C")	$tmp = 3;
		elseif($var == "D")	$tmp = 4;
		elseif($var == "E")	$tmp = 5;
		elseif($var == "F")	$tmp = 6;
		elseif($var == "G")	$tmp = 7;
		elseif($var == "H")	$tmp = 8;
		elseif($var == "I")	$tmp = 9;
		elseif($var == "J")	$tmp = 10;
		elseif($var == "K")	$tmp = 11;
		elseif($var == "L")	$tmp = 12;
		elseif($var == "M")	$tmp = 13;
		elseif($var == "N")	$tmp = 14;
		elseif($var == "0")	$tmp = 15;
		elseif($var == "P")	$tmp = 16;
		elseif($var == "Q")	$tmp = 17;
		elseif($var == "R")	$tmp = 18;
		elseif($var == "S")	$tmp = 19;
		elseif($var == "T")	$tmp = 20;
		
		return $tmp;
	}

	public static function terbilang_en($number) {
	    
	    $hyphen      = '-';
	    $conjunction = ' and ';
	    $separator   = ', ';
	    $negative    = 'negative ';
	    $decimal     = ' point ';
	    $dictionary  = array(
	        0                   => 'zero',
	        1                   => 'one',
	        2                   => 'two',
	        3                   => 'three',
	        4                   => 'four',
	        5                   => 'five',
	        6                   => 'six',
	        7                   => 'seven',
	        8                   => 'eight',
	        9                   => 'nine',
	        10                  => 'ten',
	        11                  => 'eleven',
	        12                  => 'twelve',
	        13                  => 'thirteen',
	        14                  => 'fourteen',
	        15                  => 'fifteen',
	        16                  => 'sixteen',
	        17                  => 'seventeen',
	        18                  => 'eighteen',
	        19                  => 'nineteen',
	        20                  => 'twenty',
	        30                  => 'thirty',
	        40                  => 'fourty',
	        50                  => 'fifty',
	        60                  => 'sixty',
	        70                  => 'seventy',
	        80                  => 'eighty',
	        90                  => 'ninety',
	        100                 => 'hundred',
	        1000                => 'thousand',
	        1000000             => 'million',
	        1000000000          => 'billion',
	        1000000000000       => 'trillion',
	        1000000000000000    => 'quadrillion',
	        1000000000000000000 => 'quintillion'
	    );
	    
	    if (!is_numeric($number)) {
	        return false;
	    }
	    
	    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
	        // overflow
	        trigger_error(
	            'terbilang_en only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
	            E_USER_WARNING
	        );
	        return false;
	    }

	    if ($number < 0) {
	        return $negative . terbilang_en(abs($number));
	    }
	    
	    $string = $fraction = null;
	    
	    if (strpos($number, '.') !== false) {
	        list($number, $fraction) = explode('.', $number);
	    }
	    
	    switch (true) {
	        case $number < 21:
	            $string = $dictionary[$number];
	            break;
	        case $number < 100:
	            $tens   = ((int) ($number / 10)) * 10;
	            $units  = $number % 10;
	            $string = $dictionary[$tens];
	            if ($units) {
	                $string .= $hyphen . $dictionary[$units];
	            }
	            break;
	        case $number < 1000:
	            $hundreds  = $number / 100;
	            $remainder = $number % 100;
	            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
	            if ($remainder) {
	                $string .= $conjunction . terbilang_en($remainder);
	            }
	            break;
	        default:
	            $baseUnit = pow(1000, floor(log($number, 1000)));
	            $numBaseUnits = (int) ($number / $baseUnit);
	            $remainder = $number % $baseUnit;
	            $string = terbilang_en($numBaseUnits) . ' ' . $dictionary[$baseUnit];
	            if ($remainder) {
	                $string .= $remainder < 100 ? $conjunction : $separator;
	                $string .= terbilang_en($remainder);
	            }
	            break;
	    }
	    
	    if (null !== $fraction && is_numeric($fraction)) {
	        $string .= $decimal;
	        $words = array();
	        foreach (str_split((string) $fraction) as $number) {
	            $words[] = $dictionary[$number];
	        }
	        $string .= implode(' ', $words);
	    }
	    
	    return $string;
	}

	public static function decimalNumber($num2)
	{
		if(strpos($num2, '.'))
			return number_format($num2, 2, '.', '');	
		
		return $num2;
	}


	public static function json_response($code = 200, $message = null)
	{
	    // clear the old headers
	    header_remove();
	    // set the actual code
	    http_response_code($code);
	    // set the header to make sure cache is forced
	    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
	    // treat this as json
	    header('Content-Type: application/json');
	    $status = array(
	        200 => '200 OK',
	        400 => '400 Bad Request',
	        422 => 'Unprocessable Entity',
	        500 => '500 Internal Server Error'
	        );
	    // ok, validation error, or failure
	    header('Status: '.$status[$code]);
	    // return the encoded json
	    return json_encode(array(
	        'status' => $code < 300, // success or not?
	        'message' => $message
	        ));
	}



	public static function isStrContain($string, $keyword)
	{
		if (empty($string) || empty($keyword)) return false;
		$keyword_first_char = $keyword[0];
		$keyword_length = strlen($keyword);
		$string_length = strlen($string);
		
		// case 1
		if ($string_length < $keyword_length) return false;
		
		// case 2
		if ($string_length == $keyword_length) {
		  if ($string == $keyword) return true;
		  else return false;
		}
		
		// case 3
		if ($keyword_length == 1) {
		  for ($i = 0; $i < $string_length; $i++) {
		
			// Check if keyword's first char == string's first char
			if ($keyword_first_char == $string[$i]) {
			  return true;
			}
		  }
		}
		
		// case 4
		if ($keyword_length > 1) {
		  for ($i = 0; $i < $string_length; $i++) {
			/*
			the remaining part of the string is equal or greater than the keyword
			*/
			if (($string_length + 1 - $i) >= $keyword_length) {
		
			  // Check if keyword's first char == string's first char
			  if ($keyword_first_char == $string[$i]) {
				$match = 1;
				for ($j = 1; $j < $keyword_length; $j++) {
				  if (($i + $j < $string_length) && $keyword[$j] == $string[$i + $j]) {
					$match++;
				  }
				  else {
					return false;
				  }
				}
		
				if ($match == $keyword_length) {
				  return true;
				}
		
				// end if first match found
			  }
		
			  // end if remaining part
			}
			else {
			  return false;
			}
		
			// end for loop
		  }
		
		  // end case4
		}
		
		return false;
	}

	public static function ucAddress($str) {

	    // first lowercase all and use the default ucwords
	    $str = ucwords(strtolower($str));

	    // let's fix the default ucwords...
	    // uppercase letters after house number (was lowercased by the strtolower above)
	    $str = mb_eregi_replace('\b([0-9]{1,4}[a-z]{1,2})\b', "strtoupper('\\1')", $str, 'e');

	    // the same for roman numerals
	    $str = mb_eregi_replace('\bM{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})\b', "strtoupper('\\0')", $str, 'e');
		
		$str= str_replace("Sdn", "SDN", $str);
		$str= str_replace("Tk", "TK", $str);
		$str= str_replace("Smp", "SMP", $str);
		$str= str_replace("SMPn", "SMPN", $str);
		$str= str_replace("Sma", "SMA", $str);
		$str= str_replace("SMAn", "SMAN", $str);
		$str= str_replace("Smk", "SMK", $str);
		
		$str= str_replace("Rsud", "RSUD", $str);
		$str= str_replace("Dr", "dr", $str);
		$str= str_replace("Dprd", "DPRD", $str);
		
		$str= str_replace("Uptd", "UPTD", $str);
		$str= str_replace("Dan", "dan", $str);
	    return $str;
	}



	public static function setLogInfo($mode, $namaUser, $namaTable)
	{
		if($mode == "insert")
			return $namaUser." telah menambah ".getFipNama($namaTable).$statement." pada tanggal ".date('d-m-Y H:i:s');
		elseif($mode == "update")
			return $namaUser." telah merubah ".getFipNama($namaTable).$statement." pada tanggal ".date('d-m-Y H:i:s');
		elseif($mode == "delete")
			return $namaUser." telah menghapus ".getFipNama($namaTable).$statement." pada tanggal ".date('d-m-Y H:i:s');
	}

	public static function getColomsNew($var)
	{
		$tmp = "";
		if($var == 1)	$tmp = 'A';
		elseif($var == 2)	$tmp = 'B';
		elseif($var == 3)	$tmp = 'C';
		elseif($var == 4)	$tmp = 'D';
		elseif($var == 5)	$tmp = 'E';
		elseif($var == 6)	$tmp = 'F';
		elseif($var == 7)	$tmp = 'G';
		elseif($var == 8)	$tmp = 'H';
		elseif($var == 9)	$tmp = 'I';
		elseif($var == 10)	$tmp = 'J';
		elseif($var == 11)	$tmp = 'K';
		elseif($var == 12)	$tmp = 'L';
		elseif($var == 13)	$tmp = 'M';
		elseif($var == 14)	$tmp = 'N';
		elseif($var == 15)	$tmp = 'O';
		elseif($var == 16)	$tmp = 'P';
		elseif($var == 17)	$tmp = 'Q';
		elseif($var == 18)	$tmp = 'R';
		elseif($var == 19)	$tmp = 'S';
		elseif($var == 20)	$tmp = 'T';
		elseif($var == 21)	$tmp = 'U';
		elseif($var == 22)	$tmp = 'V';
		elseif($var == 23)	$tmp = 'W';
		elseif($var == 24)	$tmp = 'X';
		elseif($var == 25)	$tmp = 'Y';
		elseif($var == 26)	$tmp = 'Z';
		elseif($var == 27)	$tmp = 'AA';
		elseif($var == 28)	$tmp = 'AB';
		elseif($var == 29)	$tmp = 'AC';
		elseif($var == 30)	$tmp = 'AD';
		elseif($var == 31)	$tmp = 'AE';
		elseif($var == 32)	$tmp = 'AF';
		elseif($var == 33)	$tmp = 'AG';
		elseif($var == 34)	$tmp = 'AH';
		elseif($var == 35)	$tmp = 'AI';
		elseif($var == 36)	$tmp = 'AJ';
		elseif($var == 37)	$tmp = 'AK';
		elseif($var == 38)	$tmp = 'AL';
		elseif($var == 39)	$tmp = 'AM';
		elseif($var == 40)	$tmp = 'AN';
		elseif($var == 41)	$tmp = 'AO';
		elseif($var == 42)	$tmp = 'AP';
		elseif($var == 43)	$tmp = 'AQ';
		elseif($var == 44)	$tmp = 'AR';
		elseif($var == 45)	$tmp = 'AS';
		elseif($var == 46)	$tmp = 'AT';
		elseif($var == 47)	$tmp = 'AU';
		elseif($var == 48)	$tmp = 'AV';
		elseif($var == 49)	$tmp = 'AW';
		elseif($var == 50)	$tmp = 'AX';
		elseif($var == 51)	$tmp = 'AY';
		elseif($var == 52)	$tmp = 'AZ';
		elseif($var == 53)	$tmp = 'BA';
		elseif($var == 54)	$tmp = 'BB';
		elseif($var == 55)	$tmp = 'BC';
		elseif($var == 56)	$tmp = 'BD';
		
		return $tmp;
	}

	public static function checkFile($tipe,$jenis)
	{
		$acceptable = array();

		if($jenis==1)
		{
			$acceptable = array(
				'image/jpeg'
				,'image/png'
			);
		}
		else if($jenis==2)
		{
			$acceptable = array(
				'application/pdf'
			);
		}
		else if($jenis==3)
		{
			$acceptable = array(
				'application/pdf'
				,'application/msword'
				,'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
				,'application/vnd.ms-excel'
				,'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
				,'image/jpeg'
				,'image/png'
				,'application/vnd.ms-powerpoint'
				,'application/vnd.openxmlformats-officedocument.presentationml.presentation'
			);
		}
		
		if((in_array($tipe, $acceptable))) {
			return true;
		}
		else
		{
			return false;
		}
	}

	public static function checkSizeFile($sizefile,$maxsize)
	{
		if($sizefile > $maxsize)
		{
			return false;
		}
		else
		{
			return true;
		}	
	}

	public static function konvertpangkat($id,$kode)
	{
		$pangkat="";
		$last="";
		if($id < 20)
		{
			$last=strtoupper(substr($kode, -1));
			$pangkat="1".$last;
		}
		elseif(($id > 20) && ($id < 30))
		{
			$last=strtoupper(substr($kode, -1));
			$pangkat="2".$last;
				
		}
		elseif(($id > 30) && ($id < 35))
		{
			$last=strtoupper(substr($kode, -1));
			$pangkat="3".$last;
				
		}
		elseif(($id > 35) && ($id < 46))
		{
			$last=strtoupper(substr($kode, -1));
			$pangkat="4".$last;
				
		}

		return $pangkat;
	}


	public static function getmultiseparator($vreturn)
	{
		$vreturn= str_replace("'", "", $vreturn);
		$vreturn= explode(",", $vreturn);
		return $vreturn;
	}


	public static function array_change_key_case_recursive_upper($arr)
	{
		return array_map(function($item){
			if(is_array($item))
				$item = StringFunc::array_change_key_case_recursive_upper($item);
			return $item;
		},array_change_key_case($arr,CASE_UPPER));
	}

	public static function array_change_key_case_recursive_lower($arr)
	{
		return array_map(function($item){
			if(is_array($item))
				$item = StringFunc::array_change_key_case_recursive_lower($item);
			return $item;
		},array_change_key_case($arr,CASE_LOWER));
	}

	public static function stdToArray($std,$case)
	{
		$array= json_decode(json_encode($std), true);
		if($case==1)
		{
			$result=StringFunc::array_change_key_case_recursive_upper($array);
		}
		else
		{
			$result=StringFunc::array_change_key_case_recursive_lower($array);
		}
		
		return $result;
	}

	public static function arrparam($key, $arrparam)
	{
		return array_key_exists($key, $arrparam) ? $arrparam[$key] : null;
	}

	public static function infoiconlink($atttipe)
	{
		$arrexcept= [];
		$arrexcept= array("pdf");
		if(in_array(strtolower($atttipe), $arrexcept))
		{
			return "fa-file-pdf-o";
		}

		$arrexcept= array("doc", "docx");
		if(in_array(strtolower($atttipe), $arrexcept))
		{
			return "fa-file-word-o";
		}

		$arrexcept= array("xlsx", "xls");
		if(in_array(strtolower($atttipe), $arrexcept))
		{
			return "fa-file-excel-o";
		}

		$arrexcept= array("ppt", "pptx");
		if(in_array(strtolower($atttipe), $arrexcept))
		{
			return "fa-file-powerpoint-o";
		}
		
		$arrexcept= array("jpg", "jpeg", "png", "gif");
		if(in_array(strtolower($atttipe), $arrexcept))
		{
			return "fa-file-image-o";
		}

		return "fa-file-o";
	}

	public static function infonomor($nomorpasal, $reqJenisNaskah)
	{
		if($reqJenisNaskah == "17" || $reqJenisNaskah == "19" || $reqJenisNaskah == "20")
			$arrdata= array("", "Pertama", "Kedua", "Ketiga", "Keempat", "Kelima", "Keenam", "Ketujuh", "Kedelapan", "Kesembilan", "Kesepuluh", "Kesebelas", "Keduabelas", "Ketigabelas", "Keempatbelas", "Kelimabelas", "Keenambelas", "Ketujuhbelas", "Kedelapanbelas", "Kesembilanbelas", "Keduapuluh", "Keduapuluhsatu", "Keduapuluhdua", "Keduapuluhtiga", "Keduapuluhempat", "Keduapuluhlima");
		else if($reqJenisNaskah == "8")
			$arrdata= array("", "BAB I", "BAB II", "BAB III", "BAB IV", "BAB V", "BAB VI", "BAB VII", "BAB VIII", "BAB IX", "BAB X", "BAB XI", "BAB XII", "BAB XIII", "BAB XIV", "BAB XV", "BAB XVI", "BAB XVII", "BAB XVIII", "BAB XIX", "BAB XX", "BAB XXI", "BAB XXII", "BAB XXIII", "BAB XXIV", "BAB XXV");
		else if($reqJenisNaskah == "9")
			$arrdata= array("", "PASAL 1", "PASAL 2", "PASAL 3", "PASAL 4", "PASAL 5", "PASAL 6", "PASAL 7", "PASAL 8", "PASAL 9", "PASAL 10", "PASAL 11", "PASAL 12", "PASAL 13", "PASAL 14", "PASAL 15", "PASAL 16", "PASAL 17", "PASAL 18", "PASAL 19", "PASAL 20", "PASAL 21", "PASAL 22", "PASAL 23", "PASAL 24", "PASAL 25");
		else
			$arrdata= [];

		if(!empty($arrdata[$nomorpasal]))
			return $arrdata[$nomorpasal];
		else
			return "-";
	}

	public static function getconcatseparator($var, $vadd, $separator=",")
	{
		$vreturn= "";
		if(empty($var))
			$vreturn = $vadd;
		else
		{
			$vreturn = $var.$separator.$vadd;
		}

		return $vreturn;
	}

	public static function datatipemutasi()
	{
		$arrdata= array(
			array("val"=>"1", "label"=>"Mutasi Tukar Jabatan")
			, array("val"=>"2", "label"=>"Mutasi")
			, array("val"=>"3", "label"=>"Pensiun")
		);
		return $arrdata;
	}

	public static function infotipemutasi($reqTipe)
	{
		$arrdata= StringFunc::datatipemutasi();
		$arrayKey= StringFunc::in_array_column($reqTipe, "val", $arrdata);
		if(!empty($arrayKey))
		{
			$index_data= $arrayKey[0];
			return $arrdata[$index_data]["label"];
		}
		else
		{
			return "";
		}
	}

	public static function combojabatan($arrparam)
	{
		$reqMode= StringFunc::arrparam("reqMode", $arrparam);
		if($reqMode == "baru" || $reqMode == "jabatan_baru_cari")
		{
			$i = 0;
			$arr_json[$i]['id']= "";
			$arr_json[$i]['text']= "Jabatan Kosong";
			$i++;

			$arr_json[$i]['id']= "baru";
			$arr_json[$i]['text']= "Jabatan Baru";
			$i++;
		}
		else
		{
			$i = 0;
			$arr_json[$i]['id']= "";
			$arr_json[$i]['text']= "Semua";
			$i++;

			$arr_json[$i]['id']= "kosong";
			$arr_json[$i]['text']= "Jabatan Kosong";
			$i++;	
		}

		return json_encode($arr_json);
	}

	public static function infokelompok()
	{
		$arrField= array(
			array("id"=>"DIREKSI", "nama"=>"Direksi")
			, array("id"=>"GM", "nama"=>"General Manager")
			, array("id"=>"VP", "nama"=>"VP")
			, array("id"=>"SGM", "nama"=>"Senior General Manager")
			, array("id"=>"SUPERVISI", "nama"=>"Supervisor")
			, array("id"=>"MAN", "nama"=>"Manager")
			, array("id"=>"ASSISTANT", "nama"=>"Asisstant")
			, array("id"=>"KKM", "nama"=>"KKM")
			, array("id"=>"NAH", "nama"=>"Nahkoda")
			, array("id"=>"KARYAWAN", "nama"=>"Karyawan")
		);
		return $arrField;
	}

	public static function getJenisNaskah($reqJenisNaskahId)
	{
		$reqJenisNaskahNamaFile= "";
		if($reqJenisNaskahId == "1")
            $reqJenisNaskahNamaFile = "surat_masuk_manual_add";
        else if($reqJenisNaskahId == "2")
            $reqJenisNaskahNamaFile = "nota_dinas_add";
        else if($reqJenisNaskahId == "13")
            $reqJenisNaskahNamaFile = "surat_edaran_add";
        else if($reqJenisNaskahId == "15")
            $reqJenisNaskahNamaFile = "surat_keluar_add";
        else if($reqJenisNaskahId == "18")
            $reqJenisNaskahNamaFile = "surat_perintah_add";
        else if($reqJenisNaskahId == "17")
            $reqJenisNaskahNamaFile = "surat_keputusan_direksi_add";
        else if($reqJenisNaskahId == "8")
            $reqJenisNaskahNamaFile = "keputusan_direksi_add";
        else if($reqJenisNaskahId == "19")
            $reqJenisNaskahNamaFile = "instruksi_direksi_add";
        else if($reqJenisNaskahId == "20")
            $reqJenisNaskahNamaFile = "petikan_skd_add";

        return $reqJenisNaskahNamaFile;
    }
}
?>