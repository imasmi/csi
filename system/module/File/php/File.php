<?php
namespace system\module\File\php;

class File{
    //Array possible values: array(table => "string", fortable => string (database table), plugin => string (plugin name), "path" => string (location directory)), page_id => int (to select additional page_id texts, 0 is for global texts)
    public function __construct($page_id = false, $array = array()){
        global $PDO;
        $this->PDO = $PDO;
        global $Core;
        $this->Core = $Core;
        global $Query;
        $this->Query = $Query;
        global $User;
        $this->User = $User;
        global $Page;
        $this->Page = $Page;
        global $Language;
        $this->Language = $Language;
        $this->empty_file = "system/module/File/file/camera.png";
        $this->table = (isset($array["table"])) ? $array["table"] : $Query->table("file");
        $this->fortable = isset($array["fortable"]) ? $array["fortable"] : NULL;
        $this->plugin = isset($array["plugin"]) ? $array["plugin"] : NULL;
        $this->arr = $array;
        $this->page_id = ($page_id !== false) ? $page_id : $this->Page->id;
        $this->items = $this->items($this->page_id);
        $this->accept_ini = parse_ini_file($this->Core->doc_root() . "/system/ini/accept.ini");
        $this->imagesize_default = array("S" => 768, "M" => 1280, "L" => 1920, "XL" => 2400);
        if(file_exists($Core->doc_root() . "/web/ini/imagesize.ini")){
            $this->imagesize = array();
            foreach(parse_ini_file($Core->doc_root() . "/web/ini/imagesize.ini") as $size => $option){
                $this->imagesize[$size] = isset($option["width"]) ? $option["width"] : $this->imagesize_default[$size];
            }
        } else {
            $this->imagesize = $this->imagesize_default;
        }
    }

    public function items($page_id=false, $link_id=0){
        $files = array();
        $fortable = $this->fortable === NULL ? "fortable IS NULL" : "fortable='" . $this->fortable ."'";
        if($page_id !== false){
            $page_id_select = isset($this->arr["page_id"]) ? " (page_id='" . $this->arr["page_id"] . "' OR page_id='" . $page_id . "') AND" : " page_id='" . $page_id . "' AND";
        } else {
            $page_id_select = "";
        }
        
        foreach($this->PDO->query("SELECT *  FROM " . $this->table .  " WHERE" . $page_id_select . " link_id=" . $link_id . " ORDER by `row` ASC, id ASC ", \PDO::FETCH_ASSOC) as $file){
            $indexes = array("id", "tag");
            if($file["path"] == NULL && $this->User->_() == "admin"){$file["path"] = $this->empty_file;}
            $files[$file["id"]] = $file;
            if(isset($file["tag"]) && (!isset($files[$file["tag"]]) || $file["page_id"] == $this->page_id)){$files[$file["tag"]] = $file;}
            if($file["type"] == "gallery"){
                $link_ids = $this->items(false, $file["id"]);
                if(!empty($link_ids)){$files = array_replace($files, $link_ids);}
            }
        }
        return $files;
    }
    
    public function gallery($key){
        $files=array();
        $id = is_numeric($key) ? $key : $this->items[$key]["id"];
        foreach($this->items as $key=>$file){
            if($file["link_id"] == $id){
                $files[$key] = $file;
            }
        }
        return $files;
    }
	
	/* TRIGGER PICTURE UPDATER */
	public function trigger_file($id){
	    #return 'onmousedown="FileAPP.moveStart(event, ' . $this->items[$id]["id"] . ')" onmouseup="FileAPP.moveSafe(' . $this->items[$id]["id"] . ')" onmouseleave="FileAPP.moveStop(' . $this->items[$id]["id"] . ')" ondblclick="FileAPP.updateFile(' . $this->items[$id]["id"] . ')" title="Click to add image"';
	    return ' ondblclick="FileAPP.updateFile(' . $this->items[$id]["id"] . ')" title="Click to add image"';
	}
	
