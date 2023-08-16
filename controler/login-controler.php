<?php
session_start();
include '../model/db-connection.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON data from the client
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    // Process the JSON data
    $email = $data['email'];
    $password = $data['password'];
    $selectedRadio = $data['selectedRadio'];
    
    if($selectedRadio =="employee"){
            // retrieve information
        $employee = new employee($pdo);

        $employeeInf = $employee->loginEmployee($email);

        if($employeeInf && password_verify($password,$employeeInf["password"])){
            $_SESSION['employee_id'] = $employeeInf['employee_id'];
            $_SESSION['employee_email'] = $employeeInf['email'];
                // Send a JSON response back to the client
            $response = array('message' => 'successful','page'=>'./employee.php');
            echo json_encode($response);



        }else{

            echo json_encode(array('message' => 'unsuccessful'));
        }

    }else{
        // retrieve information
        $user = new user($pdo);
        $userInf = $user->loginUser($email);

        if($userInf && password_verify($password,$userInf["password"])){
            $_SESSION['user_id'] = $userInf['client_id'];
            $_SESSION['user_email'] = $userInf['email'];
            // Send a JSON response back to the client
            $response = array('message' => 'successful', 'page'=>'./user.php');
            echo json_encode($response);



        }else{
            echo json_encode(array('message' => 'unsuccessful'));
        }

    }



} else {
    echo json_encode(array('message' => 'unsuccessful'));
}