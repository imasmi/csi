<?php
namespace module\File;

class FileAPP extends File{

// General file functions
    public function accept(){
        $accept = implode(",", array_keys($this->accept_ini));
        return $accept;
    }

    public function files_dir($id, $link_id = 0){
        $path = isset($this->arr["path"]) ? $this->arr["path"] : "web/file/";
        return $path . ($link_id != 0 ? $link_id . '/' : "") . $id;
    }

    public function delete_dir($path) {
        $files = glob($path . '/*');
    	foreach ($files as $file) {
    		is_dir($file) ? $this->delete_dir($file) : unlink($file);
    	}
    	rmdir($path);
    	return;
    }

    public function copy_dir($src,$dst){
        $dir = opendir($src);
        if(!is_dir($dst)){mkdir($dst);}
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->copy_dir($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

/* ADD FILE FUNCTIONS */

    public function unique_file_name($dir, $name){
        $path = $dir . '/' . $name;
        if(!file_exists($path)){
            return $path;
        } else {
            $name = pathinfo($path)["filename"];
            $ext = pathinfo($path)["extension"];
            $cnt = 1;
            while(file_exists($dir . '/' .$name . "(" . $cnt . ")." . $ext)){
                $cnt++;
            }
            return $dir . '/' . $name . "(" . $cnt . ")." . $ext;
        }
    }

    # Part of input function for adding multiple files at once in form
    public function input_form($id, $path, $array=array()){
        ?>
        <div class="relative" id="<?php echo $path;?>">
            <input type="hidden" name="path" class="path" value="<?php echo $path;?>">
            <input type="hidden" name="<?php echo $path;?>" id="<?php echo $path;?>_origin">
            <div class="remove-preload" onclick="S('#preload_<?php echo $id;?>').removeChild(S('#<?php echo $path;?>'))">X</div>
            <div id="<?php echo $path?>_preload"></div>
            <div>Filetype: <span id="<?php echo $path;?>_filetype"></span></div>
            <div>Name</div>
            <input type="text" name="<?php echo $path?>_name" id="<?php echo $path?>_name">
            <?php if(isset($array["tag"])){?>
                <div>Tag</div>
                <input type="text" name="<?php echo $path;?>_tag" value="<?php if($array["tag"] != "true"){echo $array["tag"];}?>">
            <?php } ?>

            <?php if(isset($array["languages"])){
                foreach($GLOBALS["Language"]->items as $key => $value){
                ?>
                <div><?php echo $key;?></div>
                <input type="text" name="<?php echo $path;?>_<?php echo $value;?>">
            <?php }
                }?>
           </div>
        </div>
        <?php
    }

    /* Array possible values - link_id(int), multiple(true), accept(filetypes), tag(text), languages(true)*/
    public function input($id, $array=array()){
        $multiple = (isset($array["multiple"]) && $array["multiple"] === true) ? 1 : 0;
    ?>
        <div id="input-<?php echo $id?>" class="file-input">
            <div class="input-elements">
                <div id="<?php echo $id?>_0_loader" class="file-upload relative">
                    <div>Click or drop file<?Php if(isset($array["multiple"]) && $array["multiple"] === true){echo 's';}?> here</div>
                    <input type="file" name="<?php echo $id . '_0'; if($multiple == 1){ echo '[]';}?>" class="background input-attribute" <?php if($multiple == 1){ echo 'multiple';}?>
                    onchange='FileAPP.change(this, "<?php echo $id;?>", <?php echo json_encode($array);?>)'
                    accept="<?php echo (isset($array["accept"])) ? $array["accept"] : $this->accept();?>">
                </div>
            </div>
            <input type="hidden" id="last_input_<?php echo $id;?>" value="0"/>
            <input type="hidden" name="gallery_<?php echo $id;?>" value="<?php echo (isset($array["link_id"]) && is_numeric($array["link_id"])) ? $array["link_id"] : '0';?>"/>
            <input type="hidden" id="last_loaded_<?php echo $id;?>" value="0"/>
            <div class="file-edit" id="preload_<?php echo $id;?>"></div>
        </div>
    <?php
    }

    /* Array possible values - page_id(int), link_id(int), tag(string), path(string), accept(array with extension types)*/
    public function upload($array=array()){
        foreach($_FILES as $key=>$file){
            $file_key = explode("_", "image_1");
            unset($file_key[count($file_key) - 1]);
            $file_key = implode("_", $file_key);
            $page_id = isset($array["page_id"]) ? $array["page_id"] : (isset($_POST["gallery_" . $file_key]) ? $_POST["gallery_" . $file_key] : $this->page_id);
            $top_gallery_id = isset($_POST["gallery_" . $file_key]) ? \system\Data::top_id($_POST["gallery_" . $file_key], "link_id", "id", $this->table) : 0;
            $accept = isset($array["accept"]) ? isset($array["accept"]) : array_keys($this->accept_ini);
            if($top_gallery_id != 0){ $top_gallery = $this->PDO->query("SELECT * FROM " . $this->table . " WHERE id='" . $top_gallery_id . "'")->fetch();}
            if(isset($array["link_id"])){
                $link_id = $array["link_id"];
            } else {
                $link_id = $top_gallery_id;
            }

            $multiple = is_array($file["name"]);
            for($i = 0; $i < (($multiple === true) ? count($file["name"]) : 1); $i++){
                $path = $key . '_' . $i;
            # Select current file elements
                $name = ($multiple === true) ? $file["name"][$i] : $file["name"];
                $error = ($multiple === true) ? $file["error"][$i] : $file["error"];
                $type = ($multiple === true) ? $file["type"][$i] : $file["type"];
                $tmp_name = ($multiple === true) ? $file["tmp_name"][$i] : $file["tmp_name"];
                $size = ($multiple === true) ? $file["size"][$i] : $file["size"];

            # Add user choosed filename
                $ext = explode(".", $name);
                $ext = end($ext);

                $choosed_name = isset($_POST[$path . "_name"]) && $_POST[$path . "_name"] != "" ?  $_POST[$path . "_name"] . '.' . $ext : $name;

            # Check for tag case
                if(isset($array["tag"])){
                    $tag = $array["tag"];
                } elseif(isset($_POST[$path . "_tag"])){
                    $tag = $_POST[$path . "_tag"];
                } else {
                    $tag = NULL;
                }

                if(isset($_POST[$path]) && $_POST[$path] == $name){
                    $spilt_new_name = explode(".", $name);
                    $new_extension = $spilt_new_name[count($spilt_new_name) - 1];

                    if($error == "0"){
                        $mime = explode("/", $type);
                        if(in_array($type, $accept) || in_array($mime[0] . "/*", $accept)) {
                            $id = \system\Data::new_id($this->table);
                            $new_filePath = (isset($array["path"])) ? $array["path"] : $this->files_dir($id, $link_id); //$this->files_dir($file_dir) is the default value, use $array[path] only for custom file tables
                            $unique_file_path = $this->unique_file_name($new_filePath,$choosed_name);
                            $curFile = array("name" => $name, "path" => $unique_file_path, "error" => $error, "type" => $type, "tmp_name" => $tmp_name, "size" => $size);
                            $this->upload_file($curFile);

                            
                            $file_input = array("id" => $id, "page_id" => $page_id, "link_id" => $link_id, "user_id" => $GLOBALS["User"]->id, "created" => date("Y-m-d H:i:s"), "type" => $mime[0], "tag" => $tag, "path" => $unique_file_path);
                            if($this->fortable !== NULL){ $file_input["fortable"] = $this->fortable;}
                            if($this->plugin !== NULL){
                                $file_input["plugin"] = $this->plugin;
                            } elseif($top_gallery_id != 0 && $top_gallery["plugin"] !== NULL){
                                $file_input["plugin"] = $top_gallery["plugin"];
                            }
                            if($link_id != 0){$file_input["row"] = \system\Data::new_id($this->table, "row", " WHERE link_id='" . $link_id . "'");}
                            foreach($GLOBALS["Language"]->items as $language=>$abbreviation){
                                if(isset($_POST[$path . "_" . $abbreviation])){$file_input[$abbreviation] = $_POST[$path . "_" . $abbreviation];}
                            }
                            $insert_file = \system\Data::insert($file_input, $this->table);

                        } else {
                            echo 'Not accepted filetype - ' . $type;
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            }
        }
    }

    # File input edit in form for single file
    /* Array possible values - page_id, tag, path, languages, type, accept, full. *path, link_id will be included in future. */
    public function input_edit($file, $array = array()){
        require_once(\system\Core::doc_root() . "/system/module/Page/php/PageAPP.php");
        $PageAPP = new \module\Page\PageAPP;
        $file_dir = ($file["link_id"] == 0) ? $file["id"] : $file["link_id"];
        $file_setting = $this->setting($file);
        ?>
        <input type="file" class="hide" id="file_<?php echo $file["id"];?>" name="file_<?php echo $file["id"];?>"
        onchange="FileAPP.preload(this.files[0], '#preview_<?php echo $file["id"];?>'); var name = this.files[0].name.split('.'); S('#name_<?php echo $file["id"];?>').value = name.slice(0, -1).join('.');
        <?php if(isset($array["type"]) || isset($array["full"])){?>S('#type_<?php echo $file["id"];?>').value = this.files[0].type.split('/')[0];<?php }?>"
        accept="<?php echo (isset($array["accept"])) ? $array["accept"] : $this->accept();?>">

        <div class="text-center file-edit" id="preview_<?php echo $file["id"];?>"><?php echo $this->item($file["id"], array("preview" => true));?></div>
        <button onclick="document.getElementById('file_<?php echo $file["id"];?>').click()" type="button" class="center button">CHANGE</button>
        <br/>
        <div>Name</div>
        <input type="text" name="name_<?php echo $file["id"];?>" id="name_<?php echo $file["id"];?>" value="<?php echo pathinfo($file["path"])["filename"];?>" required/>
        <?php if(isset($array["type"]) || isset($array["full"])){?>
            <div>Type</div>
            <input type="text" name="type_<?php echo $file["id"];?>" id="type_<?php echo $file["id"];?>" value="<?php echo $file["type"];?>"/>
        <?php }?>

        <?php if(isset($array["tag"]) || isset($array["full"])){?>
            <div>Tag</div>
            <input type="text" name="tag_<?php echo $file["id"];?>" id="tag_<?php echo $file["id"];?>" value="<?php echo $file["tag"];?>"/>
        <?php }?>

        <?php if((isset($array["page_id"]) || isset($array["full"])) && $file["link_id"] == "0"){?>
            <div>Page</div>
            <?php

                echo $PageAPP->select("page_id_" . $file["id"], array("select" => $file["page_id"]));
            ?>
        <?php }?>

        <?php if(isset($array["languages"]) || isset($array["full"])){
            foreach($GLOBALS["Language"]->items as $lang => $abbrev){
        ?>
            <div><?php echo $lang;?> alt</div>
            <input type="text" name="<?php echo $abbrev;?>_<?php echo $file["id"];?>" id="<?php echo $abbrev;?>_<?php echo $file["id"];?>" value="<?php echo $file[$abbrev];?>"/>
        <?php
            }
        }?>
        
        <?php if($file["type"] === "image" || $file["type"] === "gallery"){
            $fit_select = isset($file_setting["fit-size"]) ? $file_setting["fit-size"] : false;
        ?>
            <div>Object fit / Background size</div>
            <select name="fit_size">
                <option value="">None</option>
                <option value="cover"<?php if($fit_select === "cover"){ echo ' selected';}?>>Cover</option>
                <option value="contain"<?php if($fit_select === "contain"){ echo ' selected';}?>>Contain</option>
            </select>
        <?php } ?>
        
        <?php if($file["type"] === "image"){?>
            <div>URL location</div>
            <input type="text" name="url_location" value="<?php if(isset($file_setting["url-location"])){ echo $file_setting["url-location"];}?>"/>
        <?php } ?>
    <?php
    }

    # File replace, array possible values (path(string), accept(array with extension types))
    public function upload_edit($array = array()){
        foreach($_FILES as $key=>$new_file){
            $id = ltrim($key, "file_");
            $file_select = $this->PDO->query("SELECT * FROM " . $this->table . " WHERE id='" . $id . "'")->fetch();
            if($new_file["name"] != "" && $new_file["size"] > 0){
                #UPLOAD NEW FILE AND UPDATE OPTIONS SPECIFIED FIELDS
                if($new_file["error"] == "0"){
                    $spilt_new_name = explode(".", $new_file["name"]);
                    $new_extension = $spilt_new_name[count($spilt_new_name) - 1];
                    
                    $accept_all_in_type = preg_replace('/(.*)\/(.*)/', '$1/*', $new_file["type"]);
                    $accepted_filetypes = isset($array["accept"]) ? array_flip($array["accept"]) : $this->accept_ini;
                    
                    if(array_key_exists($new_file["type"], $accepted_filetypes) || array_key_exists($accept_all_in_type, $accepted_filetypes)){
    					$file = array();
    					$file_name = ($_POST["name_" . $id] != "") ? $_POST["name_" . $id] . '.' . $new_extension : $new_file["name"];

    					$option_fields = array("page_id", "link_id", "type", "tag");
    					foreach($GLOBALS["Language"]->items as $lang => $abbrev){$option_fields[] = $abbrev;}
    					foreach($option_fields as $of){
    					    if(isset($_POST[$of . '_' . $id])){ $file[$of] = $_POST[$of . '_' . $id];}
    					}

    					$dir = (isset($array["path"])) ? $array["path"] : $this->files_dir($file_select["id"], $file_select["link_id"]); //$this->files_dir($file_dir) is default for file table, use $array["path"] only for custom paths
    					$file["path"] = $this->unique_file_name($dir,$file_name);
    					$mime = explode("/", $new_file["type"]);
    					$file["type"] = $mime[0];
                        #if($file["size"] > ini_get('upload_max_filesize')) { echo 'The file is to big, maximum allowed ' . ini_get('upload_max_filesize'); exit;}
                        if(file_exists($file_select["path"])){ $this->delete_dir(\system\Core::doc_root() . '/' . $dir);}
                        $new_file["path"] = $file["path"];
                        $this->upload_file($new_file);

                	    \system\Data::update($file, $id, "id", $this->table);
                	    
                	    //Update file settings
                        $this->setting_update($id);
                    } else {
                        echo 'Unsupported file format - ' . $new_file["type"];
                        exit;
                    }

                }
            } elseif($file_select !== false) {
            #UPDATE ONLY OPTIONS SPECIFIED FIELDS
                $file = array();
                $option_fields = array("page_id", "link_id", "type", "tag");
				foreach($GLOBALS["Language"]->items as $lang => $abbrev){$option_fields[] = $abbrev;}
				foreach($option_fields as $of){
				    if(isset($_POST[$of . '_' . $id])){ $file[$of] = $_POST[$of . '_' . $id];}
				}
                $pathinfo = pathinfo($file_select["path"]);
				if($_POST['name_' . $id] != $pathinfo["filename"]){
                    $file_dir = ($file["link_id"] == 0) ? $file["id"] : $file["link_id"];
    				$dir = (isset($array["path"])) ? $array["path"] : $this->files_dir($file["id"], $file["link_id"]);
    				$file["path"] = ((isset($_POST['path_' . $id])) ?  $_POST['path_' . $id] : $dir) . "/" . $file["name"];
    				rename($file_select["path"], $file["path"]);
                }
                //if(count($file) > 0){\system\Data::update($file, $id, "id", $this->table);}
                
                //Update file settings
                $this->setting_update($id);
            }
        }
    }
    
    private function setting_update($id){
        $setting_fields = array();
        if(isset($_POST["fit_size"])){$setting_fields["fit-size"] = $_POST["fit_size"];}
        if(isset($_POST["url_location"])){$setting_fields["url-location"] = $_POST["url_location"];}
        require_once(\system\Core::doc_root() . "/system/module/Setting/php/SettingAPP.php");
        $SettingAPP = new \module\Setting\SettingAPP($id, ["fortable" => $this->table]);
        $SettingAPP->save($setting_fields);
    }


    public function make_thumbnail($file, $new_name, $max_width=false, $max_height=false){
        $source_file= $file['tmp_name'];
		$type= $file['type'];
        // Takes the sourcefile (path/to/image.jpg) and makes a thumbnail from it
        // and places it at endfile (path/to/thumb.jpg).

        // Load image and get image size.

        //
        switch($type){
        	case'image/png':
        		$img = imagecreatefrompng($source_file);
        		break;
    		case'image/jpeg':
        		$img = imagecreatefromjpeg($source_file);
        		break;
    		case'image/gif':
        		$img = imagecreatefromgif($source_file);
        		break;
    		default :
    		return 'Unsupported format';
        }

        $width = imagesx( $img );
        $height = imagesy( $img );

        if ($width > $height || $max_height === false) {
            $new_width = ($width < $max_width) ? $width : $max_width;
            $divisor = $width / $new_width;
            $new_height = floor( $height / $divisor);
        } else {
        	$new_height = ($height < $max_height) ? $height : $max_height;
            $divisor = $height / $new_height;
            $new_width = floor( $width / $divisor );
        }

        // Create a new temporary image.
        $tmp_img = imagecreatetruecolor( $new_width, $new_height );
        if($type == "image/png" || $type == "image/gif") {
            $colour = imagecolorallocate($tmp_img,255,255,255);
            imagefill($tmp_img , 0, 0, $colour);
        }
        imagealphablending($tmp_img, true);
        imagesavealpha($tmp_img, true);
        // Copy and resize old image into new image.
        imagecopyresampled( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        // Save thumbnail into a file.
        //compressing the file
        imagewebp($tmp_img, $new_name);
        // release the memory
           imagedestroy($tmp_img);
           imagedestroy($img);
    }

    private function upload_file($file){
        $info = pathinfo($file["path"]);
        if(!is_dir($info["dirname"])){mkdir($info["dirname"], 0755, true);}
        if(($file["type"] == "image/jpeg" || $file["type"] == "image/png" || $file["type"] == "image/gif") && extension_loaded('gd')){
            $img_size = getimagesize($file["tmp_name"]);
            copy($file["tmp_name"], $file["path"]);
            foreach($this->imagesize as $size => $pixels){
                if($img_size[0] > $pixels){$this->make_thumbnail($file, $info["dirname"] . "/" . $info["filename"] . "_" . $size . ".webp", $pixels);}
            }
            $this->make_thumbnail($file, $info["dirname"] . "/" . $info["filename"] . ".webp", $img_size[0]);
            move_uploaded_file($file["tmp_name"], $file["path"]);
        } else {
            move_uploaded_file($file["tmp_name"], $file["path"]);
        }
    }
}
?>
