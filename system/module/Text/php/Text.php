<?php
namespace module\Text;

class Text{
    private $PDO;
    //Array possible values: table => "string", fortable => string, plugin => string, page_id => int (to select additional texts from another page, 0 is for global texts)
    public function __construct($page_id=false, $array = array()){
        global $PDO;
        $this->PDO = $PDO;
        global $Language;
        $this->Language = $Language;
        global $Page;
        $this->Page = $Page;
        $this->page_id = $page_id !== false ? $page_id : $Page->_();
        $this->table = (isset($array["table"])) ? $array["table"] : \system\Data::table("text");
        $this->fortable = isset($array["fortable"]) ? $array["fortable"] : NULL;
        $this->plugin = isset($array["plugin"]) ? $array["plugin"] : NULL;
        $this->arr = $array;
        $this->items = $this->items();
    }

    public function items(){
        $texts = array();
        $fortable = $this->fortable === NULL ? "fortable IS NULL" : "fortable='" . $this->fortable ."'";
        $page_id = isset($this->arr["page_id"]) ? " ((page_id='" . $this->arr["page_id"] . "' AND link_id=0) OR page_id='" . $this->page_id . "') " : " page_id='" . $this->page_id . "' ";
        foreach($this->PDO->query("SELECT *  FROM " . $this->table .  " WHERE " . $page_id . " AND " . $fortable . " ORDER by id ASC") as $text){
            $outText = ($text[\module\Language\Language::_()] != "") ? $text[\module\Language\Language::_()] : $text["tag"];
            $texts[$text["id"]] = $text;
            $texts[$text["tag"]] = $text;
        }
        return $texts;
    }

    public function id($id, $array=false){
        if(is_numeric($id)){return $id;}

        if(isset($this->items[$id])){
            if(isset($array["page_id"])){
                $page_id = $array["page_id"] === true || !is_numeric($array["page_id"])? $this->page_id : $array["page_id"];
                foreach($this->items as $text_id => $item){
                    if($item["tag"] == $id && $item["page_id"] == $page_id){ return $item["id"];}
                }
            } else {
                return $this->items[$id]["id"];
            }
        }

        if(http_response_code() != '404'){
            $check_tag = $this->PDO->query("SELECT * FROM " . $this->table . " WHERE tag='" . $id . "' AND fortable IS NULL");
            if($check_tag->rowCount() > 0 && !isset($array["page_id"]) && (isset($this->arr["page_id"]) && $this->arr["page_id"] == 0)){
                $tag = $check_tag->fetch();
                \system\Data::update(array("page_id" => "0"), $tag["id"], "id", $this->table);
                $this->items[$tag["id"]] = $tag;
                $this->items[$id] = $tag;
                return $tag["id"];
            } else {
                return $this->insert_text($id);
            }
        }
        return false;
    }

    public function insert_text($text){
        $add_text = $this->PDO->prepare("INSERT INTO " . $this->table .  " (page_id, tag, fortable, plugin) VALUES ('" . $this->page_id . "', :tag, " . ($this->fortable === NULL ? "NULL" : "'" . $this->fortable . "'") . ", " . ($this->plugin === NULL ? "NULL" : "'" . $this->plugin . "'") . ")");
        $add_text->execute(array("tag" => $text));
        $id = $this->PDO->lastInsertId();
        $new_text = array("id" => $id, "tag" => $text, "page_id" => $this->page_id, "fortable" => $this->fortable, "plugin" => $this->plugin, \module\Language\Language::_() => NULL);
        $this->items[$id] = $new_text;
        $this->items[$text] = $new_text;
        return $id;
    }

    /* EDIT TEXT ON CURRENT LANGUAGE */
	public function edit_text($id){
		if(\module\User\User::group("admin")){
			return ' onmousedown="TextAPP.showWysiwyg(event, ' .$id . ')" onkeydown="TextAPP.keyControl(event)" contenteditable id="text-edit-' . $id . '"';
		}
	}

	public function lang_editor($id){
        if(count($this->Language->items) > 1 && \module\User\User::group("admin")){
	        $output = '<div class="language-editor" id="language-editor-' . $id . '">';
                foreach($this->Language->items as $key => $value){
                    $selected_language = ($value == \module\Language\Language::_()) ? ' selected-text-lang' : "";
                    $output .= '<span class="lang-changer' . $selected_language . '" id="lang-changer-' . $value . '-' . $id . '" onclick="TextAPP.langChange(\'' . $id . '\', \'' . $value . '\')">' . $key . '</span>';
                }
                $output .= '<input type="hidden" id="text-lang-' . $id . '" value="' . \module\Language\Language::_() . '"/>';
            $output .= '</div>';
            return $output;
        } elseif(\module\User\User::group("admin")) {
	      return '<input type="hidden" id="text-lang-' . $id . '" value="' . \module\Language\Language::_() . '"/>';
        } else {
            return false;
        }
	}

	public function item($text, $array=array()){
	    $id = $this->id($text, $array);
        if(isset($this->items[$id])){
            return $this->items[$id][\module\Language\Language::_()] == NULL  && $this->items[$id]["page_id"] == 0 && !isset($array["strict"]) ? $this->items[$id]["tag"] : $this->items[$id][\module\Language\Language::_()];
        }

        return false;
    }

	/* SHORT TEXT FUNCTION */
	#array options: page_id => int|true (int for concrete page_id or true for $this->page_id to be applied), setting => true, url => (false|true), strict => boolean (set to true to show only filled texts with page_id=0)
	//setting: changes text and setting with same $text tag and page_id on current language
	/*url: if set changes the url for this page on current lanhuage
	if url is set to true and changed text is on current language also changes the browser url*/
	public function _($text, $array=array()){
	    $id = $this->id($text, $array);
	    $output = "";
	    if(\module\User\User::group("admin")){ $output .= '<div class="text-wrapper inline-block">';}
	    $output .= $this->lang_editor($id);
		$output .= '<div class="Text inline-block" ' . $this->edit_text($id, $array) . '>';
		    $output .= $this->item(($id !== false) ? $id : $text, $array);
		$output .= "</div>";
		if(!empty($array) && \module\User\User::group("admin")){
		    if(!isset($array["plugin"]) && $this->plugin !== NULL){$array["plugin"] = $this->plugin;}
		    $output .= "<input type='hidden' id='text-options-" . $id . "' value='" . json_encode( $array) . "'/>";
		}
		if(\module\User\User::group("admin")){
		    $output .= '</div>';
		    if(isset($array["setting"]) || isset($array["url"])){
		        $info_text = "";
		        if(isset($array["setting"])){ $info_text .= "Updating this text will also change this page <b>" . $text  . "</b> setting in the current language. <br> You can manually set different <b>" . $text  . "</b> setting afterwards in Page settings. <br/>";}
		        if(isset($array["url"])){ $info_text .= "Updating this text will also change this page URL. You can manually set different url afterward in Page edit. <br/> * Changing URL is dangerous and not recommended as it will reset your SEO rank in search engines for the current page. Do not change your URL after initial set!";}
		        require_once(\system\Core::doc_root() . "/system/php/Info.php");
		        $Info = new \system\Info;
		        $output .= \system\Info::_($info_text);

		    }
		}
		return $output;
	}

}
?>
