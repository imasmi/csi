<?php
require_once $Core->doc_root() . '/composer/vendor/autoload.php';
$Barcode = new \plugin\Document\php\Barcode;
//First, get the correct document size.

for($a = 1; $a < $_POST["rows"]; ++$a){
  if(!isset($_POST["file_" . $a])){continue;} //Check if the row is removed

  if($_GET["type"] == 74){
    $folder_convert = iconv ( "UTF-8", "windows-1251" ,  $_POST["dir"] . "/" . $_POST["file_" . $a]);
    foreach($Core->list_dir($folder_convert) as $folder_file){
        if(strpos($folder_file, "_1_") !== false){
          $file = $folder_file;
        }
    }
  } else {
    $file = $_POST["dir"] . "/" . $_POST["file_" . $a];
  }
  if(pathinfo($file)["extension"] != "pdf"){
    echo $file . " is not PDF<br>";
    continue;
  }

  //echo $_POST["file_" . $a] . " -> " . $_POST["barcode_" . $a] . '<br>';
  $barcode = $Query->select($_POST["barcode_" . $a], "barcode", "document");
  $case = $Query->select($barcode["case_id"], "id", "caser");
  $bar_data = array(
    "barcode" => $barcode["barcode"],
    "number" => $barcode["number"],
    "date" => $barcode["date"],
    "case" => $case["number"]
  );
  $Barcode->imageToPdf($bar_data);

  $mpdf = new \Mpdf\Mpdf([
      'tempDir' => "temp",
      'orientation' => 'L'
  ]);

  $pagecount = $mpdf->SetSourceFile($file);

  $tplId = $mpdf->ImportPage(1);
  $size = $mpdf->getTemplateSize($tplId);

  //Open a new instance with specified width and height, read the file again
  $mpdf = new \Mpdf\Mpdf([
      'tempDir' => "temp",
      'format' => [$size['width'], $size['height']]
  ]);
  $mpdf->SetSourceFile($file);

  //Write into the instance and output it
  for ($i=1; $i <= $pagecount; $i++) {
      $tplId = $mpdf->ImportPage($i);
      $mpdf->addPage();
      $mpdf->UseTemplate($tplId);
      if($i == 1){
        $y = $_GET["type"] == 74 ? 17 : 24;
        $mpdf->Image('C:\wamp64\www\csi\temp\barcode.png', 150, $y, 50, 30, 'png', '', true, false);
      }
  }

  $mpdf->output($file, "F");
}
?>
