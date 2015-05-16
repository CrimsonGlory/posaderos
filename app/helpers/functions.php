<?php
/*
 * Parse the phone from 4xxx-xxx or 15-xxxx-xxxx 
 * to +54 9 11 xxxx xxxx (for celphones) 
 * or +54 11 xxxx xxxx 
 */
function parse_phone($phone){
	if(is_array($phone) && count($phone)==1)
		$phone=array_values($phone)[0];
	if($phone==null)
		return ;
	$clean=preg_replace("/[^0-9]/","",$phone);
	if(strlen($clean)==8 && substr($clean,0,1)=="4" ){ //linea fija 4xxx-xxxx
		return phone_format("11".$clean,'AR');
	}
	if(strlen($clean)==10){ //celular
		if(substr($clean,0,2)=="15") //15-xxxx-xxxx
			return phone_format("911".substr($clean,2),'AR');
		if(substr($clean,0,2)=="11") //11-xxxx-xxxx
			return  phone_format("9".$clean,'AR');
	}
	if(strlen($clean)==12 && substr($clean,0,4)=="5411" ){
		return phone_format($clean,'AR'); //54 11 xxxx xxxx
	}
	if(strlen($clean)==13 && substr($clean,0,5)=="54911"){
		return phone_format($clean,'AR');
	}
	return $clean;
}

?>
