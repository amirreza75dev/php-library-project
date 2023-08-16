<?php
include '../model/db-connection.php';
session_start();

$client_id = $_SESSION['user_id'];

$request = new requests($pdo);

$userRequests = $request->readUserRequest($client_id);

echo json_encode($userRequests);