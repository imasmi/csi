<h1>Mail.php</h1>
    <span>Mail class for working with email messages.</span>
    <span>$Mail - variable with initialized isntance of the class is available to use.</span>
    <span>Location: system/php/Mail.php</span>
    
    <h3>Mail->validate</h3>
        <span>Checks if given string is a valid email address name.</span>
        <span>If the email is valid it returns the address name, otherwise it returns false.</span>
        <ul>
            <li>
                <h4>Mail->validate(email address)</h4>
                <p>Example: \system\Mail::validate("test@web.imasmi.com");</p>
                <span>The example above will return test@web.imasmi.com</span>
                <p>Example: \system\Mail::validate("test@");</p>
                <span>The example above will return false</span>
            </li>
        </ul>
    <h3>Mail->send</h3>
        <span>Send email with predefined headers and domain name.</span>
        <ul>
            <li>
                <h4>Mail->send(recipient email, subject, message, array additional_headers)</h4>
                <p>additional_headers</p>
                <span>sender: the sender of the message (default is the site name set in settings Setting menu)</span>
                <span>from: the sender email (default is the contact-email set in settings Setting menu)</span>
                <span>reply-to: the email to reply to (if not set, reply will address the sender of the message specified in from value)</span>
                <p>Example: \system\Mail::send("info@imasmi.com", "Hello", "How are you?", array("reply-to" => "test@imasmi.com"));</p>
                <span>The example above will send email from default website name and default website address to recipient info@imasmi.com. The message will have subject - Hello and content - How are you? The reply-to address will be test@imasmi.com</span>
                <p>Example: \system\Mail::send(""info@imasmi.com", "Hello", "How are you?", array("sender" => "ImaSmi Web", "from" => "info@web.imasmi.com"));</p>
                <span>The example above will send email from ImaSmi Web &lt;info@web.imasmi.com> to info@imasmi.com. The message will have subject - Hello and content - How are you? Reply to will address info@web.imasmi.com.</span>
                <span>The Contact-mail setting can be set in Settings->Setting.</span>
            </li>
        </ul>