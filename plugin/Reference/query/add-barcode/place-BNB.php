<?php 
require_once $Core->doc_root() . '/composer/vendor/autoload.php';
$Bnb = new \plugin\Reference\php\Bnb;
$Barcode = new \plugin\Document\php\Barcode();
require_once($Core->doc_root() . '/system/module/File/php/FileAPP.php');
$FileAPP = new \system\module\File\php\FileAPP;

$files = $Core->list_dir('C:/Users/1/Downloads/BNB'); //get all file names
foreach($files as $file){
    if(is_file($file)){
        $pathinfo = pathinfo($file);
        if ($pathinfo["extension"] === "xml"){
            rename($file, "C:/Users/1/Downloads/bnb_references/" . $pathinfo["basename"]);
        } else if ($pathinfo["extension"] === "pdf") {
            unlink($file); //delete file
        }
    } 
}

for($a = 1; $a < $_POST["rows"]; ++$a){
    ob_start();

    if(!isset($_POST["barcode_" . $a])){continue;} //Check if the row is removed
    $egn = $_POST["egn_" . $a];
    $value = json_decode($_POST["value_" . $a], true);
    $document = $Query->select($_POST["barcode_" . $a], "barcode", "document");
    $case_numb = $Query->select($document["case_id"], "id", "caser", "number")["number"];
?>
    <?php echo $Barcode->html_return($document);?>
    <table>
        <tr>
            <td><img src="<?php echo $Core->url() . $File->items[1]["path"];?>" style="width: 130px;"/></td>
            <td style="font-size: 13px;">
                <b>
                    <div>БЪЛГАРСКА НАРОДНА БАНКА</div>
                    <br>
                    <div>РЕГИСТЪР НА БАНКОВИТЕ СМЕТКИ И СЕЙФОВЕ</div>
                </b>
            </td>
        </tr>		
    </table>

    <h4>СПРАВКА ЗА БАНКОВИ СМЕТКИ И СЕЙФОВЕ НА ФИЗИЧЕСКО/ЮРИДИЧЕСКО ЛИЦЕ</h4>
    
    <h5>Електронната справка е изготвена от ЧСИ ГЕОРГИ  ЦЕНОВ ТАРЛЬОВСКИ.</h5>
    
    <table border="1" style="border-collapse: collapse; width: 420px; font-size: 9px;">
        <tr>
            <td><b>Основание за справката, чл. 56а от ЗКИ и Наредба 12 на БНБ, чл. 11</b></td>
            <td><?php echo $case_numb;?></td>
        </tr>			
    </table>

    <table border="1" style="border-collapse: collapse; width: 420px; font-size: 9px; margin-top: 20px;">	
        <tr>
            <td><b>ПЕРИОД НА СПРАВКАТА</b></td>
            <td><?php echo $_POST["dateFrom"];?> г. - <?php echo $_POST["dateTo"];?> г.</td>
        </tr>			
    </table>

    <table border="1" style="border-collapse: collapse; width: 420px; font-size: 9px; margin-top: 20px;">
        <tr><td><b>ДАННИ ЗА ЛИЦЕТО</b></td></tr>
        <tr><td>ДЪРЖАВА, ИЗДАЛА ИДЕНТИФИКАТОР: BULGARIA;<br/> ИДЕНТИФИКАТОР: <?php echo $Bnb->bnb_id($value[0]["identity_type"]) . " " . $egn;?></td></tr>	
    </table>
    
<?php 
    #DISPLAY BANK ACCOUNTS FOR USER
    $Bnb->accounts($value[0]["bank"]);
    
    #DISPLAY BANK SAFES FOR USER
    $Bnb->safes($value[0]["safes"]);
?>

<?php if(isset($value[1])){?>
    <br/>
    <h5>ДАННИ ЗА ЛИЦЕ, УПРАЖНЯВАЩО СВОБОДНА ПРОФЕСИЯ ИЛИ ЗАНАЯТЧИЙСКА ДЕЙНОСТ<br/>С ИДЕНТИФИКАТОР: <?php echo $egn;?>;</h5>

<?php 

    #DISPLAY BANK ACCOUNTS FOR USER'S BULSTAT
    $Bnb->accounts($value[1]["bank"]);
    
    #DISPLAY BANK ACCOUNTS FOR USER'S BULSTAT
    $Bnb->safes($value[1]["safes"]);
} ?>

<h5>Съгласно чл. 8 от Наредба № 12 за Регистъра на банковите сметки и сейфове, банките носят отговорност за верността, пълнотата и своевременното подаване на информацията. Българската народна банка не извършва корекции в регистъра, освен за подаваната от нея информация.</h5>
<div>Дата: <?php echo date("d.m.Y г.,H:i ч.", strtotime($value[0]["processed_time"]));?></div>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($content);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;
    $file_name = "C:/Users/1/Downloads/BNB/" . $a . "_". $case_numb . ".pdf";
    $mpdf->Output($file_name, "F");
    //$mpdf->Output();
    echo $file_name . '<br>';
  }
?>
