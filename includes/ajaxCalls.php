<?php
require_once 'functions.php';
session_start();
$action = $_REQUEST['action'];
switch ($action) {
    case 'login':
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $email = $data['email'];
        $password = $data['password'];
        $selectedRadio = $data['selectedRadio'];
        if ($selectedRadio === "employee") {
            $employeeInf = getEmployee($email);
            if ($employeeInf && password_verify($password, $employeeInf["password"])) {
                $_SESSION['employeeId'] = $employeeInf['employee_id'];
                $_SESSION['employeeEmail'] = $employeeInf['email'];
                // Send a JSON response back to the client
                $response = array('message' => 'successful', 'page' => './employee.php');
                echo json_encode($response);
            } else {
                echo json_encode(array('message' => 'unsuccessful'));
            }
        } else {
            // retrieve information
            $clientInf = getClient($email);
            if ($clientInf && password_verify($password, $clientInf["password"])) {
                $_SESSION['clientId'] = $clientInf['client_id'];
                $_SESSION['clientEmail'] = $clientInf['email'];
                // Send a JSON response back to the client
                $response = array('message' => 'successful', 'page' => './client.php');
                echo json_encode($response);
            } else {
                echo json_encode(array('message' => 'unsuccessful'));
            }
        }
        break;
    case 'register':
        // Get JSON data from the client
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        // Process the JSON data
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $selectedRadio = $data['selectedRadio'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if ($selectedRadio == "employee") {
            // add to database
            addEmployee($name, $email, $hashedPassword);
        } else {
            addClient($name, $email, $hashedPassword);
        }
        // Send a JSON response back to the client
        $response = array('message' => 'successful');
        echo json_encode($response);
        break;
    case 'readRequests':
        $employeeId = $_SESSION['employeeId'];
        // getting requests list from database
        $bookArray = getBookRequests();
        $pendingRequests = [];
        foreach ($bookArray as $book) {
            if ($book['status'] == "pending") {
                $pendingRequests[] = $book;
            }
        }
        echo json_encode($pendingRequests);
        break;
    case 'lending':
        $employeeId = $_SESSION['employeeId'];
        // Get JSON data from the client
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $status = $data['status'];
        $requestId = $data['requestId'];
        $clientId = $data['clientId'];
        $bookId = $data['bookId'];
        if ($status == "accepted") {
            bookAvailabilityUpdate('decrease',$bookId);
            updateRequestStatus($status, $requestId);
            addLending($employeeId,$requestId);
            $message = array("message" => "lending request added");
            echo json_encode($message);
        } else {
            updateRequestStatus($status, $requestId);
            removeLending($requestId);
            $message = array("message" => "lending request removed");
            echo json_encode($message);
        }
        break;
    case 'addingBook':
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $bookName = $data['bookName'];
        $authorId = $data['authorId'];
        $sectionId = $data['sectionId'];
        $avl = $data['avl'];
        addBook($bookName, $authorId, $sectionId, $avl);
        $message = array("message" => "successful");
        echo json_encode($message);
        break;
    case 'clientRequest':
        $clientId = $_SESSION['clientId'];
        $clientRequests = getClientRequests($clientId);
        echo json_encode($clientRequests);
        break;
    case 'requestedBooks':
        $clientId = $_SESSION['clientId'];
        // Get JSON data from the client
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $bookId = $data['book_id'];
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        addBookRequest($clientId, $bookId, $startDate, $endDate);
        $message = array("message" => "successful");
        echo json_encode($message);
        break;
    case 'clientBooks':
        // Get JSON data from the client
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        // Process the JSON data
        $searchedValue = $data['searchedValue'];
        $clientBooks =clientBooks($searchedValue);
        $message = array("message" => "successful", "data" => $clientBooks);
        echo json_encode($message);
        break;
    case 'received':
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        // Process the JSON data
        $requestId = $data['requestId'];
        $queryResponse = lendingsStatusUpdate($requestId);
        echo json_encode($queryResponse);
        break;
        case 'reservedBooks':
            $clientId = $_SESSION['clientId'];
            // Get JSON data from the client
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);
            $bookId = $data['bookId'];
            $status = 'reserved';
            addReservationRequest($clientId, $bookId, $status);
            $message = array("message" => "successful");
            echo json_encode($message);
            break;
    case 'logout':
        logout();
        break;
    default:
        echo "Unknown action: $action";
}