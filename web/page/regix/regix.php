<?php
$doc = new DOMDocument();
$doc->loadXML('<EmploymentContractsRequest xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://regix-service-test.egov.bg/RegiX/NRA/EmploymentContracts/Request">
            <Identity>
              <ID>123456</ID>
              <TYPE>LNC</TYPE>
            </Identity>
          </EmploymentContractsRequest>');

$request = array(
	"request" => array(
		"Operation" => "TechnoLogica.RegiX.NRAEmploymentContractsAdapter.APIService.INRAEmploymentContractsAPI.GetEmploymentContracts",
		"CallContext" => array(
			"ServiceURI" => "132-11123-01.01.2016",
			"ServiceType" => "За проверовъчна дейност",
			"EmployeeIdentifier" => "tl_ytoteva",
			"EmployeeNames" => "Йорданка Тотева",
			"EmployeeAditionalIdentifier" => "",
			"EmployeePosition" => "SW Developer",
			"AdministrationOId" => "2.16.100.1.1.1.1.15",
			"AdministrationName" => "Министерство на транспорта, информационните технологии и съобщенията",
			"LawReason" => "За целите на разработката и тестването на RegiX.",
			"Remark" => ""
		),
		"SignResult" => false,
		"ReturnAccessMatrix" => true
	)
);


$request = json_decode(json_encode($request));
// Initialize WS with the WSDL
$wsdl = \system\Core::doc_root() . "/web/page/regix/RegiXEntryPoint.xml";

$client = new SoapClient($wsdl);

// Invoke WS method (Function1) with the request params 
$response = $client->ExecuteSynchronous($request);
var_dump($response);
?>