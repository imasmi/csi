<?php
#EDIT TEXT
require_once(\system\Core::doc_root() . "/system/module/Page/php/PageAPP.php");
$PageAPP = new \module\Page\PageAPP;

$text_edit = strip_tags($_POST["text"]) == NULL ? NULL : $_POST["text"];
$array = array($_POST["lang"] => $text_edit);
\system\Query::update($array, $_POST["id"], "id", $Text->table);

$output = array("text" => $text_edit);
#CHECK FOR OTHER OPTIONS
if($_POST["options"] != "{}"){
    $options = json_decode($_POST["options"], true);
    $select = $PDO->query("SELECT * FROM " . $Text->table . " WHERE id='" . $_POST["id"] . "'")->fetch();
    #UPDATE SETTING WITH THE SAME FIELD NAME FOR CURRENT PAGE IF SETTING OPTIONS IS TRUE
    if(isset($options["setting"]) && $options["setting"] === true && $select["tag"] != ""){
        $setting_text = strip_tags($text_edit);
        $check_setting = $PDO->query("SELECT id FROM " . $Setting->table . " WHERE page_id='" . $select["page_id"] . "' AND `tag` LIKE '" . $select["tag"] . "'");
        if($check_setting->rowCount() == 0){
            $setting_array = array(
                    "page_id" => $select["page_id"],
                    "tag" => $select["tag"],
                    "plugin" => isset($options["plugin"]) ? $options["plugin"] : NULL
                );
            foreach($Language->items as $lang){
                if($lang == $Language->_()){
                    $setting_array[$lang] = $setting_text;
                } else {
                    $setting_array[$lang] = $select["tag"];
                }
            }
            \system\Query::insert($setting_array, $Setting->table);
        } else {
            $set = $check_setting->fetch();
            $setting_update = $PDO->prepare("UPDATE " . $Setting->table . " SET " . $_POST["lang"] . "=? WHERE id='" . $set["id"] . "'");
            $setting_update->execute(array($setting_text));
        }
        if($select["tag"] == "Title"){$output["Title"] = $setting_text;}
    }

    #UPDATE URL IF URL OPTIONS IS TRUE OR CHANGE
    if(isset($options["url"]) && $select["page_id"] !== 0){
        $new_url = $PageAPP->url_format($text_edit);
        if($PDO->query("SELECT id FROM " . $Page->table . " WHERE " . $_POST["lang"] . "='" . $new_url  . "' AND id!='" . $select["page_id"] . "'")->rowCount() > 0){$new_url .= "-" . $select["page_id"];}
        $url = array($_POST["lang"] => mb_strtolower($new_url));
        \system\Query::update($url, $select["page_id"], "id", $Page->table);

        #change url if changed url is on current lang and url oprions is change
        if($_POST["lang"] == $Language->_() && $options["url"] === true){
            $update_title = (isset($new_title)) ? $new_title : $Setting->_("Title", array("type" => "", "page_id" => $select["page_id"]));
            $output["url"] = $Page->url($select["page_id"]);
        }
    }
}
print_r(json_encode($output));
?>
