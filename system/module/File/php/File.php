<?php
namespace module\File;

class File{
    //Array possible values: array(table => "string", fortable => string (database table), plugin => string (plugin name), "path" => string (location directory)), page_id => int (to select additional page_id texts, 0 is for global texts)
    public function __construct($page_id = false, $array = array()){
        global $PDO;
        $this->PDO = $PDO;
        global $Page;
        $this->Page = $Page;
        $this->empty_file = "system/module/File/file/camera.png";
        $this->table = (isset($array["table"])) ? $array["table"] : \system\Database::table("file");
        $this->fortable = isset($array["fortable"]) ? $array["fortable"] : NULL;
        $this->plugin = isset($array["plugin"]) ? $array["plugin"] : NULL;
        $this->arr = $array;
        $this->page_id = ($page_id !== false) ? $page_id : $this->Page->id;
        $this->items = $this->items($this->page_id);
        $this->accept_ini = parse_ini_file(\system\Core::doc_root() . "/system/ini/accept.ini");
        $this->imagesize_default = array("S" => 768, "M" => 1280, "L" => 1920, "XL" => 2400);
        if(file_exists(\system\Core::doc_root() . "/web/ini/imagesize.ini")){
            $this->imagesize = array();
            foreach(parse_ini_file(\system\Core::doc_root() . "/web/ini/imagesize.ini") as $size => $option){
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
            if($file["path"] == NULL && \module\User\User::group("admin")){$file["path"] = $this->empty_file;}
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
	    return ' onclick="FileAPP.updateFile(' . $id . ')" title="Click to add image"';
	}
	
	public function setting($file){
	    $file_setting = [];
        if($file["type"] == "video" || $file["type"] == "image"){
            foreach($this->PDO->query("SELECT tag, value FROM " . $GLOBALS["Setting"]->table . " WHERE fortable='" . $this->table ."' AND page_id='" . $file["id"] . "'") as $file_settings){
                $file_setting[$file_settings["tag"]] = $file_settings["value"];
            }
        }
        return $file_setting;
	}

	//Default File types: video, image, audio, text, application, gallery, page_id => int|true (int for concrete page_id or true for $this->page_id to be applied)
	public function item($id, $array = array("edit" => false)){
			$id = $this->id($id, $array);
			$file = isset($this->items[$id]) ? $this->items[$id] : $this->PDO->query("SELECT * FROM " . $this->table . " WHERE id='" . $id . "'")->fetch();
			if($file["type"] == "gallery"){
			    $gallery = $this->gallery($id);
			    if(!empty($gallery)){
			        return $this->item(key($gallery), $array);
			    } else {
			        return '<img src="' . \system\Core::url() . $this->empty_file . '" class="image empty-file"/>';
			    }
			}
			if($file["path"] == null){return false;}
			$file_setting = $this->setting($file);
			$info = pathinfo($file["path"]);
            $edit = \module\User\User::group("admin") && (!isset($array["edit"]) || $array["edit"] !== false) ? true : false;
            $trigger_file = $edit === true ? $this->trigger_file($id) : "";
            $name = (isset($file[\module\Language\Language::_()]) && $file[\module\Language\Language::_()] != "") ? $file[\module\Language\Language::_()] : $info["filename"];

            $style = 'class="' . $file["type"]  . ($file["path"] == $this->empty_file ? ' empty-file' : ''). '" id="file' . $file["id"] . '"';
            $fit_size = isset($file_setting["fit-size"]) ? ' ' . $file_setting["fit-size"] : '';
            
            if(isset($file_setting["url-location"]) && !\module\User\User::group("admin")){
                $output = '<a class="File block' . $fit_size . '" href="' . (strpos($file_setting["url-location"], "http") !== false ? $file_setting["url-location"] : 'https://' . $file_setting["url-location"]) . '" target="blank">';
            } else {
                $output = '<div class="File' . $fit_size . '">';
            }
			if($file["type"] == "video"){
			    $controls = (!\module\User\User::group("admin")) ? ' controls' : '';
			    $autoplay = (!\module\User\User::group("admin") && $array["autoplay"]) ? " autoplay muted" : "";
				$output .= '<video ' . $style . $controls . $autoplay . ' playsinline title="' . $file[\module\Language\Language::_()] . '" ' . $trigger_file . '>';
				$output .= '<source src="' . \system\Core::url() . $file["path"] . '" type="video/mp4">';
				$output .= 'Your browser does not support the video tag.';
				$output .= '</video>';
			} elseif($file["type"] == "image"){
			    $output .= '<picture id="picture-' . $file["id"] . '">';
			        if (isset($array["size"]) && file_exists($info["dirname"] . '/' . $info["filename"] . '_' . $array["size"] . '.' . $info["extension"])) {
			            $output .= '<img ' . $style . ' src="' . \system\Core::url() . $info["dirname"] . '/' . $info["filename"] . '_' . $array["size"] . '.' . $info["extension"] . '" ' . $trigger_file . ' alt="' . $file[\module\Language\Language::_()] . '" title="' . $file[\module\Language\Language::_()] . '">';
			        } else {
			            if(isset($file["path"]) && $file["path"] != null && (!isset($array["resize"]) || $array["resize"] !== false)){
        			        foreach($this->imagesize as $size => $pixels){
                                $newName = $info["dirname"] . '/' . $info["filename"] . '_' . $size . '.' . $info["extension"];
                                if(file_exists($newName)){$output .= '<source media="(max-width: ' . ($pixels - 200) . 'px)" srcset="' . \system\Core::url() . str_replace(" ", "%20", $newName) . '">';}
                            }
    			        }
                        $output .= '<img ' . $style . ' src="' . \system\Core::url() .$file["path"] . '" ' . $trigger_file . ' alt="' . $file[\module\Language\Language::_()] . '" title="' . $file[\module\Language\Language::_()] . '">';
			        }
			    $output .= '</picture>';
			} elseif($file["type"] == "audio"){
			    if($edit === false){
    				$output .= '<div ' . $style . ' style="background-image: url(\'' . \system\Core::url() . 'system/module/File/file/notes.jpg\')" title="' . $name . '">' . $name . '</div>';
			    } else {
			        $output .= '<audio ' . $style . ' controls title="' . $file[\module\Language\Language::_()] . '">';
    				$output .= '<source src="' . \system\Core::url() . $file["path"] . '" type="audio/ogg">';
    				$output .= '<source src="' . \system\Core::url() . $file["path"] . '" type="audio/mpeg">';
    				$output .= 'Your browser does not support the audio tag.';
    				$output .= '</audio>';
			    }
			} elseif($file["type"] == "text" || $file["type"] == "application"){
			    if($edit === false){
    			    $output .= '<a href="' . \system\Core::url() . $file["path"] . '" target="blank" ' . $style . ' title="' . $name . '" download>' . $name . '</a>';
			    } else {
			        echo $info["filename"];
			    }
		    }
		    if(isset($file_setting["url-location"]) && !\module\User\User::group("admin")){
			    $output .= '</a>';
		    } else {
		        $output .= '</div>';
		    }
			return $output;
	}

	public function insert_file($id){
        if(\module\User\User::group("admin")){
            $page_id = isset($this->arr["page_id"]) ? $this->arr["page_id"] : $this->page_id;
            $add_file = $this->PDO->prepare("INSERT INTO " . $this->table .  " (page_id, fortable, plugin, tag, `type`, created) VALUES ('" . $page_id . "', " . ($this->fortable === NULL ? "NULL" : "'" . $this->fortable . "'") . ",  " . ($this->plugin === NULL ? "NULL" : "'" . $this->plugin . "'") . ", :tag, 'image', '" . date("Y-m-d H:i:s") . "')");
            $add_file->execute(array("tag" => $id));
        }

        return array(
                "id" => (\module\User\User::group("admin")) ? $this->PDO->lastInsertId() : 0,
                "link_id" => "0",
                "fortable" => $this->fortable,
                "plugin" => $this->plugin,
                "tag" => $id,
                "type" => "image",
                "path" => $this->empty_file,
                \module\Language\Language::_() => NULL
            );
	}

    public function id($id, $array=false){
        if(is_numeric($id)){return $id;}

        if(isset($this->items[$id])){
            if(isset($array["page_id"])){
                $page_id = $array["page_id"] === true || !is_numeric($array["page_id"]) ? $this->page_id :  $array["page_id"];
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
	public function _($id, $array = []){
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
?>
