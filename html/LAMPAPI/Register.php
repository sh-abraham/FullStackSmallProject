
<?php
	$inData = getRequestInfo();
	
	$ID = 0;
	$Login = $inData["Login"];

	#header("Access-Control-Allow-Origin: http://cop4331-f23.com");
	#header("Access-Control-Allow_Methods: POST, OPTIONS");
	#header("Access-Control-Allow_Headers: Content-Type");
	#header("Access-Control-Max-Age: 86400");

    $conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	try{
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$sql = "SELECT * FROM Users WHERE Login=?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $Login);
		$stmt->execute();
		$result = $stmt->get_result();
		$nrows = mysqli_num_rows($result);
		if ($nrows == 0)
		{
			$stmt = $conn->prepare("INSERT into Users (FirstName, LastName, Login, Password) VALUES(?,?,?,?)");
			$stmt->bind_param("ssss", $inData["FirstName"], $inData["LastName"], $Login, $inData["Password"]);
			$stmt->execute();
			$stmt->close();
			$conn->close();
			returnWithError("");
		}
		else
		{
			returnWithError("Login taken. Try another!");
		}
	}
	}catch (Exception $e) {
		returnWithError("An error occurred: " . $e->getMessage());
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
