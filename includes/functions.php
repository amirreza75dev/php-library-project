<?php
function getDatabaseConnection()
{
    // database connection variables
    $envFilePath = __DIR__ . "/../.env";
    $dataBaseConVars = parse_ini_file($envFilePath);
    $servername = $dataBaseConVars['servername'];
    $dbname = $dataBaseConVars['dbname'];
    $username = $dataBaseConVars['username'];
    $password = $dataBaseConVars['password'];
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
// add employee
function addEmployee($name, $email, $pass)
{
    $pdo = getDatabaseConnection();
    $sql = "INSERT INTO employees (employee_name, email, password) VALUES (:name, :email, :pass)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $pass);
    return $stmt->execute();
}
// get employee
function getEmployee($email)
{
    $pdo = getDatabaseConnection();
    $sql = "SELECT * FROM employees WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    return $employee;
}
// add client
function addClient($name, $email, $pass)
{
    $pdo = getDatabaseConnection();
    $sql = "INSERT INTO clients (client_name, email, password) VALUES (:name, :email, :pass)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $pass);
    return $stmt->execute();
}
// get client
function getClient($email)
{
    $pdo = getDatabaseConnection();
    $sql = "SELECT * FROM clients WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    return $client;
}
// retriveing books
function getAllBooks()
{
    $pdo = getDatabaseConnection();
    $sql = "
                SELECT 
                    books.book_id,
                    books.book_name,
                    books.section_id,
                    books.author_id,
                    books.copies,
                    books.available_numbers,
                    authors.author_name
                FROM
                    books
                INNER JOIN
                    authors ON books.author_id = authors.author_id;
            ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $books;
}
// adding new book
function addBook($bookName, $sectionId, $authorId, $copies)
{
    $pdo = getDatabaseConnection();
    $sql = "
                    INSERT INTO books (book_name, section_id, author_id, copies) VALUES (:book_name, :section_id, :section_id,:copies)
                    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':book_name', $bookName);
    $stmt->bindParam(':section_id', $sectionId);
    $stmt->bindParam(':author_id', $authorId);
    $stmt->bindParam(':copies', $copies);
    return $stmt->execute();
}
// add request
function addBookRequest($clientId, $bookId, $startDate, $endDate)
{
    $pdo = getDatabaseConnection();
    $sql = "INSERT INTO requests (client_id, book_id, start_date, end_date) VALUES (:client_id, :book_id, :start_date, :end_date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':client_id', $clientId);
    $stmt->bindParam(':book_id', $bookId);
    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);
    return $stmt->execute();
}
//read requests
function getBookRequests()
{
    $pdo = getDatabaseConnection();
    $sql = "SELECT
                            r.request_id,
                            r.status,
                            c.client_id,
                            b.book_id,
                            c.client_name,
                            b.book_name,
                            b.copies
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
//read specific client requests
function getClientRequests($clientId)
{
    $pdo = getDatabaseConnection();
    $sql = "SELECT
                            r.request_id,
                            r.status,
                            r.start_date,
                            r.end_date,
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
    $pdo = getDatabaseConnection();
    $sql = "UPDATE requests SET status =:status WHERE request_id =:requestId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':requestId', $requestId);
    return $stmt->execute();
}
//adding lendings
function addLending($employeeId, $requestId)
{
    $pdo = getDatabaseConnection();
    $sql = "INSERT INTO lendings (employee_id, request_id) VALUES (:employee_id, :request_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':employee_id', $employeeId);
    $stmt->bindParam(':request_id', $requestId);
    return $stmt->execute();
}
//removing lending
function removeLending($requestId)
{
    $pdo = getDatabaseConnection();
    $sql = "DELETE FROM lendings WHERE request_id = :requestId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':requestId', $requestId);
    return $stmt->execute();
}
// getting book section name and id
function getSectionNames()
{
    $pdo = getDatabaseConnection();
    $sql = "SELECT DISTINCT section_name, section_id FROM sections";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $bookSections = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $bookSections;
}
// searching for th number of books available for lending
function bookAvailabilityUpdate($updateStatement, $bookId)
{
    $pdo = getDatabaseConnection();
    switch ($updateStatement):
        case 'increase':

            $sql = "UPDATE books
                    SET available_numbers = available_numbers + 1
                    WHERE book_id = :bookId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':bookId', $bookId);
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':bookId', $bookId);
            $stmt->execute();
            return 'hi';

            break;
        case 'decrease':
            $sql = "UPDATE books
                    SET available_numbers = available_numbers - 1
                    WHERE book_id = :bookId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':bookId', $bookId);
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':bookId', $bookId);
            return $stmt->execute();
            break;
    endswitch;
}
function clientBooks($clientName)
{
    $pdo = getDatabaseConnection();
    $sql = "SELECT
                b.book_name,
                r.status,
                r.start_date,
                r.end_date
            FROM
                lendings l
            JOIN
                requests r ON l.request_id = r.request_id
            JOIN
                books b ON r.book_id = b.book_id
            JOIN
                clients c ON r.client_id = c.client_id
            WHERE
                c.client_name = :clientName";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':clientName', $clientName);
    $stmt->execute();
    $clientBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $clientBooks;
}
// a function for checking the end_date of previous requests to update availability of books
function lendingsStatusUpdate($requestId)
{
    $pdo = getDatabaseConnection();
    // Check the current value of is_active
    $sqlCheck = "SELECT l.is_active , r.book_id , b.available_numbers
                 FROM lendings l
                 JOIN requests r ON l.request_id = r.request_id
                 JOIN books b ON b.book_id = r.book_id
                 WHERE l.request_id = :requestId";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':requestId', $requestId);
    $stmtCheck->execute();
    $results = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    $messages = array('activeStatusChanged' => '', 'reservationStatusChanged' => '', 'isRequestIdValid' => '');
    if (!empty($results)) {
        // Build and execute the update query
        if ($results['is_active'] == 'y') {
            $sql = "UPDATE lendings SET is_active = 'n' WHERE request_id = :requestId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':requestId', $requestId);
            $stmt->execute();
            // increasing available_numbers by 1
            bookAvailabilityUpdate('increase', $results['book_id']);
            $messages['activeStatusChanged'] = true;
        } else {
            $messages['activeStatusChanged'] = false;
            return $messages;
        }
        // checking the number of books available for current book_id then checking whether there is any reserved books in request table or not
        if ($results['available_numbers'] == 0) {
            $bookId = $results['book_id'];
            reservationStatusUpdate($bookId);
            $messages['reservationStatusChanged'] = true;
        }
        $messages['isRequestIdValid'] = true;
        return $messages;
    } else {
        $messages['isRequestIdValid'] = false;
        return $messages;
    }
}
function reservationStatusUpdate($bookId)
{
    $pdo = getDatabaseConnection();
    // Update the status of the oldest 'pending' reservation for the book
    $sqlUpdate = "UPDATE requests
                SET status = 'pending'
                WHERE book_id = :bookId AND status = 'reserved'
                ORDER BY created_at ASC
                LIMIT 1";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':bookId', $bookId);
    $stmtUpdate->execute();
    if ($stmtUpdate->rowCount() > 0) {
        // Update was successful
        echo "Reservation updated to 'pending' successfully!";
    } else {
        // No 'reserved' reservations found for the book
        echo "No 'reserved' reservations found for the book.";
        return false;
    }
}
// add reservation to request table
function addReservationRequest($clientId, $bookId, $status)
{
    $pdo = getDatabaseConnection();
    $sql = "INSERT INTO requests (client_id, book_id, status) VALUES (:client_id, :book_id, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':client_id', $clientId);
    $stmt->bindParam(':book_id', $bookId);
    $stmt->bindParam(':status', $status);
    return $stmt->execute();
}
// getting books with reserved status
function getReservedBooks($clientId)
{
    $pdo = getDatabaseConnection();
    $sql = "SELECT
                r.request_id,
                r.status,
                c.client_id,
                b.book_id,
                c.client_name,
                b.book_name
            FROM
                requests r
            JOIN
                clients c ON r.client_id = c.client_id
            JOIN
                books b ON r.book_id = b.book_id
            WHERE r.status = 'reserved' AND r.client_id = :clientId
                    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':clientId', $clientId);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } else {
        return array();
    }
}