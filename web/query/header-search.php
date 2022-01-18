<?php include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');?>
<div class="popup-content">
  <?php
    $search = $PDO->prepare("SELECT id, name, EGN_EIK FROM person WHERE EGN_EIK=? OR name LIKE '%" . $_POST["search"] . "%'");
    $search->execute([$_POST["search"]]);
    foreach($search as $person){
    ?>
      <div class="person">
        <h3><?php echo $person["name"];?></h3>
        <div><?php echo $person["EGN_EIK"];?></div>
        <h3>Взискател по</h3>
        <?php
          foreach($PDO->query("SELECT c.id FROM caser_title t, caser c WHERE t.creditor LIKE '%\"" . $person["id"] . "\"%' AND c.id=t.case_id") as $case){
            $Caser = new \plugin\Caser\Caser($case["id"]);
            ?>

              <div><?php $Caser->open();?></div>
            <?php
          }
          ?>
          <h3>Длъжник по</h3>
          <?php
          foreach($PDO->query("SELECT c.id FROM caser_title t, caser c WHERE t.debtor LIKE '%\"" . $person["id"] . "\"%' AND c.id=t.case_id") as $case){
            $Caser = new \plugin\Caser\Caser($case["id"]);
            ?>
              <div><?php $Caser->open();?></div>
            <?php
          }
        ?>
      </div>
    <?php
    }
  ?>
</div>
