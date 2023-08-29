<?php
require_once 'functions.php';
session_start();
$action = $_GET['action'];
switch ($action) {
    case 'login':
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $email = $data['email'];
        $password = $data['password'];
        $selectedRadio = $data['selectedRadio'];
        if ($selectedRadio === "employee") {
            $employeeInf = loginEmployee($email);
            if ($employeeInf && password_verify($password, $employeeInf["password"])) {
                $_SESSION['employee_id'] = $employeeInf['employee_id'];
                $_SESSION['employee_email'] = $employeeInf['email'];
                // Send a JSON response back to the client
                $response = array('message' => 'successful', 'page' => './employee.php');
                echo json_encode($response);
            } else {
                echo json_encode(array('message' => 'unsuccessful'));
            }
        } else {
            // retrieve information
            $userInf = loginClient($email);

            if ($userInf && password_verify($password, $userInf["password"])) {
                $_SESSION['user_id'] = $userInf['client_id'];
                $_SESSION['user_email'] = $userInf['email'];
                // Send a JSON response back to the client
                $response = array('message' => 'successful', 'page' => './user.php');
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
        $employee_id = $_SESSION['employee_id'];
        // getting requests list from database
        $bookArray = getRequest();
        $pendingRequests = [];
        foreach ($bookArray as $book) {
            if ($book['status'] == "pending") {
                $pendingRequests[] = $book;
            }
        }
        echo json_encode($pendingRequests);
        break;
    case 'lending':
        $employeeId = $_SESSION['employee_id'];
        // Get JSON data from the client
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $status = $data['status'];
        $requestId = $data['requestID'];
        $clientID = $data['clientID'];
        $bookID = $data['bookID'];
        if ($status == "accepted") {
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
    case 'books':
        $bookArray = books();
        $html = '';
        foreach ($bookArray as $book) {
            $bookName = $book['book_name'];
            $bookAuthor = $book['author_name'];
            $bookId = $book['book_id'];
            $html .= "<tr info='$bookId'>
                                    <td>$bookAuthor</td>
                                    <td>$bookName</td>
                                    <td>
                                        <img class='book-req' src='./img/accept.png' alt='accept'>                                  
                                    </td>                               
                     </tr>";
        }
        echo $html;
        break;
    case 'userRequest':
        $clientId = $_SESSION['user_id'];
        $userRequests = getUserRequest($clientId);
        echo json_encode($userRequests);
        break;
    case 'requestedBooks':
        $userId = $_SESSION['user_id'];
        // Get JSON data from the client
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        foreach ($data as $book) {
            $bookId = $book['book_id'];
            addRequest($userId, $bookId);
        }
        $message = array("message" => "successful");
        echo json_encode($message);
        break;
    default:
        echo "Unknown action: $action";
}