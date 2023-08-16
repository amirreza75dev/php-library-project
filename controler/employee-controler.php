<?php
include '../model/db-connection.php';
session_start();
$employee_id = $_SESSION['employee_id'];
// getting requests list from database
$request = new requests($pdo);

$bookArray = $request->readRequest();
$pendingRequests = [];
foreach($bookArray as $book){
    if($book['status']=="pending"){
        $pendingRequests[] =$book;

    }



};

echo json_encode($pendingRequests);