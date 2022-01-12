<?php 
include_once(\system\Core::doc_root() . '/system/php/Form.php');
include_once(\system\Core::doc_root() . '/plugin/Person/php/Person.php');
$Person = new \plugin\Person\Person($_GET["person"]);
$select = $PDO->query("SELECT * FROM caser WHERE id='" . $_GET["id"] . "'")->fetch();
?>
<div class="admin">
<h4>Сменяне на <?php echo $_GET["type"] == "creditor" ? "взискател" : "длъжник";?> по дело <?php echo $select["number"];?></h4>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>&type=<?php echo $_GET["type"];?>&person=<?php echo $_GET["person"];?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>&type=<?php echo $_GET["type"];?>&person=<?php echo $_GET["person"];?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>Лице</td>
            <td><?php $Person->select("person");?></td>
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