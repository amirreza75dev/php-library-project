<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}



class employee{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;

    }

    public function registerEmployee($name,$email,$pass){
        try{
            $sql = "INSERT INTO employees (employee_name, email, password) VALUES (:name, :email, :pass)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass', $pass);
            $stmt->execute();
            return true;

        }catch(PDOException $e){

            echo "Connection failed: " . $e->getMessage();

        }

    }

    // login employee
    public function loginEmployee($email){
        try{
            $sql = "SELECT * FROM employees WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
            return $employee;

        }catch(PDOException $e){

            echo "Connection failed: " . $e->getMessage();

        }

    }





}





// user class

class user{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;

    }

    // register user
    public function registerUser($name,$email,$pass){
        try{
            $sql = "INSERT INTO clients (client_name, email, password) VALUES (:name, :email, :pass)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass', $pass);
            $stmt->execute();
            return true;

        }catch(PDOException $e){

            echo "Connection failed: " . $e->getMessage();

        }

    }

        // login employee
        public function loginUser($email){
            try{
                $sql = "SELECT * FROM clients WHERE email = :email";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                return $user;
    
            }catch(PDOException $e){
    
                echo "Connection failed: " . $e->getMessage();
    
            }
    
        }
    


}



// book class

class book{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;

    }

        // retriveing books
        public function books(){
            try{
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
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $books;
    
            }catch(PDOException $e){
    
                echo "Connection failed: " . $e->getMessage();
    
            }
    
        }

        // adding new book
                // retriveing books
                public function addBook($book_name,$section_id,$author_id,$available_numbers){
                    try{
                        $sql = "
                                    INSERT INTO books (book_name, section_id, author_id, available_numbers) VALUES (:book_name, :section_id, :section_id,:available_numbers)
                                 ";
                        $stmt = $this->pdo->prepare($sql);
                        $stmt->bindParam(':book_name', $book_name);
                        $stmt->bindParam(':section_id', $section_id);
                        $stmt->bindParam(':author_id', $author_id);
                        $stmt->bindParam(':available_numbers', $available_numbers);
                        $stmt->execute();
                        
                        return;
            
                    }catch(PDOException $e){
            
                        echo "Connection failed: " . $e->getMessage();
            
                    }
            
                }
    


}


// user class

class requests{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;

    }

    // add request
    public function addRequest($client_id,$book_id){
        try{
            $sql = "INSERT INTO requests (client_id, book_id) VALUES (:client_id, :book_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':client_id', $client_id);
            $stmt->bindParam(':book_id', $book_id);
            $stmt->execute();
            return true;

        }catch(PDOException $e){

            echo "Connection failed: " . $e->getMessage();

        }

    }

            // retriveing books
    public function readRequest(){
            try{
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
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $requests;
    
            }catch(PDOException $e){
    
                echo "Connection failed: " . $e->getMessage();
    
            }
    
        }


        //read specific user requests
        public function readUserRequest($client_id){
            try{
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
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':client_id', $client_id);
                $stmt->execute();
                $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $requests;
    
            }catch(PDOException $e){
    
                echo "Connection failed: " . $e->getMessage();
    
            }
    
        }


    

        public function updateRequestStatus($status,$requestId){
            try{
                $sql ="UPDATE requests SET status =:status WHERE request_id =:requestId";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':requestId', $requestId);
                $stmt->execute();
                return true;


            }catch(PDOException $e){
    
                echo "Connection failed: " . $e->getMessage();
    
            }


        }


}



// lendings class

// book class

class lending{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;

    }

        // adding lending
        public function addLending($clientId,$employeeId,$bookId,$requestId){

            try{
                $sql = "INSERT INTO lendings (client_id, employee_id, book_id, request_id) VALUES (:clientId, :employeeId,:bookId,:requestId)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':clientId', $clientId);
                $stmt->bindParam(':employeeId', $employeeId);
                $stmt->bindParam(':bookId', $bookId);
                $stmt->bindParam(':requestId', $requestId);
                $stmt->execute();
                return true;
    
            }catch(PDOException $e){
    
                echo "Connection failed: " . $e->getMessage();
    
            }

    
        }
        //removing lending
        public function removeLending($requestId){

            try{
                $sql = "DELETE FROM lendings WHERE request_id = :requestId";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':requestId', $requestId);
                $stmt->execute();
                return true;
    
            }catch(PDOException $e){
    
                echo "Connection failed: " . $e->getMessage();
    
            }

    
        }
    


}