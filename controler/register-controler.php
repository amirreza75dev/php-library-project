<?php
include '../model/db-connection.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON data from the client
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    // Process the JSON data
    $name = $data['name'];
    $email = $data['email'];
    $password = $data['password'];
    $selectedRadio = $data['selectedRadio'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    

    if($selectedRadio =="employee"){
            // add to database
        $employee = new employee($pdo);

        $employee->registerEmployee($name,$email,$hashedPassword);

    }else{
        $user = new user($pdo);

        $user->registerUser($name,$email,$hashedPassword);

    }


    // Send a JSON response back to the client
    $response = array('message' => 'successful');
    echo json_encode($response);
} else {
    echo json_encode(array('message' => 'unsuccessful'));
}







