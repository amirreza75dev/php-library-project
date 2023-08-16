<?php 

include '../model/db-connection.php';
session_start();
$employee_id = $_SESSION['employee_id'];

// Get JSON data from the client
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$status = $data['status'];
$requestId = $data['requestID'];
$clientID = $data['clientID'];
$bookID = $data['bookID'];
$request = new requests($pdo);
if($status == "accepted"){
    
    $request->updateRequestStatus($status,$requestId);

    $lending = new lending($pdo);

    $lending->addLending($clientID,$employee_id,$bookID,$requestId);

    $message = array("message"=> "lending request added");
    echo json_encode($message);



}else{

    $request->updateRequestStatus($status,$requestId);
    $lending = new lending($pdo);

    $lending->removeLending($requestId);

    $message = array("message"=> "lending request removed");
    echo json_encode($message);





}


