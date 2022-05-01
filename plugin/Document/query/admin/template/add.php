<?php
$Object = $Plugin->object("Template");
$file = $_FILES["template_0"];
if ($file["error"] == "0") {
    $pathinfo = pathinfo($file["name"]);
    $name = isset($_POST["template_0_0_name"]) && $_POST["template_0_0_name"] != "" ?  $_POST["template_0_0_name"] : $pathinfo["filename"];
    $path = $Object->path . "/" . $name . "." . $pathinfo ["extension"];
    if (move_uploaded_file($file["tmp_name"], iconv('UTF-8','windows-1251',$path))){
        $data = [
            "fortable" => "doc_types",
            "plugin" => "Document",
            "tag" => "template",
            "created" => date("Y-m-d H:i:s"),
            "type" => "odt",
            "path" => $path,
            "bg" => $name
        ];

        \system\Data::insert(["data" => $data, "table" => $File->table]);
    } else {
        echo 'Грешка при качване на шаблон';
    }
}
?>
<script>history.go(-2);</script>