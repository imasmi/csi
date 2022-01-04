<?php
require_once(\system\Core::doc_root() . "/system/module/Page/php/PageAPP.php");
$PageAPP = new \module\Page\PageAPP;
require_once(\system\Core::doc_root() . "/system/php/Form.php");
$Form = new \system\Form;
$text = $PDO->query("SELECT * FROM " . $Text->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
$Text = new \module\Text\Text($text["page_id"], array("fortable" => $text["fortable"], "page_id" => $text["page_id"]));
?>

<div class="admin">
<div class="error-message" id="error-message"></div>
<div class="title text-center edit-title">Edit text: <?php echo $text["tag"]?></div>
    <div class="padding-20"><?php echo $Text->_($_GET["id"]);?></div>

    <div class="padding-20">Advanced: <span class="inline-block"><?php \system\Form::on_off("addText", 0, false);?></span></div>
    <form class="form hide" id="addText" action="<?php echo \system\Core::query_path()  . "?id=" . $text["id"];?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path() . "?id=" . $text["id"];?>', S.serialize('#addText'), '#error-message')">
        <table class="table center">
            <tr>
                <th>Page</th>
                <td><?php $PageAPP->select("page_id", array("select" => $text["page_id"]));?></td>
            </tr>

            <tr>
                <th>Label</th>
                <td><input type="text" name="tag" id="tag" value="<?php echo $text["tag"]?>" required/></td>
            </tr>

            <tr>
                <td colspan="2" class="text-center">
                    <button class="button"><?php echo $Text->item("Save");?></button>
                </td>
            </tr>
        </table>
    </form>
    <div class="text-center"><button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button></div>
</div>
