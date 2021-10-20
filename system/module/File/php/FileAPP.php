<?php
namespace system\module\File\php;

class FileAPP extends \system\module\File\php\File{

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
        if(is_dir($path)){
            $files = glob($path . '/*');
            foreach ($files as $file) {
                is_dir($file) ? $this->delete_dir($file) : unlink($file);
            }
            rmdir($path);
        }
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
                foreach($this->Language->items as $key => $value){
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
            $top_gallery_id = isset($_POST["gallery_" . $file_key]) ? $this->Query->top_id($_POST["gallery_" . $file_key], "link_id", "id", $this->table) : 0;
            if($top_gallery_id != 0){ $top_gallery = $this->Query->select($top_gallery_id, "id", $this->table);}
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
                        if((isset($array["accept"]) && (in_array($new_extension, $array["accept"]) || array_key_exists($type, $array["accept"]))) || 
                        (!isset($array["accept"]) && (isset($this->accept_ini[$type]) && ($this->accept_ini[$type] == mb_strtolower($new_extension) || $this->accept_ini[$type] == "*")))) {
                            $id = $this->Query->new_id($this->table);
                            $new_filePath = (isset($array["path"])) ? $array["path"] : $this->files_dir($id, $link_id); //$this->files_dir($file_dir) is the default value, use $array[path] only for custom file tables
                            $unique_file_path = $this->unique_file_name($new_filePath,$choosed_name);
                            $curFile = array("name" => $name, "path" => $unique_file_path, "error" => $error, "type" => $type, "tmp_name" => $tmp_name, "size" => $size);
                            $this->upload_file($curFile);
                            
                            $mime = explode("/", $type);
                            $file_input = array("id" => $id, "page_id" => $page_id, "link_id" => $link_id, "user_id" => $this->User->id, "created" => date("Y-m-d H:i:s"), "type" => $mime[0], "tag" => $tag, "name" => $choosed_name, "path" => $unique_file_path);
                            if($this->fortable !== NULL){ $file_input["fortable"] = $this->fortable;}
                            if($this->plugin !== NULL){
                                $file_input["plugin"] = $this->plugin;
                            } elseif($top_gallery_id != 0 && $top_gallery["plugin"] !== NULL){
                                $file_input["plugin"] = $top_gallery["plugin"];
                            }
                            if($link_id != 0){$file_input["row"] = $this->Query->new_id($this->table, "row", " WHERE link_id='" . $link_id . "'");}
                            foreach($this->Language->items as $language=>$abbreviation){
                                if(isset($_POST[$path . "_" . $abbreviation])){$file_input[$abbreviation] = $_POST[$path . "_" . $abbreviation];}
                            }
                            $insert_file = $this->Query->insert($file_input, $this->table);
                            
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
    public function input_edit($file, $array = array()){ ?>
        <?php $file_dir = ($file["link_id"] == 0) ? $file["id"] : $file["link_id"];?>
        
        <input type="file" class="hide" id="file_<?php echo $file["id"];?>" name="file_<?php echo $file["id"];?>" 
        onchange="FileAPP.preload(this.files[0], '#preview_<?php echo $file["id"];?>'); var name = this.files[0].name.split('.'); S('#name_<?php echo $file["id"];?>').value = name.slice(0, -1).join('.'); 
        <?php if(isset($array["type"]) || isset($array["full"])){?>S('#type_<?php echo $file["id"];?>').value = this.files[0].type.split('/')[0];<?php }?>" 
        accept="<?php echo (isset($array["accept"])) ? $array["accept"] : $this->accept();?>">
        
        <div class="text-center file-edit" id="preview_<?php echo $file["id"];?>"><?php echo $this->item($file["id"], array("preview" => true));?></div>
        <button onclick="document.getElementById('file_<?php echo $file["id"];?>').click()" type="button" class="center button">CHANGE</button>
        <br/>
        <div>Name</div>
        <input type="text" name="name_<?php echo $file["id"];?>" id="name_<?php echo $file["id"];?>" value="<?php echo pathinfo($file["name"])["filename"];?>" required/>
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
                $PageAPP = new \system\module\Page\php\PageAPP;
                echo $PageAPP->select("page_id_" . $file["id"], array("select" => $file["page_id"]));
            ?>
        <?php }?>
        
        <?php if(isset($array["languages"]) || isset($array["full"])){
            foreach($this->Language->items as $lang => $abbrev){
        ?>
            <div><?php echo $lang;?> alt</div>
            <input type="text" name="<?php echo $abbrev;?>_<?php echo $file["id"];?>" id="<?php echo $abbrev;?>_<?php echo $file["id"];?>" value="<?php echo $file[$abbrev];?>"/>
        <?php 
            }
        }?>
    <?php
    }

    # File replace, array possible values (path(string), accept(array with extension types)) 
    public function upload_edit($array = array()){
        foreach($_FILES as $key=>$new_file){
            $id = ltrim($key, "file_");
            $file_select = $this->Query->select($id, "id", $this->table);
            if($new_file["name"] != "" && $new_file["size"] > 0){
                #UPLOAD NEW FILE AND UPDATE OPTIONS SPECIFIED FIELDS
                if($new_file["error"] == "0"){
                    $spilt_new_name = explode(".", $new_file["name"]);
                    $new_extension = $spilt_new_name[count($spilt_new_name) - 1];
                    if((isset($array["accept"]) && (in_array($new_extension, $array["accept"]) || array_key_exists($new_file["type"], $array["accept"]))) || 
                    (!isset($array["accept"]) && (isset($this->accept_ini[$new_file["type"]]) && ($this->accept_ini[$new_file["type"]] == mb_strtolower($new_extension) || $this->accept_ini[$new_file["type"]] == "*")))) {
    					$file = array();
    					$file["name"] = ($_POST["name_" . $id] != "") ? $_POST["name_" . $id] . '.' . $new_extension : $new_file["name"];
    					
    					$option_fields = array("page_id", "link_id", "type", "tag");
    					foreach($this->Language->items as $lang => $abbrev){$option_fields[] = $abbrev;}
    					foreach($option_fields as $of){
    					    if(isset($_POST[$of . '_' . $id])){ $file[$of] = $_POST[$of . '_' . $id];}
    					}
    					
    					$dir = (isset($array["path"])) ? $array["path"] : $this->files_dir($file_select["id"], $file_select["link_id"]); //$this->files_dir($file_dir) is default for file table, use $array["path"] only for custom paths
    					$file["path"] = $this->unique_file_name($dir,$file["name"]);
    					$mime = explode("/", $new_file["type"]);
    					$file["type"] = $mime[0];
                        #if($file["size"] > ini_get('upload_max_filesize')) { echo 'The file is to big, maximum allowed ' . ini_get('upload_max_filesize'); exit;}
                        if(file_exists($file_select["path"])){ $this->delete_dir($this->Core->doc_root() . '/' . $dir);}
                        $new_file["path"] = $file["path"];
                        $this->upload_file($new_file);
                        
                	    $this->Query->update($file, $id, "id", $this->table);  
                    } else {
                        echo 'Unsupported file format - ' . $new_file["type"];
                        exit;
                    }
                    
                }
            } elseif($file_select !== false) {
            #UPDATE ONLY OPTIONS SPECIFIED FIELDS
                $file = array();
                $option_fields = array("page_id", "link_id", "type", "tag");
				foreach($this->Language->items as $lang => $abbrev){$option_fields[] = $abbrev;}
				foreach($option_fields as $of){
				    if(isset($_POST[$of . '_' . $id])){ $file[$of] = $_POST[$of . '_' . $id];}
				}
				
				if($_POST['name_' . $id] != pathinfo($file_select["name"])["filename"]){
				    $file["name"] = $_POST['name_' . $id] . '.' . pathinfo($file_select["name"])["extension"];
				    
				    
                    $file_dir = ($file["link_id"] == 0) ? $file["id"] : $file["link_id"];
    				$dir = (isset($array["path"])) ? $array["path"] : $this->files_dir($file["id"], $file["link_id"]);
    				$file["path"] = ((isset($_POST['path_' . $id])) ?  $_POST['path_' . $id] : $dir) . "/" . $file["name"];
    				rename($file_select["path"], $file["path"]);
                }
                if(count($file) > 0){$this->Query->update($file, $id, "id", $this->table);}
            }
        }
    }
    
    
    private function make_thumbnail($file, $new_name, $max_width=false, $max_height=false){
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
        
            imagealphablending($tmp_img, false);
            imagesavealpha($tmp_img, true);
        // Copy and resize old image into new image.
        imagecopyresampled( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Save thumbnail into a file.
        //compressing the file
        
        
        switch($type){
        	case'image/png':
        		imagepng($tmp_img, $new_name);
        		break;
        	case'image/jpeg':
        		imagejpeg($tmp_img, $new_name);
        		break;
        	case'image/gif':
        		imagegif($tmp_img, $new_name);
        		break;	
        }
        
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
                if($img_size[0] > $pixels){$this->make_thumbnail($file, pathinfo($file["path"])["dirname"] . "/" . pathinfo($file["path"])["filename"] . "_" . $size . "." . pathinfo($file["path"])["extension"], $pixels);}
            }
            move_uploaded_file($file["tmp_name"], $file["path"]);
        } else {
            move_uploaded_file($file["tmp_name"], $file["path"]);
        }
    }
}
?>