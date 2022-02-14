<div class="admin">
<?php if(!empty($Theme->items)){ ?>
    <div>Your current theme is:</div>
    <h2><?php echo $Theme->name;?></h2>
    <div class="clear">
        <div class="column-6">Version</div>
        <div class="column-6"><?php echo $Theme->data["version"];?></div>
    </div>
    <div><a href="<?php echo \system\Core::this_path(0, -1);?>/create-package" class="marginY-20 button inline-block">PACK CURRENT THEME</a></div>
    <div><a href="<?php echo \system\Core::this_path(0, -1);?>/blank" class="button marginY-20 inline-block">CREATE NEW BLANK THEME</a></div>

    <h3>Other installed themes</h3>
    <?php if (count($Theme->items) > 1) {?>
        <table class="listing">
            <tr>
                <th>Name</th>
                <th>Active</th>
            </tr>
            
            <?php 
            foreach ($Theme->items as $theme => $data) {
                if ($data["active"] == 0) {
                ?>
                    <tr>
                        <td><?php echo $theme;?></td>
                        <td><a href="<?php echo \system\Core::this_path(0, -1);?>/activate?theme=<?php echo $theme;?>" class="button">Activate</a></td>
                    </tr>
                <?php
                }
            }
            ?>
        </table>
    <?php } else { ?>
        <div>You have no more themes installed</div>
    <?php } ?>
    <a href="<?php echo \system\Core::this_path(0, -1);?>/add" class="button marginY-20 inline-block">Search themes in WEBSTORE</a>
  <?php
  } else {
  ?>
    <h3>You have no active theme installed!</h3>
    <div>ImaSmi Web should have active theme installed in order to function properly. Please create a custom blank theme or download one from the many pre-made themes in Webstore.</div>
    <div class="clear">
        <div class="column-6"><?php include_once(__DIR__ . "/blank.php");?></div>
        <div class="column-6"><?php include_once(__DIR__ . "/add.php");?></div>
    </div>
  <?php
  }
?>
</div>
