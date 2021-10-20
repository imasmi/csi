<?php
namespace plugin\Money\php;

class bordero{
	public function __construct($xml){
		global $PDO;
		$this->PDO = $PDO;
		global $Core;
		$this->Core = $Core;
		$this->xml = $xml;
		$payTypes = array();
		$payTypes["transfer"] = array(
			"Получен директен превод",
			"Вътрешно банков левов превод",
			"SEPA получен кредитен превод",
			"Валутен превод - получен 1",
			"Валутна сделка",
			"Вътрешно банков левов превод м/у сметки на клиента",
			"Издаден директен превод",
			"Издаден директен превод за служебно плащане",
			"Вътрешно банков левов превод от GroupSales с МП",
			'Получен превод по RINGS',
			"Издаден директен превод за служебно плащане от валутн"
		);
		
		$payTypes["cash"] = array(
			"Вноска на каса - сделка"
		);
		
		$payTypes["budget"] = array(
			"Получено бюд.плащане",
			"Издадено бюд.плащане"
		);
		
		$payTypes["received_budget"] = array(
			"Получен превод бюджет"
		);
		
		#CHECK FOR UNKNOWN OR PAYMENTS IN EURO
		foreach($xml->ArrayOfAPAccounts->APAccount->BankAccount->Movements->ArrayOfMovements->BankAccountMovement as $pay){
			$payKind = $pay->MovementKind->MovementKindNames->Items[0];
			
			echo '<center class="person">';
			if(in_array($payKind, $payTypes["transfer"]) || in_array($payKind, $payTypes["cash"]) || in_array($payKind, $payTypes["budget"]) || in_array($payKind, $payTypes["received_budget"])){ 
				if($payKind == "SEPA получен кредитен превод" || $payKind == "Валутна сделка"){ ?> 
					<div class="attention" id="id_<?php echo $pay->DocRegNumber;?>">
						<?php echo $payKind;?>
						<button class="button" onclick="S.hide('#id_<?php echo $pay->DocRegNumber;?>');">X</button>
					</div> 
				<?php }	
			} else { ?>
				<div class="attention">
					<div>НЕПОЗНАТ ВИД ПЛАЩАНЕ: <?php echo number_format((float)$pay->MovementAmount, 2,'.','') . ' лв. - ' . date("d.m.Y H:i:s", strtotime($pay->ProcessTimestamp));?></div>
					<div><?php echo $payKind;?></div>
				</div>
			<?php
			}
			echo '</center>';
		}
		
		#PREVIEW PAYMENTS FOR PRINTING
		foreach($xml->ArrayOfAPAccounts->APAccount->BankAccount->Movements->ArrayOfMovements->BankAccountMovement as $pay){
			$payKind = $pay->MovementKind->MovementKindNames->Items[0];
			
			echo '<center class="person">';
			if(in_array($payKind, $payTypes["transfer"])){
				if($payKind == "SEPA получен кредитен превод" || $payKind == "Валутна сделка"){ ?> 
					<div class="attention" id="id_<?php echo $pay->DocRegNumber;?>">
						<?php echo $payKind;?>
						<button class="button" onclick="S.hide('#id_<?php echo $pay->DocRegNumber;?>');">X</button>
					</div> 
				
				<?php }			
				$this->transfer($pay);
			} elseif(in_array($payKind, $payTypes["cash"])){
				$this->cash($pay);
			} elseif(in_array($payKind, $payTypes["budget"])){
				$this->budget($pay);
			} elseif(in_array($payKind, $payTypes["received_budget"])){
				$this->received_budget($pay);
			} else {?>
				<div class="attention">
					<div>НЕПОЗНАТ ВИД ПЛАЩАНЕ: <?php echo number_format((float)$pay->MovementAmount, 2,'.','') . ' лв. - ' . date("d.m.Y H:i:s", strtotime($pay->ProcessTimestamp));?></div>
					<div><?php echo $payKind;?></div>
				</div>
			<?php
			}
			echo '</center>';
		}
	}
	
	private function logo($payerAccount){
		//return ($payerAccount == "BG81BPBI79301033376203") ? "" : '<img src="' . $this->Core->url() . 'web/file/postbank_logo.png" alt="" style="height: 95px;"/>';
		return ($payerAccount == "BG81BPBI79301033376203") ? "" : '<img src="' . $this->Core->url() . 'web/file/postbank_new_logo.png" alt="" style="height: 95px;"/>';
	}
	
