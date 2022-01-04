<?php 
if(isset($_POST["create_database"])){
    
require_once(\system\Core::doc_root() . "/system/php/Query.php");
require_once(\system\Core::doc_root() . "/system/php/Mail.php");
require_once(\system\Core::doc_root() . "/system/module/User/php/User.php");    
    
$error = "<button onclick='history.go(-1)'>Go back</button>";
#CHECK FOR DATABASE CONNECTION    
 try {
    $PDO = new PDO("mysql:host=" . $_POST["host"] . ";dbname=" . $_POST["database"], $_POST["user"], $_POST["password"]);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connection success.<br/>";
    
    #IMPORT DATABASE
    ob_start();
    include_once(\system\Core::doc_root() . '/system/module/System/install/db.sql');
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
    
    if (\system\Mail::validate($_POST["admin_email"]) === false){
        echo "Invalid email address.";
        echo $error;
        exit;
    }
    
    $checkPass = \module\User\User::pass_requirements($_POST["admin_password"]);
    if($checkPass !== true){
        echo $checkPass;
        echo $error;
        exit;
    }
    
    $newUser = $PDO->prepare("INSERT INTO " . $_POST["prefix"] . "_user (`group`, username, email, password, status) VALUES ('admin', :username, :email, :password, 'active')");
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
        
        if(!file_exists(\system\Core::doc_root() . '/web')){mkdir(\system\Core::doc_root() . '/web');}
        if(!file_exists(\system\Core::doc_root() . '/web/ini')){mkdir(\system\Core::doc_root() . '/web/ini', 0750);}
        
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
        $language .= "active = 1\n";
        $language .= "code = en\n";
        
        if(file_put_contents(\system\Core::doc_root() . '/web/ini/language.ini', $language) !== false){ 
            chmod(\system\Core::doc_root() . '/web/ini/language.ini', 0640);
            echo 'English language was added as default language. You can manage your languages from Settings/Language.<br/>';
        } else {
            echo "Creating language.ini file failed, please try again. Please check your folder permissions.<br/>";
            echo $error;
            exit;
        }
    
        ?>
        <h1 class="color-2">congratulations!</h1>
        <div>Installation of ImaSmi Web completed successfuly and is ready to use. Proceed to login page to start creating content.</div>
        <h3>Username: <?php echo $_POST["admin_username"];?></h3>
        <h3>Password: <?php echo $_POST["admin_password"];?></h3>
        <button onclick="window.open('<?php echo \system\Core::url();?>User', '_self')" class="button">PROCEED TO ADMIN</button>
        <?php
    }
catch(PDOException $e){
    echo $e;
    echo "Database connection failed.<br/> Please set up your database credentials first.<br/>";
    echo $error;
}
       
} else {
?>
    <form method="post">
        <h1 class="text-center color-2">Setup database</h1>
        <div class="text-center">Let's setup database first.</div>
        <div class="text-center">Please create database and user and fill the form.</div>
        
        <div class="marginY-20">
            <div class="clear marginY-10">
                <div class="column-6">Host</div>
                <div class="column-6"><input type="text" name="host" value="localhost" required/></div>
            </div>
            
            <div class="clear marginY-10">
                <div class="column-6">Username</div>
                <div class="column-6"><input type="text" name="user" required/></div>
            </div>
            
            <div class="clear marginY-10">
                <div class="column-6">Password</div>
                <div class="column-6"><input type="text" name="password" required/></div>
            </div>
            
            <div class="clear marginY-10">
                <div class="column-6">Database name</div>
                <div class="column-6"><input type="text" name="database" required/></div>
            </div>
            
            <div class="clear marginY-10">
                <div class="column-6">Database prefix</div>
                <div class="column-6"><input type="text" name="prefix" required/></div>
            </div>
        </div>
        
        <h1 class="text-center color-2">Admin user</h1>
        <div class="text-center">Set username and password for your new admin user</div>
        
        <div class="marginY-20">
            <div class="clear marginY-10">
                <div class="column-6">Email</div>
                <div class="column-6"><input type="text" name="admin_email" required/></div>
            </div>
            
            <div class="clear marginY-10">
                <div class="column-6">Username</div>
                <div class="column-6"><input type="text" name="admin_username" required/></div>
            </div>
            
            <div class="clear marginY-10">
                <div class="column-6">Password</div>
                <div class="column-6"><input type="text" name="admin_password" required/></div>
            </div>
        </div>
        
        <div class="marginY-20 text-center"><button name="create_database" class="button">CREATE</button></div>
    </form>
<?php } ?>