<?php
namespace system\module\User\php;

class User{
    public function __construct(){
        global $Core;
        $this->Core = $Core;
        global $Query;
        $this->Query = $Query;
        $this->table = isset($Query) ? $Query->table("user") : "user";
        $this->module = "User";
        $this->id = $this->_("id");
        $this->roles = isset($Query) ? $Query->column_group("role", $this->table) : false;
        $this->role = $this->_();
        if($this->role !== false){ $this->item = $this->item();}
    }
    
    public function item($id=false){
        $id = $id !== false ? $id : $this->id;
        return $this->Query->select($id, "id", $this->table);
    }
	
	public function logger(){
	    global $Text;
        $this->Text = $Text;
	    $output = '<div class="logger">';
		if($this->_() === false){
		     $output .= '<a href="' . $this->Core->url() . $this->module . '">' . $this->Text->item("Login") . '</a>';
		     $output .= '<a href="' . $this->Core->url() . $this->module . '/register">' . $this->Text->item("Register") . '</a>';
		} else {
		    $output .= '<a href="' . $this->Core->url() . $this->module . '/profile/profile">' . $this->Text->item("Profile") . '</a>';
		     $output .= '<a href="' . $this->Core->url() . $this->module . '/query/logout">' . $this->Text->item("Log out") . '</a>';
		}
		 $output .= '</div>';
		 return $output;
	}
	
	public function pass_requirements($pass){
	    global $Text;
	    if(strlen($pass) >= 6){ 
	        return true;
	    } else {
	        return $Text->item("Password must be atleast 6 symbols");
	    }
	}
	
	public function activation_link($code, $email){
	    global $Text;
	    return '<a href="' . $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"] . '/User/query/activate?code=' . $code . '&email=' . $email . '">' . $Text->item("Activate profile") . '</a>';
	}
	
	public function control($role="any"){
	    if($this->_("id") === false ||  ($role !== "any" && $role !== $_SESSION["role"])){
	        ?> <script>location.href = '<?php echo $this->Core->url();?>';</script><?php
	        exit;
	    }
	}
	
	public function _($column = 'role'){
        return (isset($_SESSION[$column])) ? $_SESSION[$column] : false;
	}
}


$User = new User();
?>