<?php
$inData = getRequestInfo();

$ID = $inData["ID"];
$firstName = $inData["FirstName"];
$lastName = $inData["LastName"];
$email = $inData["Email"];

$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
if ($conn->connect_error) {
    returnWithError($conn->connect_error);
} else {
    // Update the Contact information from database.
    $stmt = $conn->prepare("UPDATE Contacts SET FirstName=?, LastName=?, Email=? WHERE ID = ?");
    $stmt->bind_param("sssi", $firstName, $lastName, $email, $ID);
    
    if ($stmt->execute()) {
        returnWithError("");
    } else {
        returnWithError("Failed to update contact.");
    }

    $stmt->close();
    $conn->close();
}

function getRequestInfo()
{
    return json_decode(file_get_contents('php://input'), true);
}

function sendResultInfoAsJson($obj)
{
    header('Content-type: application/json');
    echo $obj;
}

function returnWithError($err)
{
    $retValue = '{"error":"' . $err . '"}';
    sendResultInfoAsJson($retValue);
}
?>
