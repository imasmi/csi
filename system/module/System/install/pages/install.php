<?php 
if(isset($_POST["create_database"])){
require_once($Core->doc_root() . "/system/php/Mail.php");
require_once($Core->doc_root() . "/system/module/User/php/User.php");
$Mail = new \system\php\Mail();
$User = new \system\module\User\php\User(array("table" => $_POST["prefix"] . "_user"));
    
$error = "<button onclick='history.go(-1)'>Go back</button>";
#CHECK FOR DATABASE CONNECTION    
 try {
    $PDO = new PDO("mysql:host=" . $_POST["host"] . ";dbname=" . $_POST["database"], $_POST["user"], $_POST["password"]);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connection success.<br/>";
    
    #IMPORT DATABASE
    ob_start();
    include_once($Core->doc_root() . '/system/module/System/install/db.sql');
    $sql_file = ob_get_contents();
    ob_end_clean();
    
    $sql_file = str_replace("`web_", "`" . $_POST["prefix"] . "_", $sql_file);
    if($PDO->exec($sql_file) !== false){
        echo 'Database data was imported. <br/>';
    } else {
        echo "Database import failed. Please try again. If promblem persist, click here how to manualy import data.";
        echo $error;
        exit;
    }
    
    #CREATE ADMIN USER
    
    if ($Mail->validate($_POST["admin_email"]) === false){
        echo "Invalid email address.";
        echo $error;
        exit;
    }
    
    $checkPass = $User->pass_requirements($_POST["admin_password"]);
    if($checkPass !== true){
        echo $checkPass;
        echo $error;
        exit;
    }
    
    $newUser = $PDO->prepare("INSERT INTO " . $_POST["prefix"] . "_user (role, username, email, password, status) VALUES ('admin', :username, :email, :password, 'active')");
    $newUser->execute(array(
            "username" => $_POST["admin_username"],
            "email" => $_POST["admin_email"],
            "password" => password_hash($_POST["admin_password"], PASSWORD_DEFAULT)
            )
    );
    if($newUser->rowCount() == 1){
        echo 'Admin user was created.<br/>';
    } else {
        echo "Couldn't create admin user. Please try again.";
        echo $error;
        exit;
    }
    
    #CREATE INI FILE WITH CREDENTIALS
        $output = "";
        $output .= 'host = "' . $_POST["host"] . '"' . "\n";
        $output .= 'user = "' . $_POST["user"] . '"' . "\n";
        $output .= 'password = "' . $_POST["password"] . '"' . "\n";
        $output .= 'database = "' . $_POST["database"] . '"' . "\n";
        $output .= 'prefix = "' . $_POST["prefix"] . '"' . "\n";
        
        if(!file_exists($Core->doc_root() . '/web')){mkdir($Core->doc_root() . '/web');}
        if(!file_exists($Core->doc_root() . '/web/ini')){mkdir($Core->doc_root() . '/web/ini', 0750);}
        if(file_put_contents($database_ini, $output) !== false){ 
            chmod($database_ini, 0640);
            echo 'Database ini file was created.<br/>';
        } else {
            echo "Creating database.ini file failed, please try again. Please check your folder permissions.<br/>";
            echo $error;
            exit;
        }
        
    #CREATE INI FILE WITH ENGLISH LANGUAGE
        $language = "[English]\n";
        $language .= "on-off = 1\n";
        $language .= "code = en\n";
        
        if(file_put_contents($Core->doc_root() . '/web/ini/language.ini', $language) !== false){ 
            chmod($Core->doc_root() . '/web/ini/language.ini', 0640);
            echo 'Language ini file was created.<br/>';
        } else {
            echo "Creating language.ini file failed, please try again. Please check your folder permissions.<br/>";
            echo $error;
            exit;
        }
    
    #CREATE INDEX WWW FILE WITH LOGGER
        if(file_put_contents($Core->doc_root() . '/web/header.php', '<?php echo $User->logger();?>') !== false){ 
            echo 'User logger created succes. <br/>';
        } else {
            echo 'User logger created failed. <br/>';
        }
        ?>
        <h1>Installation complete!</h1>
        <div>Your installation is complete, you can login to system Web now.</div>
        <h3>Username: <?php echo $_POST["admin_username"];?></h3>
        <h3>Password: <?php echo $_POST["admin_password"];?></h3>
        <button onclick="window.open('/User', '_self')">GO TO LOGIN</button>
        <?php
    }
catch(PDOException $e){
    echo "Database connection failed.<br/> Please set up your database credentials first.<br/>";
    echo $error;
}
       
} else {
?>
    <form method="post">
        <h1>Setup database</h1>
        <div>Let's setup database first.</div>
        <div>Please create database and user and fill the form.</div>
        
        Host <input type="text" name="host" value="localhost" required/><br/>
        Username <input type="text" name="user" required/><br/>
        Password <input type="text" name="password" required/><br/>
        Database name <input type="text" name="database" required/><br/>
        Database prefix <input type="text" name="prefix" required/><br/>
        
        <h1>Admin user</h1>
        <div>Set username and password for your new admin user</div>
        Username <input type="text" name="admin_username" required/><br/>
        Email <input type="text" name="admin_email" required/><br/>
        Password <input type="text" name="admin_password" required/><br/><br/>
        <button name="create_database">CREATE</button>
    </form>
<?php } ?>