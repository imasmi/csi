<?php
namespace web\php;

class dates{
	public function change($str){
		return date("Y-m-d", strtotime($str));
	}
	
	public function set($str){
		if($str == "0000-00-00 00:00:00"){
			return false;
		} else {
			return true;
		}
	}
	
	public function _($str){
		if(empty($str)){
			return false;
		} elseif(strlen($str) > 10){
			return date("d.m.Y H:i", strtotime($str));
		} else {
			return date("d.m.Y", strtotime($str));
		}
	}
}

$date = new dates;	
?>