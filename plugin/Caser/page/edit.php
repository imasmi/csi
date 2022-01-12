<?php
include_once(\system\Core::doc_root() . '/system/php/Form.php');
$select = $PDO->query("SELECT * FROM caser WHERE id='" . $_GET["id"] . "'")->fetch();
?>

<div class="admin">
    <h4>Редакция на изпълнително дело</h4>
    <form method="post" action="<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>" class="text-center" onsubmit="return S.post('<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>', S.serialize(this), '#error-message')">
        <h3><?php echo $select["number"];?></h3>

        <div class="clear marginY-10">
            <div class="column-6">Статус</div>
            <div class="column-6">
                <?php 
                    $statuses = [];
                    foreach ($PDO->query("SELECT id, value FROM " . $Setting->table . " WHERE plugin='caser' AND `tag` = 'status' ORDER by value ASC") as $status) {
                        $statuses[$status["id"]] = $status["value"];
                    }
                    \system\Form::select("status", $statuses, ["required" => true, "select" => $select["status"]]);
                ?>
            </div>
        </div>

        <div class="clear marginY-10">
            <div class="column-6">Отговорник</div>
            <div class="column-6">
                <?php 
                    $users = [];
                    foreach ($PDO->query("SELECT id, email FROM " . $User->table . " WHERE status='active' AND `group` != 'admin' ORDER by email ASC") as $user) {
                        $users[$user["id"]] = $user["email"];
                    }
                    \system\Form::select("charger", $users, ["required" => true, "select" => $select["charger"]]);
                ?>
            </div>
        </div>

        <div class="clear marginY-10">
            <div class="column-6">Статистика</div>
            <div class="column-6">
                <?php 
                    $statistics = [];
                    foreach ($PDO->query("SELECT id, row, value FROM " . $Setting->table . " WHERE plugin='Caser' AND type='statistic' ORDER by tag ASC") as $statistic) {
                        $statistics[$statistic["row"]] = $statistic["value"];
                    }
                    \system\Form::select("statistic", $statistics, ["required" => true, "select" => $select["statistic"]]);
                ?>
            </div>
        </div>
        <div class="clear marginY-20">
            <div class="error-message" id="error-message"></div>
            <button class="button">Save</button>
            <button class="button" type="button" onclick="history.back()">Back</button>
        </div>
    </form>
</div>