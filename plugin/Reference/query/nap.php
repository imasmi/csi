<?php 
if($_POST['DocRequestPe_docs_docenum'][1] == "on"){	
	$debt = $PDO -> prepare("INSERT INTO document (name,type,user,sender_receiver,date,note,case_id,person) VALUES (4,'outgoing','" . $_SESSION["user"] . "',3348, '" . date("Y-m-d") . "', :nap, '" . $_GET["case"] . "', '" . $_GET["person"] . "')");
	$debt->execute(array("nap" =>$_POST["NAP_number"]));
	$debt_id = $PDO->lastInsertId();
}

if($_POST['DocRequestPe_docs_docenum'][2] == "on"){	
	$reference = $PDO -> prepare("INSERT INTO document (name,type,user,sender_receiver,date,note,case_id, person) VALUES (5,'outgoing','" . $_SESSION["user"] . "',3348, '" . date("Y-m-d") . "', :nap, '" . $_GET["case"] . "', '" . $_GET["person"] . "')");
	$reference->execute(array("nap" =>$_POST["NAP_number"]));
}
	
if(isset($_POST["DocRequestPe_case_date"]) && $_POST["DocRequestPe_case_date"] != "0000-00-00" && $_POST["DocRequestPe_case_date"] != ""){
	$Caser = new \plugin\Caser\php\Caser($_GET["case"]);
	$update_date = $PDO->query("UPDATE caser_title SET date = '" . $_POST["DocRequestPe_case_date"] . "' WHERE id=" . $Caser->title_main["id"]);
}


#INSERT NOTE IF WAIT NAP IS CHECKED
if($_POST["wait_nap"]){
	$array = array(
		"note" => "Чака НАП - " . $_POST["NAP_number"],
		"case_id" => $_GET["case"],
		"debtor_id" => $_GET["person"],
		"user_id" => 2,
		"doc_id" => $debt_id,
		"period" => date("Y-m-d 08:00:00", strtotime("7 days")),
		"date" => date("Y-m-d H:i:s"),
		"events" => 1,
		"payment" => 1
	);

	$insert = \system\Query::insert($array, "note");
}

echo '<script>close()</script>';
?>