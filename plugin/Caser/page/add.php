<?php
include_once(\system\Core::doc_root() . '/system/php/Form.php');
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
$select = $PDO->query("SELECT number FROM caser ORDER by number DESC")->fetch();
$split_case = \plugin\Caser\Caser::split_number($select["number"]);

if ($split_case["year"] == date("Y")) {
    $new_number = $select["number"] + 1;
} else {
    $new_number = \plugin\Caser\Caser::number(date("Y"), "1");
}
?>

<div class="admin">
    <h4>Добавяне на ново дело изпълнително дело</h4>
    <form method="post" action="<?php echo \system\Core::query_path();?>" class="text-center" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize(this), '#error-message')">
        <h3><?php echo $new_number;?></h3>
        <input type="hidden" name="number" value="<?php echo $new_number;?>"/>
        <div class="clear marginY-10">
            <div class="column-6">Отговорник</div>
            <div class="column-6">
                <?php 
                    $users = [];
                    foreach ($PDO->query("SELECT id, email FROM " . $User->table . " WHERE status='active' AND `group` != 'admin' ORDER by email ASC") as $user) {
                        $users[$user["id"]] = $user["email"];
                    }
                    \system\Form::select("charger", $users, ["required" => true]);
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
                    \system\Form::select("statistic", $statistics, ["required" => true]);
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