	public function transfer($pay){ 
		#print_r($pay);
	?>
		
		<div class="out-text">Превод в лева</div>
			<table width="820" border="1" class="colltable bordoTable">
				<tr>
					<td>
						<table width="100%" cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td colspan="3" height="12" />
							</tr>
							<tr>
								<td width="20" />
								<td width="600" heigth="40" valign="middle">
									<?php echo $this->logo($pay->MovementDocument->PayerAccountNumber);?>
								</td>
								<td width="20" />
							</tr>
							<tr>
								<td colspan="3" height="12" />
							</tr>
							<tr>
								<td />
								<td>
									<table cellpadding="0" cellspacing="0" border="0" width="100%">
										<tr>
											<td align="center" bgcolor="#ffffff">
												<table cellpadding="2" cellspacing="4" width="820" border="0" class="bpb">
													<tr valign="top">
														<td colspan="2" height="30">
															<div style="width:80px;float:left">До/To</div>
															<br />
															<div class="Payment_textbig5" style="padding-left:50px"><?php echo $pay->MovementDocument->PayerBAEName;?></div>
														</td>
														<td colspan="3">
															<div style="float:left; width:307px;">Уникален регистрационен номер/Unique registration number</div>
															<br />
															<div class="Payment_textbig5" align="right"><?php echo $pay->DocRegNumber;?></div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="2" height="30">
															<div style="width:80px;float:left">Клон/Branch</div>
															<br />
															<div class="Payment_textbig5" style="padding-left:50px" />
														</td>
														<td colspan="3">
															<div style="float:left; width:440px;">Дата и час на представяне/Date and hour of submission</div>
															<br />
															<div class="Payment_textbig5" align="right"><?php echo date("d.m.Y H:i:s", strtotime($pay->ProcessTimestamp));?></div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="2" height="50">
															<div style="float:left">Адрес/Address</div>
														</td>
														<td colspan="3" valign="bottom">
															<div style="float:left">Подпис на наредителя / Signature of the ordering party</div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="5" height="30">
															<div style="float:left">Платете на – име на получателя / Please pay to – name of the beneficiary</div>
															<br />
															<div class="Payment_textbig5" style="padding-left:50px"><?php echo $pay->MovementDocument->PayeeName;?></div>
														</td>
													</tr>
													<tr valign="top" height="30">
														<td colspan="2" width="50%">
															<div style="float:left">IBAN на получателя / IBAN of the beneficiary</div>
															<br />
															<div class="Payment_textbig5" style="padding-left:50px"><?php echo $pay->MovementDocument->PayeeAccountNumber;?></div>
														</td>
														<td width="5%"></td>
														<td colspan="2" width="45%">
															<div style="float:left; width:273px;">BIC на банката на получателя / BIC of the beneficiary bank</div>
															<br />
															<div class="Payment_textbig5" align="right"><?php echo $pay->MovementDocument->PayeeBAE;?></div>
														</td>
													</tr>
													<tr valign="top" height="30">
														<td colspan="5">
															<div nowrap="nowrap" style="float:left">При банка – име на банката на получателя / At bank – name of the bank of beneficiary</div>
															<br />
															<div class="Payment_textbig5" style="padding-left:50px;"><?php echo $pay->MovementDocument->PayeeBAEName;?></div>
														</td>
													</tr>
													<tr valign="top">
														<td>
															<div class="Payment_textbig6" nowrap="nowrap">ПРЕВОДНО НАРЕЖДАНЕ
																<br />за кредитен превод</div>
														</td>
														<td>
															<div class="Payment_textbig6" nowrap="nowrap">PAYMENT ORDER
																<br />for credit transfer</div>
														</td>
														<td colspan="1" align="center">
															<div style="float:left;width:60px;">Вид валута / Currency</div>
															<br />
															<div class="Payment_textbig5"><?php echo $pay->CCY->SWIFTCode;?></div>
														</td>
														<td width="25%">
															<div style="float:left; width:120px;">Сума / Amount</div>
															<br />
															<div class="Payment_textbig6" align="right"><?php echo number_format((float)$pay->MovementAmount, 2,'.','');?></div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="5" height="30">
															<div style="float:left">Основание за превод – информация за получателя / Reason for payment – information for the beneficiary</div>
															<br />
															<div class="Payment_textbig5" style="padding-left:50px"><?php echo mb_substr($pay->MovementDocument->Description, 0, 35);?></div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="5" height="30">
															<div style="float:left">Още пояснения / Additional comments</div>
															<br />
															<div class="Payment_textbig5" style="padding-left:50px"><?php echo mb_substr($pay->MovementDocument->Description, 35);?></div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="5" height="30">
															<div style="float:left">Наредител – име / Ordering party – name</div>
															<br />
															<div class="Payment_textbig5" style="padding-left:50px"><?php echo $pay->MovementDocument->PayerName;?></div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="2" height="30">
															<div style="float:left">IBAN на наредителя / IBAN of the ordering party</div>
															<br />
															<div class="Payment_textbig5" style="padding-left:50px"><?php echo $pay->MovementDocument->PayerAccountNumber;?></div>
														</td>
														<td colspan="3">
															<div style="float:left">BIC на банката на наредителя / BIC of the bank of the ordering party</div>
															<br />
															<div class="Payment_textbig5" align="right"><?php echo $pay->MovementDocument->PayerBAE;?></div>
														</td>
													</tr>
													<tr valign="top">
														<td height="30">
															<div style="float:left">Платежна система / Payment System</div>
															<br />
															<div class="Payment_textbig5" style="padding-left:50px"><?php if($pay->MovementKind->MovementKindNames->Items[0] == "Получен превод по RINGS"){?>РИНГС<?php } else {?>БИСЕРА</div><?php } ?>
														</td>
														<td colspan="2" nowrap="nowrap">
															<div style="float:left">Такси* / Fees*</div>
															<br />
															<div class="Payment_textbig5" align="center">002</div>
														</td>
														<td nowrap="nowrap" colspan="2">
															<div style="float:left">Дата на изпълнение / Date of execution</div>
															<br />
															<div class="Payment_textbig5" align="right"><?php echo date("d.m.Y", strtotime($pay->ValDate));?></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table class="Payment_textsml4" cellpadding="4" width="100%">
													<tr valign="top">
														<td>* Такси:</td>
														<td>1 – за сметка на наредителя;</td>
														<td nowrap="nowrap">2 – споделени (стандарт за местни преводи);</td>
														<td>3 – за сметка на получателя</td>
													</tr>
													<tr valign="top">
														<td>* Fee:</td>
														<td>1 – our;</td>
														<td nowrap="nowrap">2 – share (standard for local payment);</td>
														<td>3 – beneficiary</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
								<td />
							</tr>
							<tr>
								<td colspan="3" heigth="12" />
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<div class="out-text">отпечатано от e-postbank.bg
			</div>
	<?php
	}
	
