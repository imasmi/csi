<?php
namespace web;

class csi{	
	public static function createTXT($file){
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
?>
