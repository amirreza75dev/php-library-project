<?php
$title = 'employee page';
include './header.php';
if(!isset($_SESSION['employeeId'])){
    header('Location: login.php');
    exit();
}
require_once './includes/functions.php';
$sectionNames = getSectionNames();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Employee Page</title>
</head>
<body>
<div class="main">
    <div class="requests">
        <table id="pending-requests">
        </table>
        <button id="approve-requests">Approve Requests</button>
    </div>
    <form class="add-books">
        <div> Adding new book</div>
        <label for="book-name">book name
            <input id="book-name" type="text">
        </label>
        <label for="section-id">section name </br>
            <select name="section" id="section-name">
                <?php
                 $html ="";
                 foreach($sectionNames as $section){
                    $html .= "<option value='". $section["section_id"]. "'>".$section['section_name']."</option>";
                } 
                 echo $html;
                ?>
            </select>
        </label>
        <label for="author-id">author id
            <input id="author-id" type="number">
        </label>
        <label for="avl">availabe
            <input id="avl" type="number">
        </label>
        <button id="submit-book">ADD Book</button>
    </form>
    <!-- searching clients by thier name or email and showing their books -->
    <form class="search-client">
        <div> Searching clients by name</div>
        <label for="search-client-label">Search</label>
        <input id="search-client-input" type="text" placeholder="type name or email of client">
        <button id="submit-search-client">Search</button>
        <div class="client-search-results"></div>
    </form>
    <div class="client-books">
        <table id="client-books-table">
        </table>
    </div>
    <div id="received-book-by-employee">
        <input id="received-book-input" type="text" placeholder="enter the request id">
        <button id="received-btn">receive book</button>
    </div>
</div>
<?php include './footer.php' ?>
<script>readRequests();</script>
