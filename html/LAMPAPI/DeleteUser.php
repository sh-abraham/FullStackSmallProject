<?php


	$inData = getRequestInfo();

	$ID = $inData["ID"];

	header("Access-Control-Allow-Origin: http://cop4331-f23.com");
	header("Access-Control-Allow_Methods: POST, OPTIONS");
	header("Access-Control-Allow_Headers: Content-Type");
	header("Access-Control-Max-Age: 86400");

	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{

		$stmt = $conn->prepare("DELETE FROM Users WHERE ID = ?");
		$stmt->bind_param("s", $ID);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		returnWithError("");
		
	}

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
