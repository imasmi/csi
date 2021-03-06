<?php
namespace module\User;

class User{
    public function __construct($id = false) {
        $this->table = \system\Data::table("user");
        $this->module = "User";
        if($id === false && isset($_SESSION["id"])){ $id = $_SESSION["id"];}
        $this->id = $id;
        $this->column_group = \system\Data::column_group("group", $this->table);
        if($this->id !== false){
            $this->item = $this->item();
            $this->groups = $this->item["group"];
        }
        
    }

    public function item() {
        return $GLOBALS["PDO"]->query("SELECT * FROM " . $this->table . " WHERE id='" . $this->id . "'")->fetch();
    }

    //$data possible values: type => string(full|login), username => boolean
	public function logger($data = []) {
	    global $Text;
	    $type = isset($data["type"]) ? $data["type"] : "full";
	    $output = '<div class="logger">';
	    if($this->id !== false && (!isset($data["username"]) || $data["username"] == true)){ $output .= '<div class="logger-username">' . $Text->_("Logged as") . '<span>' . $this->item["username"] . '</span></div>'; }
		if($this->id === false){
		     $output .= '<a href="' . \system\Core::url() . $this->module . '">' . $Text->item("Login") . '</a>';
		     if ($type == "full") { $output .= '<a href="' . \system\Core::url() . $this->module . '/register">' . $Text->item("Register") . '</a>';}
		} else {
		    $output .= '<a href="' . \system\Core::url() . $this->module . '/profile/index">' . $Text->item("Profile") . '</a>';
		    if ($type == "full") {$output .= '<a href="' . \system\Core::url() . $this->module . '/query/logout">' . $Text->item("Log out") . '</a>';}
		}
		 $output .= '</div>';
		 return $output;
	}

	public static function pass_requirements($pass) {
	    global $Text;
	    if(strlen($pass) >= 6){
	        return true;
	    } else {
	        return $Text->item("Password must be atleast 6 symbols");
	    }
	}

	public function activation_link($code, $email) {
	    global $Text;
	    return '<a href="' . $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"] . '/User/query/activate?code=' . $code . '&email=' . $email . '">' . $Text->item("Activate profile") . '</a>';
	}

	public function control($group="any") {
	    if($this->id === false ||  ($group !== "any" && $group !== $_SESSION["group"])){
	        ?> <script>location.href = '<?php echo \system\Core::url();?>';</script><?php
	        exit;
	    }
	}
	
	public static function group($group) {
	    return (isset($_SESSION["group"]) && $_SESSION["group"] == $group);
	}
}
?>
