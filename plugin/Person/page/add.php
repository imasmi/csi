<?php
include_once(\system\Core::doc_root() . '/system/php/Form.php');
?>

<div class="admin">
<div class="title">Добавяне на лице</div>
<div class="errorMessage" id="errorMessage"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>" method="post">
    <table class="table">
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" id="name"/></td>
        </tr>
		
		<tr>
            <td>type</td>
            <td><?php echo \system\Form::select("type", array("person" => "person","firm" => "firm"));?></td>
        </tr>
		
		<tr>
            <td>ЕГН/ЕИК</td>
            <td><input type="text" name="EGN_EIK" id="EGN_EIK"/></td>
        </tr>
		
		<tr>
            <td>Бюджетно</td>
            <td><?php echo \system\Form::on_off("budget");?></td>
        </tr>
		
		<tr>
            <td>Нап</td>
            <td><?php echo \system\Form::on_off("nap");?></td>
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