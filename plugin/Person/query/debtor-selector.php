<?php 
$Caser = new \plugin\Caser\Caser($_POST["case_id"]);
?>

<select name="<?php echo $_POST["name"];?>" id="<?php echo $_POST["name"];?>">
    <option value="">Избери</option>
    <?php foreach($Caser->debtor as $debtor) { ?>
        <option value="<?php echo $debtor;?>"><?php echo $PDO->query("SELECT name FROM person WHERE id='" . $debtor . "'")->fetch()["name"];?></option>
    <?php } ?>
</select>