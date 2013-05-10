<?php

try
{
	//Open database connection
	//$con = mysql_connect("168.63.249.136","root","jahrakal");
	$con = mysql_connect("localhost","root","");
	mysql_select_db("irace", $con);
	//Getting records (listAction)
	if($_GET["action"] == "list")
	{
		//Get record count
		$result = mysql_query("SELECT COUNT(*) AS RecordCount FROM registrations WHERE reg_id =".$_GET["reg_id"].";");
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];

		//Get records from database
	    $result = mysql_query("SELECT * FROM registrations WHERE reg_id =".$_GET["reg_id"].";");
		
		//$result = mysql_query("SELECT * FROM races;");	
		//Add all records to an array
		$rows = array();
		while($row = mysql_fetch_array($result))
		{
		    $rows[] = $row;
		}

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
		//Update record in database
		$result = mysql_query("UPDATE registrations SET reg_e_name = '".$_POST["reg_e_name"]."', reg_e_relationship = '".$_POST["reg_e_relationship"]."', reg_e_contact = '".$_POST["reg_e_contact"]."' WHERE reg_id ='".$_POST["reg_id"]."'");
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
}
catch(Exception $ex)
{
    //Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
	
?>