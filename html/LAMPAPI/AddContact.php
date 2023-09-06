<?php

	try{
	$inData = getRequestInfo();

	$FirstName = $inData["FirstName"];
	$LastName = $inData["LastName"];
	$UserID = $inData["UserID"];

	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		try{
		$stmt = $conn->prepare("INSERT into Contacts (UserID,FirstName,LastName) VALUES(?,?,?)");
		$stmt->bind_param("sss", $UserID, $FirstName, $LastName);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		returnWithError("");
		}catch (Exception $e) {
			returnWithError("An error occurred: " . $e->getMessage()); }
	}
}catch (Exception $e) {
	returnWithError("An error occurred: " . $e->getMessage()); }

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>