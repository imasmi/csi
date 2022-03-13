<?php 
include_once(\system\Core::doc_root() . "/plugin/Select/php/Select.php");
$document = $PDO->query("SELECT * FROM document WHERE id='" . $_GET["id"] . "'")->fetch();
?>
<div class="admin">
    <h2 class="title text-center">Редакция на <?php echo $Text->_($document["type"] . " document");?></h2>
    <div class="error-message" id="error-message"></div>
    <form class="form" id="form" action="<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>', S.serialize('#form'), '#error-message')">
        <table class="table">
            <tr>
                <td>Номер</td>
                <td><?php echo $document["number"];?></td>
            </tr>

            <tr>
                <td>Вид документ</td>
                <td><?php echo \plugin\Select\Select::_([
                    "name" => "name", 
                    "url" => \system\Core::url() . 'Select/query/doc-type?type=' . $document["type"], 
                    "value" => $document["name"],
                    "output" => $PDO->query("SELECT name FROM doc_types WHERE id='" . $document["name"] . "'")->fetch()["name"],
                ]);?></td>
            </tr>
        
        <?php if ($document["type"] != "protocol") { ?>
            <tr>
                <td><?php echo $document["type"] == "incoming" ? "Подател" : "Адресат";?></td>
                <td><?php echo \plugin\Select\Select::_([
                    "name" => "sender_receiver", 
                    "url" => \system\Core::url() . 'Select/query/person',
                    "value" => $document["sender_receiver"],
                    "output" => $PDO->query("SELECT name FROM person WHERE id='" . $document["sender_receiver"] . "'")->fetch()["name"],
                    ]);?></td>
            </tr>
        <?php } ?>

            <tr>
                <td>Дело</td>
                <td><?php echo $Caser->select("case_id", ["id" => $document["case_id"]]);?></td>
                <script>
                    document.getElementById("case_id-data").addEventListener("change", () => {
                        setTimeout(() => S.post('<?php echo \system\Core::url();?>Person/query/debtor-selector', {case_id: S('#case_id').value, name: 'person'}, '#debtor-select', true), 200)
                    });
                </script>
            </tr>

            <tr>
                <td>Длъжник</td>
                <td id="debtor-select">
                <?php 
                    if (isset($document["person"])) {
                        $Caser_document = new \plugin\Caser\Caser($document["case_id"]);
                        ?>

                        <select name="person" id="person">
                            <option value="">Избери</option>
                            <?php foreach($Caser_document->debtor as $debtor) { ?>
                                <option value="<?php echo $debtor;?>" <?php if ($document["person"] == $debtor) { echo 'selected';}?>><?php echo $PDO->query("SELECT name FROM person WHERE id='" . $debtor . "'")->fetch()["name"];?></option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                </td>
            </tr>
            
            <tr>
                <td>Бележка</td>
                <td><textarea name="note"><?php echo $document["note"];?></textarea></td>
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