	//Default File types: video, image, audio, text, application, gallery, page_id => int|true (int for concrete page_id or true for $this->page_id to be applied)
	public function item($id, $array = array("edit" => false)){
			$id = $this->id($id, $array);
			$file = isset($this->items[$id]) ? $this->items[$id] : $this->Query->select($id, "id", $this->table);
			if($file["type"] == "gallery"){foreach($this->items as $gal_files){if($file["id"] == $gal_files["link_id"]){$file = $gal_files; break;}}}
			if($file["path"] == null){return false;}
            $edit = (isset($array["edit"]) && $array["edit"] === true && $this->User->_() == "admin") ? true : false;
            $trigger_file = $edit === true ? $this->trigger_file($id) : "";
            $name = (isset($file[$this->Language->_()]) && $file[$this->Language->_()] != "") ? $file[$this->Language->_()] : $file["name"];
            
            $style = 'class="' . $file["type"]  . ($file["path"] == $this->empty_file ? ' empty-file' : ''). '" id="file' . $file["id"] . '"';
            $output = '<div class="File">';
			if($file["type"] == "video"){
			    $controls = ($this->User->role != "admin") ? ' controls' : '';
			    $autoplay = ($this->User->role != "admin" && $array["autoplay"]) ? " autoplay muted" : ""; 
				$output .= '<video ' . $style . $controls . $autoplay . ' playsinline title="' . $file[$this->Language->_()] . '" ' . $trigger_file . '>';
				$output .= '<source src="' . $this->Core->url() . $file["path"] . '" type="video/mp4">';
				$output .= 'Your browser does not support the video tag.';
				$output .= '</video>';
			} elseif($file["type"] == "image"){
			    $output .= '<picture id="picture-' . $file["id"] . '">';
			        $info = pathinfo($file["path"]);
			        if(isset($file["path"]) && $file["path"] != null && (!isset($array["resize"]) || $array["resize"] !== false)){
    			        foreach($this->imagesize as $size => $pixels){
                            $newName = $info["dirname"] . '/' . $info["filename"] . '_' . $size . '.' . $info["extension"];
                            if(file_exists($newName)){$output .= '<source media="(max-width: ' . ($pixels - 200) . 'px)" srcset="' . $this->Core->url() . str_replace(" ", "%20", $newName) . '">';}
                        }
			        }
                    $output .= '<img ' . $style . ' src="' . $this->Core->url() .$file["path"] . '" ' . $trigger_file . ' alt="' . $file[$this->Language->_()] . '" title="' . $file[$this->Language->_()] . '">';
                $output .= '</picture>';
			} elseif($file["type"] == "audio"){
			    if($edit === false){
    				$output .= '<div ' . $style . ' style="background-image: url(\'' . $this->Core->url() . 'system/module/File/file/notes.jpg\')" title="' . $name . '">' . $name . '</div>';
			    } else {
			        $output .= '<audio ' . $style . ' controls title="' . $file[$this->Language->_()] . '">';
    				$output .= '<source src="' . $this->Core->url() . $file["path"] . '" type="audio/ogg">';
    				$output .= '<source src="' . $this->Core->url() . $file["path"] . '" type="audio/mpeg">';
    				$output .= 'Your browser does not support the audio tag.';
    				$output .= '</audio>';
			    }
			} elseif($file["type"] == "text" || $file["type"] == "application"){
			    if($edit === false){
    			    $output .= '<a href="' . $this->Core->url() . $file["path"] . '" target="blank" ' . $style . ' title="' . $name . '" download>' . $name . '</a>';
			    } else {
			        echo $file["name"];
			    }
		    }
			$output .= '</div>';
			return $output;
	}
	
	public function insert_file($id){
        if($this->User->_() == "admin"){
            $add_file = $this->PDO->prepare("INSERT INTO " . $this->table .  " (page_id, fortable, plugin, tag, `type`, created) VALUES ('" . $this->page_id . "', " . ($this->fortable === NULL ? "NULL" : "'" . $this->fortable . "'") . ",  " . ($this->plugin === NULL ? "NULL" : "'" . $this->plugin . "'") . ", :tag, 'image', '" . date("Y-m-d H:i:s") . "')");
            $add_file->execute(array("tag" => $id));
        }
        
        return array(
                "id" => ($this->User->_() == "admin") ? $this->PDO->lastInsertId() : 0,
                "link_id" => "0",
                "fortable" => $this->fortable,
                "plugin" => $this->plugin,
                "tag" => $id,
                "type" => "image",
                "name" => NULL,
                "path" => $this->empty_file,
                $this->Language->_() => NULL
            );
	}
    
    public function id($id, $array=false){
        if(is_numeric($id)){return $id;}
        
        if(isset($this->items[$id])){
            if(isset($array["page_id"])){
                $page_id = $array["page_id"] === true || !is_numeric($array["page_id"])? $this->page_id :  $array["page_id"];
                foreach($this->items as $file_id => $item){
                    if($item["tag"] == $id && $item["page_id"] == $page_id){ return $item["id"];}
                }
            } else {
                return $this->items[$id]["id"];
            }
        }
        
        if(http_response_code() != '404'){
            $new_file = $this->insert_file($id);
            $this->items[$new_file["id"]] = $new_file;
            return $new_file["id"];
        }
    }
    
    //Array possible values (column=>single database column or * for all (return type), page_id => int|true (int for concrete page_id or true for $this->page_id to be applied), resize=>true|false(true is default))
	public function _($id, $array=array("edit" => true)){
	    $id = $this->id($id, $array);
	    if(isset($array["column"])){
	        if($array["column"] == "*"){
	            return $this->items[$id];
	        } else {
	            return $this->items[$id][$array["column"]];
	        }
	    } else {
	        return $this->item($id, $array);
	    }
	    return false;
	}
}

$File = new File($Page->id, array("page_id" => 0));
?>