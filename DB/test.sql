drop database if exists library;
create database if not exists library;
CREATE TABLE sections(
    section_id INT(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    section_name VARCHAR(100) NOT NULL,
    active varchar(1) NOT NULL default 'Y'
);
CREATE TABLE authors(
    author_id int(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    author_name VARCHAR(100) NOT NULL
);
CREATE TABLE employees(
    employee_id int(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    employee_name VARCHAR(100) NOT NULL,
    email varchar(100) not null,
	password varchar(100) not null

);
CREATE TABLE books(
    book_id INT(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    book_name VARCHAR(100) NOT NULL,
    section_id INT(10) NOT NULL,
    author_id INT(10) NOT NULL,
    available_numbers INt(5) NOT NULL default 1,
    FOREIGN KEY (section_id) REFERENCES sections(section_id),
    FOREIGN KEY (author_id) REFERENCES authors(author_id)
    
);    
CREATE TABLE books_authors(
    book_author_id INT(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    author_id int(10) NOT NULL,
    book_id int(10) NOT NULL,
    FOREIGN KEY (author_id) REFERENCES authors(author_id),
    FOREIGN KEY (book_id) REFERENCES books(book_id)
);
CREATE TABLE clients(
    client_id int(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    client_name VARCHAR(100) NOT NULL,
    email varchar(100) not null,
	password varchar(100) not null
);
CREATE TABLE requests(
    request_id int(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    client_id int(10) NOT NULL,
    book_id int(10) NOT NULL,
    status varchar(50) NOT NULL DEFAULT 'pending',
    FOREIGN KEY (book_id) REFERENCES books(book_id),
    FOREIGN KEY (client_id) REFERENCES clients(client_id)
);

CREATE TABLE lendings(
    lending_id int(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    employee_id int(10) NOT NULL,
    request_id int(10) NOT NULL,
    start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_date TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL 3 WEEK),
    FOREIGN KEY (request_id) REFERENCES requests(request_id),
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id)
);
-- dummy data
-- Insert dummy data into the 'sections' table
INSERT INTO sections (section_name, active) VALUES
    ('Section 1', 'Y'),
    ('Section 2', 'Y'),
    ('Section 3', 'Y'),
    ('Section 4', 'Y'),
    ('Section 5', 'Y'),
    ('Section 6', 'Y'),
    ('Section 7', 'Y'),
    ('Section 8', 'Y'),
    ('Section 9', 'Y'),
    ('Section 10', 'Y'),
    ('Section 11', 'Y'),
    ('Section 12', 'Y'),
    ('Section 13', 'Y'),
    ('Section 14', 'Y'),
    ('Section 15', 'Y');
-- Insert dummy data into the 'authors' table
INSERT INTO authors (author_name) VALUES
    ('Author 1'),
    ('Author 2'),
    ('Author 3'),
    ('Author 4'),
    ('Author 5'),
    ('Author 6'),
    ('Author 7'),
    ('Author 8'),
    ('Author 9'),
    ('Author 10'),
    ('Author 11'),
    ('Author 12'),
    ('Author 13'),
    ('Author 14'),
    ('Author 15');
-- Insert dummy data into the 'employees' table
INSERT INTO employees (employee_name, email, password) VALUES
    ('Employee 1', 'employee1@example.com', 'password1'),
    ('Employee 2', 'employee2@example.com', 'password2'),
    ('Employee 3', 'employee3@example.com', 'password3'),
    ('Employee 4', 'employee4@example.com', 'password4'),
    ('Employee 5', 'employee5@example.com', 'password5'),
    ('Employee 6', 'employee6@example.com', 'password6'),
    ('Employee 7', 'employee7@example.com', 'password7'),
    ('Employee 8', 'employee8@example.com', 'password8'),
    ('Employee 9', 'employee9@example.com', 'password9'),
    ('Employee 10', 'employee10@example.com', 'password10'),
    ('Employee 11', 'employee11@example.com', 'password11'),
    ('Employee 12', 'employee12@example.com', 'password12'),
    ('Employee 13', 'employee13@example.com', 'password13'),
    ('Employee 14', 'employee14@example.com', 'password14'),
    ('Employee 15', 'employee15@example.com', 'password15');
-- Insert dummy data into the 'books' table
INSERT INTO books (book_name, section_id, author_id, available_numbers) VALUES
    ('Book 1', 1, 1, 5),
    ('Book 2', 2, 2, 3),
    ('Book 3', 3, 3, 7),
    ('Book 4', 4, 4, 2),
    ('Book 5', 5, 5, 6),
    ('Book 6', 6, 6, 4),
    ('Book 7', 7, 7, 8),
    ('Book 8', 8, 8, 1),
    ('Book 9', 9, 9, 5),
    ('Book 10', 10, 10, 3),
    ('Book 11', 11, 11, 7),
    ('Book 12', 12, 12, 2),
    ('Book 13', 13, 13, 6),
    ('Book 14', 14, 14, 4),
    ('Book 15', 15, 15, 8);

-- Insert dummy data into the 'books_authors' table
-- (You can link authors to books as needed)
-- Insert dummy data into the 'clients' table
INSERT INTO clients (client_name, email, password) VALUES
    ('Client 1', 'client1@example.com', 'password1'),
    ('Client 2', 'client2@example.com', 'password2'),
    ('Client 3', 'client3@example.com', 'password3'),
    ('Client 4', 'client4@example.com', 'password4'),
    ('Client 5', 'client5@example.com', 'password5'),
    ('Client 6', 'client6@example.com', 'password6'),
    ('Client 7', 'client7@example.com', 'password7'),
    ('Client 8', 'client8@example.com', 'password8'),
    ('Client 9', 'client9@example.com', 'password9'),
    ('Client 10', 'client10@example.com', 'password10'),
    ('Client 11', 'client11@example.com', 'password11'),
    ('Client 12', 'client12@example.com', 'password12'),
    ('Client 13', 'client13@example.com', 'password13'),
    ('Client 14', 'client14@example.com', 'password14'),
    ('Client 15', 'client15@example.com', 'password15');
-- Insert dummy data into the 'requests' table
-- (You can link clients to books as needed)
-- Insert dummy data into the 'lendings' table
-- (You can link employees to requests as needed)
-- Insert dummy data into the 'requests' table
INSERT INTO requests (client_id, book_id, status) VALUES
    (1, 1, 'pending'),
    (2, 2, 'approved'),
    (3, 3, 'pending'),
    (4, 4, 'approved'),
    (5, 5, 'pending'),
    (6, 6, 'approved'),
    (7, 7, 'pending');
-- Insert dummy data into the 'lendings' table
INSERT INTO lendings (employee_id, request_id, start_date, end_date) VALUES
    (1, 1, NOW(), DATE_ADD(NOW(), INTERVAL 3 WEEK)),
    (2, 2, NOW(), DATE_ADD(NOW(), INTERVAL 3 WEEK)),
    (3, 3, NOW(), DATE_ADD(NOW(), INTERVAL 3 WEEK)),
    (4, 4, NOW(), DATE_ADD(NOW(), INTERVAL 3 WEEK)),
    (5, 5, NOW(), DATE_ADD(NOW(), INTERVAL 3 WEEK)),
    (6, 6, NOW(), DATE_ADD(NOW(), INTERVAL 3 WEEK)),
    (7, 7, NOW(), DATE_ADD(NOW(), INTERVAL 3 WEEK));
    -- Insert dummy data into the 'books_authors' table
INSERT INTO books_authors (author_id, book_id)
VALUES
    (1, 1),   -- Author 1 linked to Book 1
    (2, 2),   -- Author 2 linked to Book 2
    (3, 3),   -- Author 3 linked to Book 3
    (4, 4),   -- Author 4 linked to Book 4
    (5, 5);   -- Author 5 linked to Book 5