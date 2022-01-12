<?php 
include_once(\system\Core::doc_root() . '/system/php/Form.php');
include_once(\system\Core::doc_root() . '/plugin/Person/php/Person.php');
$select = $PDO->query("SELECT * FROM caser_title WHERE id='" . $_GET["id"] . "'")->fetch();
$Person = new \plugin\Person\Person($select["court_id"]);
$case = $PDO->query("SELECT * FROM caser WHERE id='" . $_GET["id"] . "'")->fetch();
?>
<div class="admin">
<h4>Редакция на титул по дело <?php echo $case["number"];?></h4>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>Вид вземане</td>
            <td>
            <?php 
                    $types = [];
                    foreach ($PDO->query("SELECT id, value FROM " . $Setting->table . " WHERE plugin='Caser' AND tag='title-type' ORDER by value ASC") as $type) {
                        $types[$type["id"]] = $type["value"];
                    }
                    \system\Form::select("type", $types, ["required" => true, "select" => $select["type"]]);
                ?>
            </td>
        </tr>

        <tr>
            <td>Съд</td>
            <td><?php $Person->select("court_id");?></td>
        </tr>

        <tr>
            <td>Дата</td>
            <td><input type="date" name="date" id="date" value="<?php echo $select["date"];?>" required></td>
        </tr>

        <tr>
            <td>Номер</td>
            <td><textarea name="number" id="number" required><?php echo $select["number"];?></textarea></td>
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