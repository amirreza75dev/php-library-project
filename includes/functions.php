<?php 

// database connection

function databaseConnection(){
 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";

    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
    
}

// add employee

function registerEmployee($name,$email,$pass){
        $pdo = databaseConnection();

        $sql = "INSERT INTO employees (employee_name, email, password) VALUES (:name, :email, :pass)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();
        return true;

}

// login employee
    // login employee
function loginEmployee($email){
        $pdo = databaseConnection();

        $sql = "SELECT * FROM employees WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);
        return $employee;


}

// add user
function registerUser($name,$email,$pass){
        $pdo = databaseConnection();

        $sql = "INSERT INTO clients (client_name, email, password) VALUES (:name, :email, :pass)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();
        return true;


}

// login employee
function loginUser($email){
        $pdo = databaseConnection();

        $sql = "SELECT * FROM clients WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;


}


// retriveing books
function books(){
        $pdo = databaseConnection();
    
        $sql = "
                        SELECT 
                            books.book_id,
                            books.book_name,
                            books.section_id,
                            books.author_id,
                            books.available_numbers,
                            authors.author_name
                        FROM
                            books
                        INNER JOIN
                            authors ON books.author_id = authors.author_id
                    ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $books;


}

// adding new book
        
function addBook($book_name,$section_id,$author_id,$available_numbers){
        $pdo = databaseConnection();

        $sql = "
                    INSERT INTO books (book_name, section_id, author_id, available_numbers) VALUES (:book_name, :section_id, :section_id,:available_numbers)
                    ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':book_name', $book_name);
        $stmt->bindParam(':section_id', $section_id);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->bindParam(':available_numbers', $available_numbers);
        $stmt->execute();
        
        return;


}

// add request
function addRequest($client_id,$book_id){
         $pdo = databaseConnection();
  
        $sql = "INSERT INTO requests (client_id, book_id) VALUES (:client_id, :book_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':book_id', $book_id);
        $stmt->execute();
        return true;

}

//read requests
function readRequest(){
            $pdo = databaseConnection();

            $sql = "SELECT
                            r.request_id,
                            r.status,
                            c.client_id,
                            b.book_id,
                            c.client_name,
                            b.book_name,
                            b.available_numbers
                        FROM
                            requests r
                        JOIN
                            clients c ON r.client_id = c.client_id
                        JOIN
                            books b ON r.book_id = b.book_id;
    
                    ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $requests;


}


//read specific user requests
function readUserRequest($client_id){
            $pdo = databaseConnection();
 
            $sql = "SELECT
                            r.request_id,
                            r.status,
                            b.book_name,
                            b.book_id
                        
                        FROM
                            requests r
                        JOIN
                            books b ON r.book_id = b.book_id

                        WHERE  r.client_id = :client_id;
    
                    ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->execute();
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $requests;


}

//updating request status 
function updateRequestStatus($status,$requestId){
        $pdo = databaseConnection();

        $sql ="UPDATE requests SET status =:status WHERE request_id =:requestId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':requestId', $requestId);
        $stmt->execute();
        return true;


}

//adding lendings
function addLending($clientId,$employeeId,$bookId,$requestId){
        $pdo = databaseConnection();


        $sql = "INSERT INTO lendings (client_id, employee_id, book_id, request_id) VALUES (:clientId, :employeeId,:bookId,:requestId)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':clientId', $clientId);
        $stmt->bindParam(':employeeId', $employeeId);
        $stmt->bindParam(':bookId', $bookId);
        $stmt->bindParam(':requestId', $requestId);
        $stmt->execute();
        return true;



}

//removing lending
function removeLending($requestId){
        $pdo = databaseConnection();


        $sql = "DELETE FROM lendings WHERE request_id = :requestId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':requestId', $requestId);
        $stmt->execute();
        return true;



}