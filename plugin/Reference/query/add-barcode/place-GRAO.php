<?php 
require_once $Core->doc_root() . '/composer/vendor/autoload.php';
$Barcode = new \plugin\Document\php\Barcode();
require_once($Core->doc_root() . '/system/module/File/php/FileAPP.php');
$print_dir = $_POST["dir"] . "/print/";
$FileAPP = new \system\module\File\php\FileAPP;
$FileAPP->delete_dir($print_dir);

for($a = 1; $a < $_POST["rows"]; ++$a){
    if(!isset($_POST["file_" . $a])){continue;} //Check if the row is removed
    $file = iconv ( "UTF-8", "windows-1251" , $_POST["dir"] . "/" . $_POST["file_" . $a]);
    $print = iconv ( "UTF-8", "windows-1251" , $print_dir . $_POST["file_" . $a]);
    if(!is_dir($print_dir)){mkdir($print_dir);}
      
    //echo $_POST["file_" . $a] . " -> " . $_POST["barcode_" . $a] . '<br>';
    $barcode = $Query->select($_POST["barcode_" . $a], "barcode", "document");
    $case = $Query->select($barcode["case_id"], "id", "caser");
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
