<?php 
require_once \system\Core::doc_root() . '/composer/vendor/autoload.php';
require_once(\system\Core::doc_root() . '/system/module/File/php/FileAPP.php');
$FileAPP = new \module\File\FileAPP;
include_once(\system\Core::doc_root() . '/plugin/Document/php/Barcode.php');
$Barcode = new \plugin\Document\Barcode();

$print_dir = $_POST["dir"] . "/print/";
if ( file_exists($print_dir) ) { $FileAPP->delete_dir($print_dir); }

for($a = 1; $a < $_POST["rows"]; ++$a){
    if(!isset($_POST["file_" . $a])){continue;} //Check if the row is removed
    $file = iconv ( "UTF-8", "windows-1251" , $_POST["dir"] . "/" . $_POST["file_" . $a]);
    $print = iconv ( "UTF-8", "windows-1251" , $print_dir . $_POST["file_" . $a]);
    if(!is_dir($print_dir)){mkdir($print_dir);}
      
    //echo $_POST["file_" . $a] . " -> " . $_POST["barcode_" . $a] . '<br>';
    $barcode = $PDO->query("SELECT * FROM document WHERE barcode='" . $_POST["barcode_" . $a] . "'")->fetch();
    $case = $PDO->query("SELECT * FROM caser WHERE id='" . $barcode["case_id"] . "'")->fetch();


    $content = file_get_contents($file);
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML('<div style="position: fixed; top: -60px; right: -20px;">' . $Barcode->html_return($barcode) . '</div>' . $content);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;
    $new_name = str_replace("html", "pdf", $print);
    $mpdf->Output($new_name, "F");
    echo $new_name . '<br>';
  }
?>
