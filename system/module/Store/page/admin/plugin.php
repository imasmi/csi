<div class="title text-center">
<?php
if(array_key_exists($_GET["name"], $Plugin->items)){
?>
    You own this plugin
<?php
} else {?>
    <div id="result"></div>
    <button type="button" class="button" onclick="S.post('<?php echo $Core->query_path();?>?name=<?php echo $_GET["name"];?>', {}, '#result')">INSTALL</button>
<?php
}
?>
</div>
<?php
$store = file_get_contents("https://web.imasmi.com/Webstore/query/plugin?name=" . $_GET["name"]);
echo $store;
?>