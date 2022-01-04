<?php
$ini = parse_ini_file(\system\Core::doc_root() . "/web/ini/language.ini", true);

#CHECK IF THERE IS ONE MORE THAN ONE LANGUAGE
if(count($ini) < 2){ ?>
    
    <div class="title text-center">
            <h2>You can't delete this language because it is your only language!</h2>
            <h3>If you still want to delete it, you must create another language first.</h3>
            <div class="admin">
            <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </div>
    </div>

<?php      
} else {

?>

<div class="admin">
<table class="table">
        
    <tr>
        <td colspan="2">Are you sure you want to delete this language?</td>
    </tr>
    
    <tr>
        <td colspan="2"><?php echo $_GET["lang"];?></td>
    </tr>
        
    <tr>
        <td colspan="2" class="text-center">
            <button class="button" onclick="window.open('<?php echo \system\Core::query_path() . '?lang=' . $_GET["lang"];?>', '_self')"><?php echo $Text->item("Yes");?></button>
            <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
        </td>
    </tr>
</table>
</div>

<?php } ?>