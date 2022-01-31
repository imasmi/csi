<div class="admin">
<h2 class="title text-center">Добавяне на такса</h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>Номер</td>
            <td><input type="number" step="1" name="row" id="row"/></td>
        </tr>
        
        <tr>
            <td>Описание</td>
            <td><input type="text" name="type" id="type"/></td>
        </tr>

        <tr>
            <td>Стойност по подразбиране</td>
            <td><input type="number" step="0.01" name="value" id="value"/></td>
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