	public function cash($pay){ ?>	
		<div class="out-text">Вноска на каса</div>
		<table width="820" border="1" class="colltable bordoTable">
			<tr>
				<td>
					<table width="100%" cellpadding="1" cellspacing="1" border="0">
						<tr>
							<td colspan="3" height="12" />
						</tr>
						<tr>
							<td width="20" />
							<td width="600" heigth="40" valign="middle"><?php echo $this->logo($pay->MovementDocument->PayerAccountNumber);?></td>
							<td width="20" />
						</tr>
						<tr>
							<td colspan="3" height="12" />
						</tr>
						<tr>
							<td />
							<td>
								<table cellpadding="0" cellspacing="0" border="0" width="100%">
									<tr>
										<td align="center" bgcolor="#ffffff">
											<table cellpadding="2" cellspacing="4" width="820" border="0" class="bpb">
												<tr valign="top">
													<td colspan="2" height="30">
														<div style="width:80px;float:left">До/To</div>
														<br />
														<div class="Payment_textbig5" style="padding-left:50px">Юробанк България АД</div>
													</td>
													<td colspan="3">
														<div style="float:left;">Уникален регистрационен номер/Unique registration number</div>
														<br />
														<div class="Payment_textbig5" align="right"><?php echo $pay->DocRegNumber;?></div>
													</td>
												</tr>
												<tr valign="top">
													<td colspan="2" height="30">
														<div style="width:80px;float:left">Клон/Branch</div>
														<br />
														<div class="Payment_textbig5" style="padding-left:50px"></div>
													</td>
													<td colspan="3">
														<div style="float:left">Дата и час на представяне/Date and hour of submission </div>
														<br />
														<div class="Payment_textbig5" align="right"><?php echo date("d.m.Y H:i:s", strtotime($pay->ProcessTimestamp));?></div>
													</td>
												</tr>
												<tr valign="top">
													<td colspan="2" height="40">
														<div style="float:left">Адрес/Address</div>
														<br />
														<div class="Payment_textbig5" style="padding-left:50px"></div>
													</td>
													<td colspan="3">
														<br />
														<br />
														<div style="float:left">Подпис на наредителя / Signature of the ordering party</div>
													</td>
												</tr>
												<tr valign="top">
													<td colspan="5" height="30">
														<div style="float:left">В полза на - име / In favor of - name</div>
														<br />
														<div class="Payment_textbig5" style="padding-left:50px"><?php echo $pay->MovementDocument->PayeeName;?></div>
													</td>
												</tr>
												<tr valign="top" height="30">
													<td colspan="5" width="50%">
														<div style="float:left">IBAN на получателя / IBAN of the beneficiary</div>
														<br />
														<div class="Payment_textbig5" style="padding-left:50px"><?php echo $this->xml->ArrayOfAPAccounts->APAccount->BankAccount->IBAN;?></div>
													</td>
												</tr>
												<tr valign="top" height="30">
													<td colspan="5">
														<div nowrap="nowrap" style="float:left">При банка – банка, клон / At bank – bank, branch</div>
														<br />
														<div class="Payment_textbig5" style="padding-left:50px">
															ЮРОБАНК БЪЛГАРИЯ АД
														</div>
													</td>
												</tr>
												<tr valign="top">
													<td>
														<div class="Payment_textbig6" nowrap="nowrap" style="width:175px;">ВНОСНА БЕЛЕЖКА
															<br />DEPOSIT slip</div>
													</td>
													<td>
														<div class="Payment_textbig6" nowrap="nowrap" style="width:185px;">Внесохме в брой
															<br />We deposited in cash</div>
													</td>
													<td colspan="2" align="center">
														<div style="float:left; width:163px;">Вид валута / Currency</div>
														<br />
														<div class="Payment_textbig5" style="float: left"><?php echo $pay->CCY->SWIFTCode;?></div>
													</td>
													<td width="25%">
														<div style="float:right; width:190px;">Сума / Amount</div>
														<br />
														<div class="Payment_textbig6" align="right"><?php echo number_format((float)$pay->MovementAmount, 2,'.','');?></div>
													</td>
												</tr>
												<tr valign="top">
													<td colspan="5" height="30">
														<div style="float:left">Вносител - име / Depositor - name</div>
														<br />
														<div class="Payment_textbig5" style="padding-left:50px"><?php echo $pay->MovementDocument->PayerName;?></div>
													</td>
												</tr>
												<tr valign="top">
													<td colspan="5" height="30">
														<div style="float:left">Основание за внасяне / Reason for deposit</div>
														<br />
														<div class="Payment_textbig5" style="padding-left:50px"><?php echo $pay->MovementDocument->Description;?></div>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td />
						</tr>
						<tr>
							<td colspan="3" heigth="12" />
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div class="out-text">отпечатано от e-postbank.bg</div>
	<?php
	}
	
