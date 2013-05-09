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
		$result = mysql_query("SELECT COUNT(*) AS RecordCount FROM registrations WHERE dist_id =".$_GET["dist_id"].";");
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];

		//Get records from database
	    $result = mysql_query("SELECT * FROM registrations WHERE dist_id =".$_GET["dist_id"].";");
		
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
	//Creating a new record (createAction)
	else if($_GET["action"] == "create")
	{
		//$dist_id = $_GET["dist_id"];
		//Insert record into database
		$result = mysql_query("INSERT INTO registrations (dist_id, user_id, reg_date, reg_name, reg_gender, reg_address, reg_email, reg_mobile, reg_birthday, reg_affiliation, reg_shirt_size, reg_status, reg_e_name, reg_e_relationship, reg_e_contact, reg_del_address) VALUES('".$_POST["dist_id"]."', '".$_POST["user_id"]."', '".$_POST["reg_date"]."', '".$_POST["reg_name"]."', '".$_POST["reg_gender"]."', '".$_POST["reg_address"]."', '".$_POST["reg_email"]."', '".$_POST["reg_mobile"]."', '".$_POST["reg_birthday"]."', '".$_POST["reg_affiliation"]."', '".$_POST["reg_shirt_size"]."', '".$_POST["reg_status"]."', '".$_POST["reg_e_name"]."', '".$_POST["reg_e_relationship"]."', '".$_POST["reg_e_contact"]."','".$_POST["reg_del_address"]."');");

		//Get last inserted record (to return to jTable)
		$result = mysql_query("SELECT * FROM registrations WHERE reg_id = LAST_INSERT_ID();");
		$row = mysql_fetch_array($result);

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
		//Update record in database
		$result = mysql_query("UPDATE registrations SET reg_date = '".$_POST["reg_date"]."', reg_name= '".$_POST["reg_name"]."', reg_address = '".$_POST["reg_address"]."', reg_gender = '".$_POST["reg_gender"]."', reg_email= '".$_POST["reg_email"]."', reg_mobile = '".$_POST["reg_mobile"]."', reg_birthday = '".$_POST["reg_birthday"]."', reg_address = '".$_POST["reg_address"]."', reg_affiliation = '".$_POST["reg_affiliation"]."' , reg_shirt_size = '".$_POST["reg_shirt_size"]."' WHERE reg_id ='".$_POST["reg_id"]."'");
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		//Delete from database
		$result = mysql_query("DELETE FROM registrations WHERE reg_id = ".$_POST["reg_id"].";");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}

	//Close database connection
	mysql_close($con);

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