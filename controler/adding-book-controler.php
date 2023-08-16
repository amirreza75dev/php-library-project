<?php
include '../model/db-connection.php';
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);
$book_name = $data['book_name'];
$author_id = $data['author_id'];
$section_id = $data['section_id'];
$avl = $data['avl'];

$book = new book($pdo);

$book->addBook($book_name,$author_id,$section_id ,$avl);

$message = array("message"=> "successful");
echo json_encode($message);

