<?php
$find_user = $PDO->prepare("SELECT id FROM " . $Query->table() . " WHERE email LIKE :email AND status LIKE :status AND deleted IS null");
$find_user->execute(
    array(
        "email" => $_GET["email"],
        "status" => $_GET["code"]  
    )
);

if($find_user->rowCount() === 1){
    $finded_user = $find_user->fetch();
    $activate = $PDO->query("UPDATE " . $Query->table() . " SET status='active' WHERE id='" . $finded_user["id"] . "'");
    ?><script>location.href = '<?php echo $Core->url() . 'User/message/activate-success';?>';</script><?php
} else {
    ?><script>location.href = '<?php echo $Core->url() . 'User/message/activate-error';?>';</script><?php
}
exit;
?>