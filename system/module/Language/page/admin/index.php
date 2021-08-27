<?php
$ini = $Language->ini;
?>

<div class="admin">
    <div><button type="button" class="button" onclick="window.open('<?php echo $Core->this_path(0,-1);?>/add','_self')">Add new</button></div>
    <form method="post" action="<?php echo $Core->query_path();?>">
    
        <table class="listing">
            <tr>
                <th>Name</th>
            <?php foreach($ini[key($ini)] as $key=>$value){?>
                <th><?php echo ($key === "on-off") ? "Turn on/off" : $key;?></th>
            <?php } ?>
                <th>Reposition</th>
                <th>Delete</th>
            </tr>
        
        <?php 
        $fullCNT = 1;
        foreach($ini as $key => $value){ 
        $fullCNT++;
        ?>
                <tr class="moduler">
                   <td><?php echo $key;?></td>
                <?php foreach($value as $key1=>$value1){
                    if($key1 === "on-off"){
                ?>
                   <td>
                       <?php 
                            if($value1 == "default"){
                                echo $value1;
                                echo '<input type="hidden" value="default" name="' . $key . '_' . $key1 . '"/>';
                            } else {
                                echo $Form->on_off($key . '_' . $key1, $value1, true);
                            }
                        ?>
                   </td>
                
                <?php 
                    } else {
                ?>
                    <td><input type="text" name="<?php echo $key . '_' .  $key1;?>" value="<?php echo $value1;?>"/></td>
                
                <?php }} ?>
                
                    <td>
                        <select name="<?php echo $key . "_position";?>">
                            <?php
                            $cnt = 10;
                            foreach($ini as $key2=>$value2){
                                if($key2 == $key){ 
                            ?>
                            <option value="<?php echo $cnt;?>" selected>No reposition</option>
                            <?php } else {?>    
                            <option value="<?php echo $cnt - $fullCNT;?>">Before <?php echo $key2;?></option>
                            <?php }
                            $cnt+=10;
                            }?>
                        </select>
                    </td>
                    
                    <td><button type="button" class="button" onclick="window.open('<?php echo $Core->this_path(0,-1) . '/delete?lang=' . $key;?>', '_self')">Delete</button></td>
                </tr>
        <?php } ?>
        </table>
    <div class="text-center"><button class="button"><?php echo $Text->item("Save");?></button></div>
    </form>
</div>