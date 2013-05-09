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
		$result = mysql_query("SELECT COUNT(*) AS RecordCount FROM races;");
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];

		//Get records from database
	    $result = mysql_query("SELECT * FROM races ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");
		
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
		//Insert record into database
		$result = mysql_query("INSERT INTO races (race_title, race_date, race_location) VALUES('".$_POST["race_title"]."','".$_POST["race_date"]."', '".$_POST["race_location"]."');");

		//Get last inserted record (to return to jTable)
		$result = mysql_query("SELECT * FROM races WHERE race_id = LAST_INSERT_ID();");
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
		$result = mysql_query("UPDATE races SET race_title = '".$_POST["race_title"]."', race_date = '".$_POST["race_date"]."', race_location = '".$_POST["race_location"]."' WHERE race_id ='".$_POST["race_id"]."'");
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		//Delete from database
		$result = mysql_query("DELETE FROM races WHERE race_id = ".$_POST["race_id"].";");

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