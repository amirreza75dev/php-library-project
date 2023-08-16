<?php
include '../model/db-connection.php';
session_start();

$user_id = $_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = new requests($pdo);
    // Get JSON data from the client
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    foreach($data as $book){
        $book_id = $book['book_id'];
        $request->addRequest($user_id,$book_id);

    }
$message = array("message"=> "successful");
echo json_encode($message);

}