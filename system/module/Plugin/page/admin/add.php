<div class="admin">
<div class="title">CREATE PLUGIN</div>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo $Core->query_path();?>" method="post" onsubmit="return S.post('<?php echo $Core->query_path();?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" id="name" required/></td>
        </tr>
        
        <tr>
            <td>Type</td>
            <td>
                <?php 
                    $types = array("page" => "Page", "setting" => "Setting", "file" => "File");
                    $Form->select("type", $types, array("required" => true, "select" => "page"));
                ?>
            </td>
        </tr>
        
        <tr>
            <td>Show in admin panel</td>
            <td><input type="checkbox" name="admin-panel" id="admin-panel"/></td>
        </tr>

        <tr>
            <td colspan="2" class="text-center">
                <button class="button"><?php echo $Text->item("Next");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</form>
</div>