	public function budget($pay){
		$amount = number_format((float)$pay->MovementAmount, 2,'.','');
		$out = $this->PDO->query("SELECT * FROM payment_outgoing WHERE name='" . $pay->MovementDocument->PayeeName . "' AND IBAN='" . $pay->MovementDocument->PayeeAccountNumber . "' AND amount='" . $amount . "'")->fetch();
	?>
		<div class="out-text" >От/Към бюджета</div>
			<table width="820" border="1" class="colltable bordoTable">
				<tr>
					<td>
						<table width="100%" cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td colspan="3" height="12" />
							</tr>
							<tr>
								<td width="10" />
								<td width="630" heigth="40" valign="middle"><?php echo $this->logo($pay->MovementDocument->PayerAccountNumber);?></td>
								<td width="10" />
							</tr>
							<tr>
								<td colspan="3" height="10" />
							</tr>
							<tr>
								<td />
								<td>
									<table cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td align="center" bgcolor="#ffffff">
												<table cellpadding="2" cellspacing="4" width="930" border="0" class="bpb">
													<tr valign="top">
														<td colspan="3" height="20">
															<div style="width:80px;float:left">До/To</div>
															<br />
															<div class="Payment_textbig5" style="padding-left:50px"><?php echo $pay->MovementDocument->PayerBAEName;?></div>
														</td>
														<td colspan="7">
															<div style="float:left">Уникален регистрационен номер/Unique registration number</div>
															<br />
															<div class="Payment_textbig5" align="right"><?php echo $pay->DocRegNumber;?></div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="3" height="20">
															<div style="width:80px;float:left">Клон/Branch</div>
															<br />
															<div class="Payment_textbig5" style="padding-left:50px" />
														</td>
														<td colspan="7">
															<div style="float:left">Дата и час на представяне/Date and hour of submission </div>
															<br />
															<div class="Payment_textbig5" align="right"><?php echo date("d.m.Y H:i:s", strtotime($pay->ProcessTimestamp));?></div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="3" height="50">Адрес/Address</td>
														<td colspan="7" valign="bottom">Подпис на наредителя / Signature of the ordering party</td>
													</tr>
													<tr valign="top">
														<td colspan="4">
															Платете на – име на получателя / Please pay to – name of the beneficiary
															<div class="Payment_textbig5" style="padding-left:80px"><?php echo $pay->MovementDocument->PayeeName;?></div>
														</td>
														<td colspan="6">
														</td>
													</tr>
													<tr valign="top">
														<td colspan="3">
															IBAN на получателя / IBAN of the beneficiary
															<div class="Payment_textbig5" style="padding-left:80px"><?php echo $pay->MovementDocument->PayeeAccountNumber;?></div>
														</td>
														<td />
														<td colspan="6">
															BIC на банката на получателя/BIC of the beneficiary bank
															<div class="Payment_textbig5" align="right"><?php echo $pay->MovementDocument->PayeeBAE;?></div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="4">
															При банка – име на банката на получателя/At bank – name of the bank of beneficiary
															<div class="Payment_textbig5" style="padding-left:80px"><?php echo $pay->MovementDocument->PayeeBAEName;?></div>
														</td>
														<td colspan="6">
															Вид плащане*** / Type of payment ***
															<div class="Payment_textbig5" align="right">
															<?php echo($out["budget_code"] == "") ? "0" : $out["budget_code"];?>
															</div>
														</td>
													</tr>
													<tr valign="top">
														<td align="center" nowrap="nowrap" width="30%">
															<div class="Payment_textbig5">ПЛАТЕЖНО НАРЕЖДАНЕ/ВНОСНА БЕЛЕЖКА
																<br /> за плащане от/към бюджета</div>
														</td>
														<td colspan="5" align="center" nowrap="nowrap">
															<div class="Payment_textbig5">PAYMENT ORDER/DEPOSIT SLIP
																<br /> for payment from/to the budget</div>
														</td>
														<td colspan="3" nowrap="nowrap">
															Вид валута
															<br />Type of currency
															<div class="Payment_textbig5" align="center"><?php echo $pay->CCY->SWIFTCode;?></div>
														</td>
														<td>
															Сума /Amount
															<br />
															<br />
															<div class="Payment_textbig5" align="right"><?php echo $amount;?></div>
														</td>
													</tr>
													<tr valign="top">
														<td>
															Основание за плащане / Reason for payment
														</td>
														<td colspan="9">
															<div class="Payment_textbig5"><?php echo mb_substr($pay->MovementDocument->Description, 0, 35);?></div>
														</td>
													</tr>
													<tr valign="top">
														<td>
															Още пояснения / Additional comments
														</td>
														<td colspan="9">
															<div class="Payment_textbig5"><?php echo mb_substr($pay->MovementDocument->Description, 35);?></div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="4">
															Вид* и номер на документа, по който се плаща / Type* and number of the payment document
															<br />
															<div class="Payment_textbig5">9 | <?php echo mb_substr($out["budget_document"],1);?>
															</div>
														</td>
														<td colspan="6">
															Дата (ддммгггг) на документа / Date (ddmmyyyy) of the document
															<div class="Payment_textbig5" align="right"><?php if(isset($out["budget_date"])){echo date("d.m.Y", strtotime($out["budget_date"]));}?></div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="3">
															Период, за който се плаща / Period for which payment is due
															<div align="right">От дата / From date</div>
														</td>
														<td colspan="2" align="center">
															<br />
															<div class="Payment_textbig5"><?php if(isset($out["budget_docDate"])){echo date("d.m.Y", strtotime($out["budget_docDate"]));}?></div>
														</td>
														<td colspan="3" nowrap="nowrap">
															<br />
															<div align="right">До дата / To date</div>
														</td>
														<td colspan="2" align="center">
															<br />
															<div class="Payment_textbig5"><?php if(isset($out["budget_docDate"])){echo date("d.m.Y", strtotime($out["budget_docDate"]));}?></div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="4">
															Задължено лице – наименование на юридическото лице или трите имена на физическото лице
															<br />Liable person – name of the corporate or individual
															<div class="Payment_textbig5" style="padding-left:80px"><?php echo $out["budget_debtor"];?></div>
														</td>
														<td colspan="6">
														</td>
													</tr>
													<tr valign="top">
														<td colspan="3">
															БУЛСТАТ на задълженото лице / BULSTAT of the liable person
															<div class="Payment_textbig5" style="padding-left:80px"><?php echo $out["budget_eik"];?></div>
														</td>
														<td colspan="4">
															ЕГН на задълженото лице / UCN of the liable person
															<div class="Payment_textbig5" style="padding-left:80px"><?php echo $out["budget_egn"];?></div>
														</td>
														<td colspan="3">
															ЛНЧ на задълженото лице / UFN of the liable person
														</td>
													</tr>
													<tr valign="top">
														<td colspan="10">
															Наредител – наименование на юридическото лице или трите имена на физическото лице / Ordering party – name of the corporate or individual
															<div class="Payment_textbig5" style="padding-left:80px"><?php echo $pay->MovementDocument->PayerName;?></div>
														</td>
													</tr>
													<tr valign="top">
														<td colspan="3">
															IBAN на наредителя / IBAN of the ordering party
															<div class="Payment_textbig5" style="padding-left:80px"><?php echo $pay->MovementDocument->PayerAccountNumber;?></div>
														</td>
														<td />
														<td colspan="6">
															BIC на банката на наредителя / BIC of the bank of the ordering party
															<div class="Payment_textbig5" align="right"><?php echo $pay->MovementDocument->PayerBAE;?></div>
														</td>
													</tr>
													<tr valign="top">
														<td>Платежна система / Payment System
															<br />
															<div class="Payment_textbig5" style="padding-left:50px">БИСЕРА</div>
														</td>
														<td colspan="2" nowrap="nowrap">Такси** / Fees**
															<div class="Payment_textbig5" align="right">002</div>
														</td>
														<td colspan="4">Дата на изпълнение/Date of execution
															<br />
															<div class="Payment_textbig5" align="right"><?php echo date("d.m.Y", strtotime($pay->ValDate));?></div>
														</td>
														<td />
														<td colspan="2">Вид плащане***
															<br />Type of payment***
															<div class="Payment_textbig5" align="right"><span id="PayerPaymentType_Copy" name="PayerPaymentType_Copy">0</span></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
								<td />
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table class="Payment_textsml4" cellpadding="4" width="100%" border="0">
							<tr valign="top">
								<td width="20" />
								<td width="40%"><span class="Payment_textsml5">* Вид документ / Type of document</span>
									<br />
									<br />1 – декларация / declaration;
									<br />2 – ревизионен акт / certificate of audit;
									<br />3 – наказателно постановление / penal decision
									<br />4 – авансова вноска / advance installment
									<br />5 – партиден номер на имот / estate batch number
									<br />6 – постановление за принудително събиране / ordinance for forced collection
									<br />9 – други / other
								</td>
								<td width="30%" nowrap="nowrap"><span class="Payment_textsml5">** Такси / Fees</span>
									<br />
									<br />1 – За сметка на наредителя / Our
									<br />
									<br />2 – Споделена (стандарт за местни преводи)
									<br /> Share (standard for local payment)
									<br />
									<br />3 – За сметка на получателя / Beneficiary
								</td>
								<td width="30%"><span class="Payment_textsml5">*** Вид плащане / Type of payment</span>
									<br />
									<br />Попълва се за сметки на администратори на приходи и на Централния бюджет
									<br />
									<br />Filled in for accounts of administrators of income and of Central budget</td>
								<td width="20" />
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<div class="out-text">отпечатано от e-postbank.bg</div>
	<?php
	}
	
