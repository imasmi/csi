<div class="admin">
<div class="title">CODE</div>
<div class="attention">This module is for finding and editing code strings. Use this module only if you know what you are doing. Backup your project before using this function!</div>
<form class="form" id="form" action="<?php echo $Core->query_path();?>" method="post" target="_blank">
    <table class="table center">
        <tr>
            <td>Code</td>
            <td><input type="text" name="code" id="code" required/></td>
        </tr>
        
        <tr>
            <td>Replacer</td>
            <td><input type="text" name="replacer" id="replacer"/></td>
        </tr>
        
        <tr>
            <td>Path</td>
            <td><?php echo $Core->doc_root();?>/ <input type="text" name="path" id="path"/></td>
        </tr>
        
        <tr>
            <td>Filetype (left blank for any)</td>
            <td><input type="text" name="filetype" id="filetype"/></td>
        </tr>
        
        <tr>
            <td>Exclude file directories</td>
            <td><input type="checkbox" name="exclude-files" checked/></td>
        </tr>
        
        <tr>
            <td>Action</td>
            <td>
                Find <input type="radio" name="action" value="find" checked/>
                <input type="radio" name="action" value="replace"/> Replace
            </td>
        </tr>
        
        <tr>
            <td colspan="2" class="text-center">
                <button class="button"><?php echo $Text->item("Save");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</form>

<div id="output"></div>
</div>