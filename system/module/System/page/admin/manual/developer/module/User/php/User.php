<h1>User.php</h1>
    <span>Manage users.</span>
    <span>Location: system/module/User/php/User.php</span>
    <span>Namespace: system\module\User\php</span>
    <span>Instance: new \module\User\User;</span>
    <span>Default instance of the class ($User) is auto created and ready to use.</span>
        
    <h2>Variables</h2>
        <h3>User->Core</h3>
            <span>A variable with instance of \system\Core class.</span>
            
        <h3>User->Query</h3>
            <span>A variable with instance of \system\Database class.</span>
            
        <h3>User->table</h3>
            <span>Database table to store users data. Default is the prefix_user.</span>
            
        <h3>User->module</h3>
            <span>The module name - User.</span>
            
        <h3>User->id</h3>
            <span>The id of the current logged user. Returns false if user is not logged in.</span>
        
        <h3>User->roles</h3>
            <span>Array with all user roles in the system. They are retrieved with Query->column_group function for the field role in the user database table.</span>
            
        <h3>User->role</h3>
            <span>The role of the current logged user. Returns false if user is not logged in.</span>
        
        <h3>User->item</h3>
            <span>Information retrieved from the database row about the logged user.</span>
        
        
    <h2>Functions</h2>
    
        <h3>User->item</h3>
            <span>Get information about the logged user</span>
                <ul>
                    <li>
                        <h4>User->item(id=false)</h4>
                        <span>id: the id of the user. If set to false, the id is set to $this->id. Default value is false.</span>
                        <p>Example: $User->item()</p>
                        <span>Will return record from database about user with id=$this->id</span>
                        <p>Example: $User->item(4)</p>
                        <span>Will return record from database about user with id=4</span>
                    </li>
                </ul>
        
        <h3>User->logger</h3>
            <span>Create user buttons for login, register, profile and log out actions.</span>
            
            <ul>
                <li>
                    <h4>User->logger()</h4>
                    <p>Example: $User->logger()</p>
                    <span>If user is not logged it will return login and register links. If user is logged it will return profile and log out links.</span>
                </li>
            </ul>
            
        <h3>User->pass_requirements</h3>
            <span>Check if password strenght criterias are met.</span>
            <span>Return true on success or error message on failure.</span>
            
            <ul>
                <li>
                    <h4>User->pass_requirements(password)</h4>
                    <p>Example: $User->pass_requirements("12345")</p>
                    <span>Example output: Password must be atleast 6 symbols</span>
                </li>
            </ul>
        
        <h3>User->activation_link</h3>
            <span>Creates link for new user to activate profile.</span>
            <span>The link is sended to the new user's email.</span>
            
            <ul>
                <li>
                    <h4>User->activation_link(code, email)</h4>
                    <span>code (string): the activation code for the user.</span>
                    <span>email (string): the email of the user.</span>
                    <p>Example: $User->activation_link("e0e9f960b43f360f5245d7f8e44fea40", "info@web.imasmi.com")</p>
                    <span>Return an activation link for profile.</span>
                </li>
            </ul>
            
        <h3>User->control</h3>
            <span>Check for user rights to access the current location.</span>
            <span>Send users to home page if the criterias are not met.</span>
            
            <ul>
                <li>
                    <h4>User->control(role="any")</h4>
                    <span>role (string): the role to check for rights.</span>
                    <p>Example: $User->control("admin")</p>
                    <span>Grant access to the current location only for users with role=admin.</span>
                </li>
            </ul>
            
        <h3>User->control</h3>
            <span>Check for user rights to access the current location.</span>
            <span>Send users to home page if the criterias are not met.</span>
            
            <ul>
                <li>
                    <h4>User->control(role="any")</h4>
                    <span>role (string): the role to check for rights.</span>
                    <p>Example: $User->control("admin")</p>
                    <span>Grant access to the current location only for users with role=admin.</span>
                </li>
            </ul>
            
        <h3>User->_</h3>
            <span>Return information about the current user.</span>
            
            <ul>
                <li>
                    <h4>User->_(column="role")</h4>
                    <span>column (string): database column field to retrieve data from.</span>
                    <p>Example: $User->group</p>
                    <span>Example output: role</span>
                    <p>Example: $User->id</p>
                    <span>Example output: 1</span>
                </li>
            </ul>
            