drop database if exists library;
create database if not exists library;
CREATE TABLE sections(
    section_id INT(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    section_name VARCHAR(100) NOT NULL,
    is_active varchar(1) NOT NULL default 'Y'
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
    copies INt(5) NOT NULL default 1,
    available_numbers INt(5) NOT NULL default copies,
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
    start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_date TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL 3 WEEK),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES books(book_id),
    FOREIGN KEY (client_id) REFERENCES clients(client_id)
);
-- CREATE TABLE reserved_books (
--     reserved_book_id int(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
--     reservation_status varchar(10) NOT NULL default 'pending',
--     book_id int(10) NOT NULL,
--     client_id int(10) NOT NULL,
--     FOREIGN KEY (book_id) REFERENCES books(book_id),
--     FOREIGN KEY (client_id) REFERENCES clients(client_id)
-- );

CREATE TABLE lendings(
    lending_id int(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    is_active varchar(10) NOT NULL DEFAULT 'y',
    returned_date TIMESTAMP,
    employee_id int(10) NOT NULL,
    request_id int(10) NOT NULL,
    FOREIGN KEY (request_id) REFERENCES requests(request_id),
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id)
);
-- dummy data
-- Insert dummy data into the 'sections' table
-- Dummy data for sections table
INSERT INTO sections (section_name, is_active) VALUES
    ('Fiction', 'Y'),
    ('Science', 'Y'),
    ('History', 'Y'),
    ('Mystery', 'Y'),
    ('Biography', 'Y'),
    ('Romance', 'Y'),
    ('Thriller', 'Y'),
    ('Cooking', 'Y'),
    ('Self-Help', 'Y'),
    ('Travel', 'Y'),
    ('Science Fiction', 'Y'),
    ('Fantasy', 'Y'),
    ('Horror', 'Y'),
    ('Comedy', 'Y'),
    ('Drama', 'Y');

-- Dummy data for authors table
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

-- Dummy data for employees table
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

-- Dummy data for books table
INSERT INTO books (book_name, section_id, author_id, copies) VALUES
    ('Book 1', 1, 1, 5),
    ('Book 2', 2, 2, 3),
    ('Book 3', 1, 3, 2),
    ('Book 4', 3, 4, 4),
    ('Book 5', 4, 5, 6),
    ('Book 6', 2, 6, 3),
    ('Book 7', 5, 7, 2),
    ('Book 8', 3, 8, 1),
    ('Book 9', 6, 9, 5),
    ('Book 10', 4, 10, 3),
    ('Book 11', 7, 11, 2),
    ('Book 12', 2, 12, 2),
    ('Book 13', 1, 13, 2),
    ('Book 14', 8, 14, 2),
    ('Book 15', 8, 14, 0),
    ('Book 16', 8, 14, 0),
    ('Book 17', 8, 14, 1),
    ('Book 18', 8, 14, 1),
    ('Book 19', 5, 15, 1);

-- Dummy data for books_authors table
INSERT INTO books_authors (author_id, book_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (5, 5),
    (6, 6),
    (7, 7),
    (8, 8),
    (9, 9),
    (10, 10),
    (11, 11),
    (12, 12),
    (13, 13),
    (14, 14),
    (15, 15);

-- Dummy data for clients table
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



