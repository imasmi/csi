<?php
$select = $Query->select($_GET["id"]);
?>

<div class="admin">
    <form method="post" action="<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>">
        <table class="table">
            <tr>
                <td colspan="2">Are you sure you want to delete this id?</td>
            </tr>
            
            <tr>
                <td colspan="2" class="title"><?php echo $select["id"];?></td>
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