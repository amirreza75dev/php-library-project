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
    FOREIGN KEY (client_id) REFERENCES clients(client_id),
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
-- Insert dummy data for 'sections' table
INSERT INTO sections (section_name, active)
VALUES
    ('Science', 'Y'),
    ('Fiction', 'Y'),
    ('History', 'Y');

-- Insert dummy data for 'authors' table
INSERT INTO authors (author_name)
VALUES
    ('J.K. Rowling'),
    ('George Orwell'),
    ('Stephen Hawking');

-- Insert dummy data for 'employees' table
INSERT INTO employees (employee_name, email, password)
VALUES
    ('John Doe', 'john@example.com', 'password123'),
    ('Jane Smith', 'jane@example.com', 'secret123');

-- Insert dummy data for 'books' table
INSERT INTO books (book_name, section_id, author_id, available_numbers)
VALUES
    ('Harry Potter and the Sorcerer''s Stone', 1, 1, 5),
    ('1984', 2, 2, 3),
    ('A Brief History of Time', 1, 3, 2);

-- Insert dummy data for 'books_authors' table
INSERT INTO books_authors (author_id, book_id)
VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Insert dummy data for 'clients' table
INSERT INTO clients (client_name, email, password)
VALUES
    ('Alice Johnson', 'alice@example.com', 'pass123'),
    ('Bob Smith', 'bob@example.com', 'bobpw'),
    ('Eve Wilson', 'eve@example.com', 'evepass');

-- Insert dummy data for 'requests' table
INSERT INTO requests (client_id, book_id, status)
VALUES
    (1, 1, 'pending'),
    (2, 2, 'approved'),
    (3, 3, 'pending');

-- Insert dummy data for 'lendings' table
INSERT INTO lendings (employee_id, request_id)
VALUES
    (1, 1),
    (2, 2),
    (1, 3);
