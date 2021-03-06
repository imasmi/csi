<?php
require_once(\system\Core::doc_root() . "/system/php/Form.php");
$Form = new \system\Form;
    $ini = parse_ini_file(\system\Core::doc_root() . "/system/ini/languages.ini");
    $ini["Norwegian"] = "no";
    $ini = array_flip($ini);
?>
<div class="admin">
<div class="error-message" id="error-message"></div>
<div class="title text-center">Add language</div>
<form class="form" id="add-language" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#add-language'), '#error-message')">
    <table class="table">
        <tr>
            <td>Name</td>
            <td><?php \system\Form::select("language", $ini);?></td>
        </tr>

        <tr>
            <td colspan="2" class="text-center">
                <button class="button"><?php echo $Text->item("Save");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</form>
</div>
