<?php
$select = $PDO->query("SELECT * FROM " . $Page->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
?>

<div class="admin">
<div>Are you sure you want to delete this page?</div>
    <form method="post" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>">
        <table class="table">
            
            <tr>
                <td colspan="2" class="title attention"><?php echo $Page->map($_GET["id"]);?></td>
            </tr>
            
            <tr>
                <td colspan="2">Deleting page will delete any subpages linked to it!</td>
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