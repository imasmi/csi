<?php
require_once $Core->doc_root() . '/composer/vendor/autoload.php';
$Barcode = new \plugin\Document\php\Barcode;
echo __DIR__;

//First, get the correct document size.


for($a = 1; $a < $_POST["rows"]; ++$a){
  //echo $_POST["file_" . $a] . " -> " . $_POST["barcode_" . $a] . '<br>';
  $barcode = $Query->select($_POST["barcode_" . $a], "barcode", "document");
  $case = $Query->select($barcode["case_id"], "id", "caser");
  $bar_data = array(
    "barcode" => $barcode["barcode"],
    "number" => $barcode["number"],
    "date" => $barcode["date"],
    "case" => $case["number"]
  );
  $Barcode->imageToPdf($bar_data, $_GET["size"], $_GET["orientation"], $_GET["code_type"]);

  $mpdf = new \Mpdf\Mpdf([
      'tempDir' => "temp",
      'orientation' => 'L'
  ]);

  $pagecount = $mpdf->SetSourceFile('C:/Users/1/Downloads/NAP_191/' . $_POST["file_" . $a]);

  $tplId = $mpdf->ImportPage(1);
  $size = $mpdf->getTemplateSize($tplId);

  //Open a new instance with specified width and height, read the file again
  $mpdf = new \Mpdf\Mpdf([
      'tempDir' => "temp",
      'format' => [$size['width'], $size['height']]
  ]);
  $mpdf->SetSourceFile('C:/Users/1/Downloads/NAP_191/' . $_POST["file_" . $a]);

  //Write into the instance and output it
  for ($i=1; $i <= $pagecount; $i++) {
      $tplId = $mpdf->ImportPage($i);
      $mpdf->addPage();
      $mpdf->UseTemplate($tplId);
      if($i == 1){
        $mpdf->Image('C:\wamp64\www\csi\temp\barcode.png', 150, 24, 50, 30, 'png', '', true, false);
      }
  }

  $mpdf->output('C:/Users/1/Downloads/NAP_191/' . $_POST["file_" . $a], "F");
}
?>
