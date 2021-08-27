<div class="admin">
    <?php echo $Listing->view($_GET["id"]);?>
    #$Listing->view($value, $array="*", $selector="id", $table="module", $delimeter="=")
    <div class="text-center"><button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button></div>
</div>