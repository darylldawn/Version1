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
		$result = mysql_query("SELECT COUNT(*) AS RecordCount FROM distances WHERE race_id =".$_GET["race_id"].";");
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];

		//Get records from database
	    $result = mysql_query("SELECT * FROM distances WHERE race_id =".$_GET["race_id"]." ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");
		
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
		$result = mysql_query("INSERT INTO distances (race_id, dist_type, dist_name, dist_price) VALUES('".$_POST["race_id"]."', '".$_POST["dist_type"]."', '".$_POST["dist_name"]."','".$_POST["dist_price"]."');");

		//Get last inserted record (to return to jTable)
		$result = mysql_query("SELECT * FROM distances WHERE dist_id = LAST_INSERT_ID();");
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
		$result = mysql_query("UPDATE distances SET dist_type = '".$_POST["dist_type"]."', dist_name = '".$_POST["dist_name"]."', dist_price = '".$_POST["dist_price"]."' WHERE dist_id ='".$_POST["dist_id"]."'");
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		//Delete from database
		$result = mysql_query("DELETE FROM distances WHERE dist_id = ".$_POST["dist_id"].";");

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