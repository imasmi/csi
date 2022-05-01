<?php 
require_once(\system\Core::doc_root() . "/system/php/Form.php");
$Object = $Plugin->object();
$select = $PDO->query("SELECT * FROM doc_types WHERE id='{$_GET["id"]}'")->fetch();
?>
<div class="admin">
<h2 class="text-center title">Edit <?php echo $Page->map($_GET["id"]);?></h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>" method="post">
    <table class="table">       
        <tr>
            <td>Име</td>
            <td><input type="text" name="name" id="name" value="<?php echo $select["name"];?>" style="width: 400px;" required/></td>
        </tr>

        <tr>
            <td>Вид</td>
            <td>
            <select name="type" required>
                <option value="">ВИД ДОКУМЕНТ</option>
                <?php foreach($Object->types as $key => $value) {?>
                    <option value="<?php echo $key;?>" <?php if ($select ["type"] == $key) { echo 'selected';}?>><?php echo $value;?></option>
                <?php } ?>
            </select>
            </td>
        </tr>

        <tr>
            <td>Шаблони</td>
            <td>
                <?php 
                    $templates = [];
                    foreach ($PDO->query("SELECT id, bg FROM {$File->table} WHERE fortable='doc_types' AND tag='template' AND deleted IS NULL ORDER by bg ASC") as $template) {
                        $templates[$template["id"]] = $template["bg"];
                    }
                    \system\Form::multiselect("template", ["data" => $templates, "items" => json_decode($select["template"], true)]);
                ?>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="text-center">
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
                <button class="button"><?php echo $Text->item("Next");?></button>
            </td>
        </tr>
    </table>
</form>
</div>