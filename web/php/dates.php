<?php
namespace web;

class dates{
	public static $months = ["Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември"];

	public static function change($str){
		return date("Y-m-d", strtotime($str));
	}
	
	public static function set($str){
		if($str == "0000-00-00 00:00:00"){
			return false;
		} else {
			return true;
		}
	}
	
	public static function _($str){
		if(empty($str)){
			return false;
		} elseif(strlen($str) > 10){
			return date("d.m.Y H:i", strtotime($str));
		} else {
			return date("d.m.Y", strtotime($str));
		}
	}
}	
?>