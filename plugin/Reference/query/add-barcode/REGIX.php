<?php
include_once(\system\Core::doc_root() . '/plugin/Document/php/Barcode.php');
$Barcode = new \plugin\Document\Barcode();
?>

<!doctype HTML>
<head>
  <link rel="stylesheet" href="<?php echo \system\Core::url();?>web/css/style.css">
  <script src="<?php echo \system\Core::url();?>system/js/System.js"></script>
</head>
<body>


<div class="frame">
<?php
$list = $_GET["dir"];
$listConv = iconv ( "UTF-8", "windows-1251" ,  $list );
$listDir = scandir($listConv);
unset($listDir[0], $listDir[1]);
$bar_check = array();
$cnt;
foreach($listDir as $f){
  ++$cnt;
  $barcode = NULL;
  $folder = iconv ( "windows-1251" , "UTF-8", $f );
  $name = str_replace($list, "", $folder);
  $case_numb = explode("_", $name)[0];
  $case_id = $PDO->query("SELECT id FROM " . $Caser->table . " WHERE number='" . $case_numb . "'")->fetch();

  $exclude = "";
  if(isset($bar_check[$case_id])){
    foreach($bar_check[$case_id] as $value){
      $exclude .= " AND id != '" . $value . "'";
    }
  }
  $barcode = $PDO->query("SELECT * FROM document WHERE case_id='" . $case_id . "' AND type='incoming'" . $exclude . " ORDER by id DESC")->fetch();
  $bar_check[$case_id][] = $barcode["id"];
  
  $content = file_get_contents($listConv . '/' . $name);
  ?>
    <div class="regix-print relative">
      <div id="barcode-<?php echo $cnt;?>" class="regix-barcode relative"><?php $Barcode->_($barcode, "barcode-" . $cnt);?></div>
      <div class="regix-content relative"><?php echo $content;?></div>
    </div>
  <?php
}
?>
</div>
</body>
</html>
<script>
	window.addEventListener('load', function(){
		csi.printBothSides(".person", 3000);
	});
</script>
