<?php
namespace module\System;

class ManualAPP{
    public function __construct(){
        $this->filetypes = array("php", "js", "css", "ini");
    }

    public function menu($path, $offset = -1){
        ?>
        <ul class="sub-menu <?php echo $this->path_id($path, $offset);?>-menu">
        <?php
        --$offset;
        foreach(\system\Core::list_dir($path, array("multidimensional" => true)) as $key => $value){
            $name = !is_array($value) ? $value : $key;
            $links = explode("/", $name);
            ?>
                <li class="<?php if(is_array($value)){echo 'with-sub';}?>">
                    <a onclick="view('<?php echo $this->path_id($name, $offset);?>');">
                        <?php
                            if(!is_array($value) && in_array($links[count($links) - 2], $this->filetypes)){
                                echo pathinfo($links[count($links) - 1])["filename"] . '.' . $links[count($links) - 2];
                            } else {
                                echo $links[count($links) - 1];
                            }
                        ?>
                    </a>
                    <?php if(is_array($value)){ $this->menu($name, $offset);}?>
                </li>
            <?php
        }
        ?>
        </ul>
        <?php
        return false;
    }

    public function path_id($path, $offset=-1, $length=null){
        $array = explode("/", $path);
        $slice = array_slice($array, $offset, $length);
        return pathinfo(implode("-", $slice))["filename"];
    }
}
?>
