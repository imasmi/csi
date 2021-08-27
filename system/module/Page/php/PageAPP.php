<?php
namespace system\module\Page\php;

class PageAPP{
    
    public function __construct(){
        global $PDO;
        $this->PDO = $PDO;
        global $Core;
        $this->Core = $Core;
        global $Query;
        $this->Query = $Query;
        global $Form;
        $this->Form = $Form;
        global $Page;
        $this->Page = $Page;
    }
    
    public function url_format($string){
        $CodeAPP = new \system\module\Code\php\CodeAPP;
        $string = strip_tags($string);
        $string = html_entity_decode($string);
        $string = preg_replace('/\s+/', '-', $string);
        $string = $CodeAPP->special_characters_remove($string);
        $string = trim($string);
        return $string;
    }
    
    public function select($name="page_id", $array = array()){
        $Text = new \system\module\Text\php\Text(0);
        $pages = array(0 => $Text->item("Select nonе"));
        $query = isset($array["query"]) !== false ? $array["query"] : "SELECT id FROM " . $this->Page->table . " ORDER by link_id ASC";
        foreach($this->PDO->query($query) as $page){
            $pages[$page["id"]] =  $this->Page->map($page["id"]);
        }
        $select_array = array("select" => isset($array["select"]) ? $array["select"] : 0);
        $this->Form->select($name, $pages, $select_array);
    }
}
?>