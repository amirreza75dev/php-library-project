<?php
$handle = fopen("c:/Users/amirreza/Desktop/books.csv","r");
$counter = 0;
$booksList = array();
$booksKeysValue = array('bookName','bookSection','bookAuthorId','bookCopies');
while(! feof($handle)) {
    $line = fgets($handle);
    $line = trim($line);
    if(!empty($line)){
    if($counter==0){
      // pass it
    }else{
      $bookInfo = explode(',', $line);  
      $bookDetails = array();
      for($i = 0; $i < count($bookInfo);$i++){
        $bookDetails[$booksKeysValue[$i]] = $bookInfo[$i];
      }
      array_push($booksList,$bookDetails);
    } 
    $counter +=1;
  }
  }
print_r($booksList);
fclose($handle);
?>