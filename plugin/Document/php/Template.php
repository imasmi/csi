<?php
namespace plugin\Document;

class Template{
    public function __construct($id=false){
        global $File;
        $this->File = $File;
        $this->table = $File->table;
        $this->path = "plugin/Document/file";
        $this->temp = \system\Core::doc_root() . "/temp/odt";

        if ($id) {
            $this->id = $id;
            $this->item = $GLOBALS["PDO"]->query("SELECT * FROM document WHERE id='{$this->id}'")->fetch();
        }
    }

    public function select($doc_type, $select = 0){
        $templates = $GLOBALS["PDO"]->query("SELECT template FROM doc_types WHERE id='$doc_type'")->fetch()["template"];
    ?>
        <select name="template">
            <option value="0">ИЗБЕРИ</option>
            <?php foreach (json_decode($templates, true) as $template) { ?>
                <option value="<?php echo $template;?>" <?php if ($template == $select) {echo 'selected';}?>><?php echo $GLOBALS["PDO"]->query("SELECT bg FROM {$GLOBALS["File"]->table} WHERE id='$template'")->fetch()["bg"];?></option>
            <?php } ?>
        </select>
    <?php
    }

    public function create($path){
        include_once \system\Core::doc_root() . "/system/module/File/php/ZipAPP.php";
        include_once \system\Core::doc_root() . "/system/module/File/php/FileAPP.php";

        $template_path = \system\Core::doc_root() . '/' . $GLOBALS["PDO"]->query("SELECT path FROM {$this->File->table} WHERE id='{$this->item["template"]}'")->fetch()["path"];
        $pathinfo = pathinfo($path);
        if  (!is_dir($pathinfo["dirname"])) {mkdir($pathinfo["dirname"], 0755, true);}
        copy($template_path, iconv("UTF-8", "windows-1251", $path));
        $odt_file = new \module\File\ZipAPP($path, $this->temp);
        $odt_file->unzip();
        $file = \system\Core::doc_root() . "/temp/odt/content.xml";

        file_put_contents($file,str_replace($this->find(), $this->replace(), file_get_contents($file)));
        $odt_new = new \module\File\ZipAPP($path, $this->temp, ["include" => $this->temp]);
        $odt_new->create();
        \module\File\FileAPP::delete_dir($this->temp);
    }

    private function find(){
        return [
            0 => "---Кратко-име-на-ЧСИ---",
            1 => "---Номер-ЧСИ---",
            2 => "---Район-на-действие-на-ЧСИ---",
            3 => "---Адрес-на-ЧСИ---",
            4 => "---Телефон-на-ЧСИ---",
            5 => "---ЧСИ-Емайл---",
            6 => "---Номера-изп-делo(a)---",
        ];
    }

    private function replace(){
        return [
            0 => "ЧСИ Георги Тарльовски",
            1 => "882",
            2 => "Пазарджик",
            3 => "гр. Пазарджик, п.к 4400, ул. „Иван Вазов“ № 1, ет. 2, офис № 8",
            4 => "034/918181",
            5 => "office@gtarlyovski.com",
            6 => $GLOBALS["PDO"]->query("SELECT number FROM caser WHERE id='{$this->item["case_id"]}'")->fetch()["number"],
        ];
    }
}
?>