<div class="admin">
    <div class="contain"><?php echo $File->item($_GET["id"], array("preview" => true));?></div>
    <div class="text-center margin-20"><button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button></div>
</div>