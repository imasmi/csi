<?php
$select = $PDO->query("SELECT * FROM person WHERE id='" . $_GET["id"] . "'")->fetch();
?>

<div class="admin">
<div class="title"><?php echo $select["name"];?></div>
<div class="errorMessage" id="errorMessage"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>" method="post">
    <table class="table">
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" id="name" value="<?php echo $select["name"];?>"/></td>
        </tr>
		
		<tr>
            <td>type</td>
            <td><?php echo $Form->select("type", array("person" => "person","firm" => "firm"), array("select" => $select["type"]));?></td>
        </tr>
		
		<tr>
            <td>ЕГН/ЕИК</td>
            <td><input type="text" name="EGN_EIK" id="EGN_EIK" value="<?php echo $select["EGN_EIK"];?>"/></td>
        </tr>
		
		<tr>
            <td>Бюджетно</td>
            <td><?php echo $Form->on_off("budget", $select["budget"]);?></td>
        </tr>
		
		<tr>
            <td>Нап</td>
            <td><?php echo $Form->on_off("nap", $select["nap"]);?></td>
        </tr>
        
        <tr>
            <td colspan="2" class="text-center">
                <button class="button">Save</button>
                <button class="button" type="button" onclick="history.back()">Back</button>
            </td>
        </tr>
    </table>
</form>
</div>