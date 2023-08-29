<?php
// Load environment variables from .env file
function loadingEnvVars()
{
    $envFilePath = dirname(__DIR__) . '/.env';
    if (file_exists($envFilePath)) {
        $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            list($name, $value) = explode('=', $line, 2);
            $_ENV[$name] = $value;
        }
    }
}
// database connection
function databaseConnection()
{
    loadingEnvVars();
    $servername = $_ENV['servername'];
    $username = $_ENV['username'];
    $password = '';
    $dbname = $_ENV['dbname'];
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
// add employee
function addEmployee($name, $email, $pass)
{
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
function loginEmployee($email)
{
    $pdo = databaseConnection();
    $sql = "SELECT * FROM employees WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    return $employee;
}
// add user
function addClient($name, $email, $pass)
{
    $pdo = databaseConnection();
    $sql = "INSERT INTO clients (client_name, email, password) VALUES (:name, :email, :pass)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $pass);
    $stmt->execute();
    return true;
}
// login client
function loginClient($email)
{
    $pdo = databaseConnection();
    $sql = "SELECT * FROM clients WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}
// retriveing books
function books()
{
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
function addBook($bookName, $sectionId, $authorId, $availableNumbers)
{
    $pdo = databaseConnection();
    $sql = "
                    INSERT INTO books (book_name, section_id, author_id, available_numbers) VALUES (:book_name, :section_id, :section_id,:available_numbers)
                    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':book_name', $bookName);
    $stmt->bindParam(':section_id', $sectionId);
    $stmt->bindParam(':author_id', $authorId);
    $stmt->bindParam(':available_numbers', $availableNumbers);
    $stmt->execute();
    return;
}
// add request
function addRequest($clientId, $bookId)
{
    $pdo = databaseConnection();
    $sql = "INSERT INTO requests (client_id, book_id) VALUES (:client_id, :book_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':client_id', $clientId);
    $stmt->bindParam(':book_id', $bookId);
    $stmt->execute();
    return true;
}

//read requests
function getRequest()
{
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
function getUserRequest($clientId)
{
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
    $stmt->bindParam(':client_id', $clientId);
    $stmt->execute();
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $requests;
}
//updating request status 
function updateRequestStatus($status, $requestId)
{
    $pdo = databaseConnection();
    $sql = "UPDATE requests SET status =:status WHERE request_id =:requestId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':requestId', $requestId);
    $stmt->execute();
    return true;
}
//adding lendings
function addLending($employeeId, $requestId)
{
    $pdo = databaseConnection();
    $sql = "INSERT INTO lendings (employee_id, request_id) VALUES (:employee_id, :request_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':employee_id', $employeeId);
    $stmt->bindParam(':request_id', $requestId);
    $stmt->execute();
    return true;
}
//removing lending
function removeLending($requestId)
{
    $pdo = databaseConnection();
    $sql = "DELETE FROM lendings WHERE request_id = :requestId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':requestId', $requestId);
    $stmt->execute();
    return true;
}
// getting book section name and id
function getSectionNames()
{
    $pdo = databaseConnection();
    $sql = "SELECT DISTINCT section_name, section_id FROM sections";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $bookSections = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $bookSections;
}
// server sent event connection
function serverSentEventConnection()
{
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');
}
// checking requests status
function getRequestsStatus()
{
    serverSentEventConnection();
    $pdo = databaseConnection();
}
