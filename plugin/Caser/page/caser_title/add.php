<?php 
include_once(\system\Core::doc_root() . '/system/php/Form.php');
include_once(\system\Core::doc_root() . '/plugin/Person/php/Person.php');
$Person = new \plugin\Person\Person;
$select = $PDO->query("SELECT * FROM caser WHERE id='" . $_GET["id"] . "'")->fetch();
?>
<div class="admin">
<h4>Добавяне на титул по дело <?php echo $select["number"];?></h4>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>', S.serialize('#form'), '#error-message')">
    <input type="hidden" name="case_id" value="<?php echo $_GET["id"]?>"/>
    <table class="table">
        <tr>
            <td>Вид вземане</td>
            <td>
            <?php 
                    $types = [];
                    foreach ($PDO->query("SELECT id, value FROM " . $Setting->table . " WHERE plugin='Caser' AND tag='title-type' ORDER by value ASC") as $type) {
                        $types[$type["id"]] = $type["value"];
                    }
                    \system\Form::select("type", $types, ["required" => true]);
                ?>
            </td>
        </tr>

        <tr>
            <td>Съд</td>
            <td><?php $Person->select("court_id");?></td>
        </tr>

        <tr>
            <td>Дата</td>
            <td><input type="date" name="date" id="date" required></td>
        </tr>

        <tr>
            <td>Номер</td>
            <td><textarea name="number" id="number" required></textarea></td>
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