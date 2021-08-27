<?php
namespace web\php;

class csi{
	public function __construct(){
		global $Core;
		$this->Core = $Core;
		global $Query;
		$this->Query = $Query;
		global $Form;
		$this->Form = $Form;
		global $Page;
		$this->Page = $Page;
		global $Note;
		$this->Note = $Note;
	}		
	
	public function createTXT($file){
		header('Content-Type: text/plain');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Content-Length: ' . filesize($file));
		ob_clean();
        	flush();
		readfile($file);
		exit;
	}
}

$csi = new csi;
?>
