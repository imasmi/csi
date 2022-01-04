<?php
namespace module\Page;

class PageAPP{

    public function __construct(){
        global $PDO;
        $this->PDO = $PDO;
        global $Page;
        $this->Page = $Page;
    }

    public function url_format($string){
        require_once(\system\Core::doc_root() . "/system/module/Code/php/CodeAPP.php");
        $CodeAPP = new \module\Code\CodeAPP;
        $string = html_entity_decode($string);
        $string = strip_tags($string);
        $string = preg_replace(['/\s+/', '/-+/'], '-', $string);
        $string = $CodeAPP->special_characters_remove($string);
        $string = trim($string);
        return $string;
    }

    public function select($name="page_id", $array = array()){
        include_once(\system\Core::doc_root() . "/system/php/Form.php");
        $Form = new \system\Form;
        $Text = new \module\Text\Text(0);
        $pages = array(0 => $Text->item("Select nonе"));
        $query = isset($array["query"]) !== false ? $array["query"] : "SELECT id FROM " . $this->Page->table . " ORDER by link_id ASC";
        foreach($this->PDO->query($query) as $page){
            $pages[$page["id"]] =  $this->Page->map($page["id"]);
        }
        $select_array = array("select" => isset($array["select"]) ? $array["select"] : 0);
        \system\Form::select($name, $pages, $select_array);
    }
}
?>
