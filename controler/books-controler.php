<?php
include '../model/db-connection.php';
$book = new book($pdo);

$bookArray = $book->books();

$html ='               
<tr>
    <th>author</th>
    <th>book name</th>
    <th>request</th>
</tr>';

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

