<div class="admin">
<div class="error-message" id="error-message"></div>
<h2 class="title text-center"><?php echo $Text->_("Login");?></h2>
<form class="form" id="login" action="<?php echo \system\Core::query_path() . 'login';?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path() . 'login';?>', S.serialize('#login'), '#error-message')">
    <div class="flex flex-between flex-align-center flex-responsive">
        <div class="padding-10"><?php echo $Text->_("Username");?></div>
        <div class="padding-10"><input type="text" name="username" id="username" required/></div>
    </div>
    <div class="flex flex-between flex-align-center flex-responsive">
        <div class="padding-10"><?php echo $Text->_("Password");?></div>
        <div class="padding-10"><input type="password" name="password" id="password" required/></div>
    </div>
    <div class="padding-10 text-center"><button class="button"><?php echo $Text->item("Save");?></button></div>
</form>
<div class="clear text-center"><a href="<?php echo \system\Core::url();?>User/forgotten-password"><?php echo $Text->_("Forgotten password");?></a></div>
</div>