	public function received_budget($pay){
	?>
	<center xmlns:xsi="http://web.w3.org/2001/XMLSchema-instance">
		<table width="630" border="1" class="colltable bordoTable">
			<tbody>
				<tr>
					<td>
						<table width="100%" cellpadding="1" cellspacing="1" border="0">
							<tbody>
								<tr>
									<td colspan="3" height="12"></td>
								</tr>
								<tr>
									<td width="20"></td>
									<td width="600" heigth="40" valign="middle"><?php echo $this->logo($pay->MovementDocument->PayerAccountNumber);?></td>
									<td width="20"></td>
								</tr>
								<tr>
									<td colspan="3" height="12"></td>
								</tr>
								<tr>
									<td colspan="3">
										<table cellspacing="4" cellpadding="2" width="600" border="0" class="bpb">
											<tbody>
												<tr valign="top">
													<td colspan="4" width="50%">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td width="30%">&nbsp;До /To</td>
																	<td class="Payment_textbig5"></td>
																</tr>
															</tbody>
														</table>
													</td>
													<td colspan="4" width="50%">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td>
																		<div class="Payment_textbig5" align="center"><?php echo $pay->DocRegNumber;?> - <?php echo date("d.m.Y", strtotime($pay->ValDate));?></div>
																	</td>
																</tr>
																<tr>
																	<td align="center">Номер и дата на подаване / Number and date of submission</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr valign="top">
													<td colspan="4" width="50%">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td width="30%">&nbsp;Клон /Branch</td>
																	<td class="Payment_textbig5"></td>
																</tr>
															</tbody>
														</table>
													</td>
													<td colspan="4" rowspan="2">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td align="center">Подписи на наредителя / Signatures of the ordering party</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr valign="top">
													<td colspan="4" width="50%">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td width="30%">&nbsp;Адрес / Address</td>
																	<td class="Payment_textbig5" colspan="2"></td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td colspan="8">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td colspan="2">&nbsp;Платете на – име на получателя / Please pay to – name of the beneficiary</td>
																</tr>
																<tr>
																	<td width="15%">&nbsp;</td>
																	<td>
																		<div class="Payment_textbig5" width="85%"><?php echo $pay->MovementDocument->PayeeName;?></div>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td colspan="2" height="30" width="30%" class="Payment_textsml3">
														&nbsp;IBAN на получателя
														<br>&nbsp;IBAN of the beneficiary
													</td>
													<td colspan="6" height="30" class="Payment_textbig5">
														<?php echo $pay->MovementDocument->PayeeAccountNumber;?></td>
												</tr>
												<tr>
													<td colspan="6" height="30">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td colspan="2">&nbsp;При банка – име на банката на получателя / At bank – name of the bank of beneficiary</td>
																</tr>
																<tr>
																	<td width="18%">&nbsp;</td>
																	<td class="Payment_textbig5"><?php echo $pay->MovementDocument->PayeeBAEName;?></td>
																</tr>
															</tbody>
														</table>
													</td>
													<td colspan="2">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td>&nbsp;Вид плащане / Type of payment</td>
																</tr>
																<tr>
																	<td>
																		<div class="Payment_textbig5" align="right">&nbsp;&nbsp;</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td class="Payment_textbig5" style="FONT-SIZE: 14px;LETTER-SPACING: -0.2mm" align="middle" colspan="2" height="40" width="40%"><b>
						БЮДЖЕТНО&nbsp;ПЛАТЕЖНО НАРЕЖДАНЕ
					</b></td>
													<td class="Payment_textsml3" style="FONT-SIZE: 14px; LETTER-SPACING:- 0.2mm" align="middle" colspan="2" height="40" width="40%"><b>
						BUDGET&nbsp;PAYMENT ORDER
					</b></td>
													<td align="left" width="17%">
														<table cellspacing="0" cellpadding="0" border="0" class="bpb">
															<tbody>
																<tr>
																	<td align="left" nowrap="nowrap">&nbsp;Вид валута / Currency</td>
																</tr>
																<tr>
																	<td>
																		<div class="Payment_textbig5" align="center"><?php echo $pay->CCY->SWIFTCode;?></div>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
													<td width="33%" colspan="3">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td>&nbsp;Сума</td>
																</tr>
																<tr>
																	<td>
																		<div class="Payment_textbig5" align="right"><?php echo number_format((float)$pay->MovementAmount, 2,'.','');?></div>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td colspan="8" width="50%">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td colspan="2">&nbsp;Основание за плащане – Код на наредителя (БУЛСТАТ) &nbsp; Параграф по ЕБК / вид данъчно или митническо задължение
																		<br>&nbsp;Reason for payment – Code of the ordering party (BULSTAT) &nbsp; Paragraph in UBC / type of tax or customs liability
																	</td>
																</tr>
																<tr>
																	<td width="30%">&nbsp;</td>
																	<td class="Payment_textbig5"><?php echo mb_substr($pay->MovementDocument->Description, 0, 35);?></td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td colspan="8" width="50%">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td colspan="2">&nbsp; Още пояснения / Additional comments

																	</td>
																</tr>
																<tr>
																	<td width="30%">&nbsp;</td>
																	<td class="Payment_textbig5"><?php echo mb_substr($pay->MovementDocument->Description, 35);?></td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td colspan="6" height="30">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td colspan="2">&nbsp;Наредител – име на иницииращия плащането бюджетен разпоредител / Ordering party – name of the budget authorizer who initiated the payment</td>
																</tr>
																<tr>
																	<td width="17%">&nbsp;</td>
																	<td class="Payment_textbig5"><?php echo $pay->MovementDocument->PayerName;?></td>
																</tr>
															</tbody>
														</table>
													</td>
													<td height="30" colspan="2">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td>&nbsp;Код дейност
																		<br>&nbsp;Activity code
																	</td>
																</tr>
																<tr>
																	<td>
																		<div class="Payment_textbig5" align="right">&nbsp;</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr valign="top">
													<td colspan="2" height="30">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td colspan="2" nowrap="nowrap">&nbsp;Дата на изпълнение/Date of execution</td>
																</tr>
																<tr>
																	<td width="60%">&nbsp;</td>
																	<td class="Payment_textbig5"><?php echo date("d.m.Y", strtotime($pay->ValDate));?></td>
																</tr>
															</tbody>
														</table>
													</td>
													<td height="30" colspan="3">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td nowrap="nowrap">&nbsp;Код на бюджетен разпоредител/<br/>Code of the budget authorizer
																	</td>
																</tr>
																<tr>
																	<td>
																		<div class="Payment_textbig5" align="right"></div>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
													<td height="30" colspan="3">
														<table cellspacing="0" cellpadding="0" width="100%" border="0" class="bpb">
															<tbody>
																<tr>
																	<td nowrap="nowrap">&nbsp;Вид плащане в СЕБРА/<br/>Type of payment in SEBRA
																	</td>
																</tr>
																<tr>
																	<td>
																		<div class="Payment_textbig5" align="right">3&nbsp;</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td colspan="8">
														<table style="color:#a0a0a0">
															<tbody>
																<tr valign="top">
																	<td>* Вид документ / Type of document:</td>
																	<td>1 – декларация/declaration; 2 – ревизионен акт/certificate of audit; 3 – наказателно постановление/penal decision; 4 – авансова вноска/advance installment; 5 – партиден номер на имот/estate batch number; 6 – постановление за принудително събиране/ ordinance for forced collection; 9 – други/other</td>
																</tr>
																<tr valign="top">
																	<td>Забележка / Note: </td>
																	<td>За всеки отделен данък, акцизна стока или услуга, такса мито, осигуровка, лихва, имот, ППС и др. или вид документ, се попълва отделен платежен документ/A separate document of payment has to be filled in for each separate tax, excised good or service, customs fee, insurance, interest, estate, vehicle, etc.</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="Payment_textsml2" style="width:645px;padding:0px;margin:0px;text-align:right">отпечатано от e-postbank.bg</div>
	</center>
	<?php
	}
	
}


?>
