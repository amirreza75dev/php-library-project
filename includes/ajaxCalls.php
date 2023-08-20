<?php 
require_once 'functions.php';
session_start();

$action = $_GET['action'];

switch($action) {
    case 'login':
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
    
        $email = $data['email'];
        $password = $data['password'];
        $selectedRadio = $data['selectedRadio'];
        
        if($selectedRadio === "employee"){

            $employeeInf = loginEmployee($email);
    
            if($employeeInf && password_verify($password, $employeeInf["password"])) {
                $_SESSION['employee_id'] = $employeeInf['employee_id'];
                $_SESSION['employee_email'] = $employeeInf['email'];
                    // Send a JSON response back to the client
                $response = array('message' => 'successful','page'=>'./employee.php');
                echo json_encode($response);
            } else {
                echo json_encode(array('message' => 'unsuccessful'));
            }
        } else {
            // retrieve information
            $userInf = loginUser($email);
    
            if($userInf && password_verify($password, $userInf["password"])){
                $_SESSION['user_id'] = $userInf['client_id'];
                $_SESSION['user_email'] = $userInf['email'];
                // Send a JSON response back to the client
                $response = array('message' => 'successful', 'page'=>'./user.php');
                echo json_encode($response);
            }else{
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
            

            if($selectedRadio =="employee"){
                    // add to database
    
                registerEmployee($name,$email,$hashedPassword);

            }else{
                registerUser($name,$email,$hashedPassword);

            }


            // Send a JSON response back to the client
            $response = array('message' => 'successful');
            echo json_encode($response);

        break;
    case 'readRequests':
            $employee_id = $_SESSION['employee_id'];
            // getting requests list from database
            
            $bookArray = readRequest();
            $pendingRequests = [];
            foreach($bookArray as $book){
                if($book['status']=="pending"){
                    $pendingRequests[] =$book;

                }



            };

            echo json_encode($pendingRequests);
        break;
    case 'lending':
            $employee_id = $_SESSION['employee_id'];

    // Get JSON data from the client
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            $status = $data['status'];
            $requestId = $data['requestID'];    
            $clientID = $data['clientID'];
            $bookID = $data['bookID'];
            
            if($status == "accepted"){
                
                updateRequestStatus($status,$requestId);

                addLending($clientID,$employee_id,$bookID,$requestId);

                $message = array("message"=> "lending request added");
                echo json_encode($message);

            }else{

                $request->updateRequestStatus($status,$requestId);
                

                removeLending($requestId);

                $message = array("message"=> "lending request removed");
                echo json_encode($message);


    }
        break;
    case 'addingBook':
                 $jsonData = file_get_contents('php://input');
                $data = json_decode($jsonData, true);
                $book_name = $data['book_name'];
                $author_id = $data['author_id'];
                $section_id = $data['section_id'];
                $avl = $data['avl'];

                addBook($book_name,$author_id,$section_id ,$avl);

                $message = array("message"=> "successful");
                echo json_encode($message);

        break;
    case 'books':
                
                $bookArray =books();

                $html ='';

                foreach($bookArray as $book){

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
                };
                

                echo $html;
        break;
    case 'readUserRequest':
                $client_id = $_SESSION['user_id'];

                $userRequests =readUserRequest($client_id);

                echo json_encode($userRequests);
        break;
    case 'requestedBooks':
                $user_id = $_SESSION['user_id'];

                // Get JSON data from the client
                $jsonData = file_get_contents('php://input');
                $data = json_decode($jsonData, true);
            
                foreach($data as $book){
                    $book_id = $book['book_id'];
                    addRequest($user_id,$book_id);
            
                }
                $message = array("message"=> "successful");
                echo json_encode($message);
        break;

    default:
        echo "Unknown action: $action";

}