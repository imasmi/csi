<?php
namespace module\Theme;

class Theme{

    public function __construct(){
        $this->items = file_exists(\system\Core::doc_root() . "/web/ini/theme.ini") ? parse_ini_file(\system\Core::doc_root() . "/web/ini/theme.ini", true) : array();
        $this->name = $this->active();
        $this->data = $this->items[$this->name];
    }
    
    private function active() {
        foreach ($this->items as $theme => $data) {
            if ($data["active"] == 1) {
                return $theme;
                break;
            }
        }
        return false;
    }
    
    public function package ($name, $data = []) {
        // Create theme folder if not exists
        $theme_dir = \system\Core::doc_root() . "/data/theme/" . $name;
        if (is_dir($theme_dir)) { $GLOBALS["FileAPP"]->delete_dir($theme_dir);}
        mkdir($theme_dir, 0750, true);
        
        // Set ini file data
        $info  = [
            "name" => $name,
            "version" => $_POST["version"],
            "website" => $_POST["website"],
            "description" => $_POST["description"]
        ];
        
        $theme_pages = [];
        foreach ($GLOBALS["PDO"]->query("SELECT * FROM " . $GLOBALS["Page"]->table . " WHERE `theme`='" . $GLOBALS["Theme"]->active . "'", \PDO::FETCH_ASSOC) as $theme_page) {
            $theme_pages[] = [
                "theme" => $name,
                "tag" => $theme_page["tag"],
                "row" => $theme_page["row"],
                "menu" => $theme_page["menu"],
                "filename" => $theme_page["filename"],
                "type" => $theme_page["type"],
            ];
        }
        $info["pages"] = json_encode($theme_pages);

        // Set theme plugins
        $theme_plugins = [];
        $exclude = [\system\Core::doc_root() . "/web/file", \system\Core::doc_root() . "/web/ini"];
        foreach ($GLOBALS["Plugin"]->items as $plugin => $data) {
            if ($data["theme"] != $GLOBALS["Theme"]->active) {
                $exclude[] = \system\Core::doc_root() . "/plugin/" . $plugin;
            } else {
                $theme_plugins[$plugin] = $data;
            }
        }
        
        // Create ini file
        $info["plugins"] = json_encode($theme_plugins);
        \system\Ini::save($theme_dir . "/theme.info", $info);
        
        // Create theme zip
        $Theme_zip = new \module\File\ZipAPP($theme_dir . "/theme.zip", \system\Core::doc_root(), ["include" => [\system\Core::doc_root() . "/plugin", \system\Core::doc_root() . "/web"], "exclude" => $exclude]);
        $Theme_zip->create();
        
        if ( isset($data["download"]) ) {
            //Add preview image
            if (!file_exists(mkdir($theme_dir . "/file"))) {mkdir($theme_dir . "/file");}
            move_uploaded_file($_FILES["preview_0"]["tmp_name"], $theme_dir . "/file/1." . pathinfo($_FILES["preview_0"]["name"])["extension"]);
            
            // Create theme archive
            $Theme_package = new \module\File\ZipAPP($theme_dir . "/package.zip", $theme_dir);
            $Theme_package->create();
            
            //Download the theme
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'. $name .'_theme.zip"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($theme_dir . "/package.zip");
        }
    }
}
?>
