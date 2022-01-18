<?php
namespace plugin\Money\Bordero;

include_once(\system\Core::doc_root() . '/plugin/Money/php/Bordero/Item.php');

class Postbank_xml{
	public function __construct($xml){
		global $PDO;
		$this->PDO = $PDO;
		$this->xml = $xml;
		$this->items = $this->xml->ArrayOfAPAccounts->APAccount->BankAccount->Movements->ArrayOfMovements->BankAccountMovement;		
	}

	
	public function _() {
		foreach($this->items as $pay){
            $Item = new \plugin\Money\Bordero\Item($pay, ["type" => "xml"]);
			$Item->_();
		}
	}
}


?>
