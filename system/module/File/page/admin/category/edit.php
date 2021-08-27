<?php
$PageAPP = new \system\module\Page\php\PageAPP;
$select = $Query->select($_GET["id"]);
?>

<div class="admin">
<div class="title"><?php echo $select["tag"];?></div>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        
        <?php foreach($Language->items as $key=>$value){?>
            <tr>
                <td><?php echo $key;?> name</td>
                <td><input type="text" name="<?php echo $value;?>" id="<?php echo $value;?>" required value="<?php echo $select[$value];?>"/></td>
            </tr>
        <?php } ?>
        
        <?php if($select["link_id"] == 0){?>
        <tr>
            <th>Page</th>
            <td><?php $PageAPP->select("page_id", array("select" => $select["page_id"]));?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="2" class="text-center">
                <button class="button"><?php echo $Text->item("Save");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</form>
</div>