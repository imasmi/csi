<?php
$Object = $Plugin->object("Template");
foreach ($_POST as $key => $value) {
    $id = explode("_", $key)[1];
    $select = $PDO->query("SELECT * FROM {$File->table} WHERE id='{$id}'")->fetch();

    $data = ["bg" => $value];

    if (isset($_FILES["file_$id"]) && $_FILES["file_$id"]["error"] == 0) {
        $file = $_FILES["file_$id"];
        $pathinfo = pathinfo($file["name"]);
        $name = $value;
        $path = $Object->path . "/" . $name . "." . $pathinfo ["extension"];

        if (move_uploaded_file($file["tmp_name"], iconv('UTF-8','windows-1251',$path))){
            $data["path"] = $path;
            $data["bg"] = $name;
            if (file_exists(\system\Core::doc_root() . "/" . $select["path"])) {unlink(\system\Core::doc_root() . "/" . $select["path"]);}
        } else {
            echo 'Грешка при качване на шаблон';
        }

        \system\Data::update([
            "data" => $data,
            "table" => $File->table,
            "where" => "id='$id'"
        ]);

    }
}
?>
<script>history.go(-2);</script>