<select name="subsetting_id<?php echo $_POST["name_cnt"];?>" id="subsetting_id<?php echo $_POST["name_cnt"];?>"  class="tax-chooser">
    <option value="">Избери </option>
    <?php foreach ($PDO->query("SELECT id, `type` FROM " . $Setting->table . " WHERE `fortable`='debt' AND link_id='" . $_POST["id"] . "'") as $debt) { ?>
        <option value="<?php echo $debt["id"];?>"><?php echo $debt["type"];?></option>
    <?php } ?>
</select>