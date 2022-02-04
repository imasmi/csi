<?php 
$sub = isset($_GET["id"]);
if ($sub) {$select = $select = $PDO->query("SELECT * FROM " . $Setting->table . " WHERE id='" . $_GET["id"] . "'")->fetch();}?>

<div class="admin">
<h2 class="title text-center">Добавяне на описание за дълг</h2>
<?php if ($sub) { ?>
    <h2>към <?php echo $select["type"];?></h2>
<?php } ?>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#form'), '#error-message')">
    <?php if ($sub) { ?><input type="hidden" name="link_id" value="<?php echo $_GET["id"];?>"><?php } ?>
    <table class="table">        
        <tr>
            <td>Описание</td>
            <td><input type="text" name="type" id="type"/></td>
        </tr>
        
        <?php if (!$sub) { ?>
        <tr>
            <td>Вид вземане</td>
            <td>
                <select name="tag" id="tag">
                    <option value="non-interest">Неолихвяемо</option>
                    <option value="interest">Олихвяемо</option>
                </select>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="2" class="text-center">
                <button class="button"><?php echo $Text->item("Save");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</form>
</div>