<select name="subsetting_id" id="subsetting_id"  class="tax-chooser">
    <option value="">Избери </option>
    <?php foreach ($PDO->query("SELECT id, `type` FROM " . $Setting->table . " WHERE `fortable`='debt' AND link_id='" . $_POST["id"] . "'") as $debt) { ?>
        <option value="<?php echo $debt["id"];?>"><?php echo $debt["type"];?></option>
    <?php } ?>
</select>