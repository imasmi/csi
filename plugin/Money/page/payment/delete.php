<?php
$select = $PDO->query("SELECT * FROM payment WHERE id='" . $_GET["id"] . "'")->fetch();
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
$Caser = new \plugin\Caser\Caser($select["case_id"]);
?>

<div class="admin">
    <form method="post" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>">
        <table class="table">
            <tr>
                <td colspan="2"><h3><?php echo $Caser->number;?></h3></td>
            </tr>
            
            <tr>
                <td colspan="2" class="title"><h3>Сигурни ли сте, че искате да изтриете плащане за <?php echo $select["amount"];?> лева</h3></td>
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