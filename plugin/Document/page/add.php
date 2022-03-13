<?php 
include_once(\system\Core::doc_root() . "/plugin/Select/php/Select.php");
$next_number = $PDO->query("SELECT number FROM document WHERE date >= '" . date("Y-01-01") . "' ORDER by number DESC")->fetch()["number"] + 1;
?>
<div class="admin">
    <h2 class="title text-center">Добавяне на <?php echo $Text->_($_GET["type"] . " document");?></h2>
    <div class="error-message" id="error-message"></div>
    <form class="form" id="form" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#form'), '#error-message')">
        <input type="hidden" name="type" value="<?php echo $_GET["type"];?>"/>
        <input type="hidden" name="user" value="<?php echo $User->id;?>"/>
        <input type="hidden" name="number" value="<?php echo $next_number;?>"/>
        <table class="table">
            <tr>
                <td>Номер</td>
                <td><?php echo $next_number;?></td>
            </tr>

            <tr>
                <td>Вид документ</td>
                <td><?php echo \plugin\Select\Select::_(["name" => "name", "url" => \system\Core::url() . 'Select/query/doc-type?type=' . $_GET["type"]]);?></td>
            </tr>

        <?php if ($_GET["type"] != "protocol") { ?>
            <tr>
                <td><?php echo $_GET["type"] == "incoming" ? "Подател" : "Адресат";?></td>
                <td><?php echo \plugin\Select\Select::_(["name" => "sender_receiver", "url" => \system\Core::url() . 'Select/query/person']);?></td>
            </tr>
        <?php } ?>

            <tr>
                <td>Дело</td>
                <td><?php echo $Caser->select("case_id");?></td>
                <script>
                    document.getElementById("case_id-data").addEventListener("change", () => {
                        setTimeout(() => S.post('<?php echo \system\Core::url();?>Person/query/debtor-selector', {case_id: S('#case_id').value, name: 'person'}, '#debtor-select', true), 200)
                    });
                </script>
            </tr>

            <tr>
                <td>Длъжник</td>
                <td id="debtor-select"></td>
            </tr>
            
            <tr>
                <td>Бележка</td>
                <td><textarea name="note"></textarea></td>
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