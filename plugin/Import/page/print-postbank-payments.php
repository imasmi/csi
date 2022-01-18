<?php 
include_once(\system\Core::doc_root() . '/plugin/Money/php/Bordero/Postbank_xml.php');
?>
<div id="bordero" class="fullscreen">
<?php 
    $Postbank_xml = new \plugin\Money\Bordero\Postbank_xml($xml);
    $Postbank_xml->_();
?>
</div>
