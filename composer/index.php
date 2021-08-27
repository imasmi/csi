<?php
require_once __DIR__ . '/vendor/autoload.php';
//First, get the correct document size.
    $mpdf = new \Mpdf\Mpdf([
        'tempDir' => "temp",
        'orientation' => 'L'
    ]);

    $pagecount = $mpdf->SetSourceFile('file/test.pdf');

    $tplId = $mpdf->ImportPage(1);
    $size = $mpdf->getTemplateSize($tplId);

    //Open a new instance with specified width and height, read the file again
    $mpdf = new \Mpdf\Mpdf([
        'tempDir' => "temp",
        'format' => [$size['width'], $size['height']]
    ]);
    $mpdf->SetSourceFile('file/test.pdf');

    //Write into the instance and output it
    for ($i=1; $i <= $pagecount; $i++) {
        $tplId = $mpdf->ImportPage($i);
        $mpdf->addPage();
        $mpdf->UseTemplate($tplId);
        if($i == 1){
          $mpdf->Image('file/test.jpg', 150, 24, 50, 30, 'jpg', '', true, false);
        }
    }

    $mpdf->output("file/output.pdf", "F");
    //return $mpdf->output();
?>
