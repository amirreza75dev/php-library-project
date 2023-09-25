<?php 
$title = 'Client page';
require_once './header.php';

$isClientLoggedIn = isClientLoggedIn();

if(!$isClientLoggedIn){
    header('Location: index.php?referrer=client');
    exit();
}

$bookArray = getAllbooks();
$reservedBooks = getReservedBooks($_SESSION['clientId']);
?>
<button id="log-out-btn">Log Out</button>

<div class="main">
    <div class="requests_client">
        <div class="search-book">
            <input id='search' type="text" placeholder="search books">
        </div>
        <div id="orders">
            <div>your orders</div>
            <div id="book-inf"></div>
            <button type="button" id="submit-orders">send requests</button>
        </div>
        <table id="data-container">
            <tr>
                <th>author</th>
                <th>book name</th>
                <th>start date</th>
                <th>end date</th>
                <th>request</th>
            </tr>
            <?php 
                foreach ($bookArray as $book) {
                $bookName = $book['book_name'];
                $bookAuthor = $book['author_name'];
                $bookId = $book['book_id'];
                $bookAvailableNumbers= $book['available_numbers'];
                $trClass = ($bookAvailableNumbers < 1) ? 'not-available': '';
                ?>
                <tr info='<?php echo $bookId; ?>' class='<?php echo $trClass; ?>'>
                    <td><?php echo $bookAuthor; ?></td>
                    <td info='book-name'><?php echo $bookName; ?></td>
                    <td>
                        <input type='date' id='start' name='start-date' min='<?php echo date('Y-m-d', strtotime('+1 day')); ?>' value='<?php echo date('Y-m-d', strtotime('+1 day')); ?>'>
                    </td>
                    <td>
                        <input type='date' id='end' name='end-date' min='<?php echo date('Y-m-d', strtotime('+1 day')); ?>' value='<?php echo date('Y-m-d', strtotime('+3 weeks')); ?>'>                                 
                    </td>
                    <td>
                        <img class='book-req' src='./img/accept.png' alt='accept'>                                  
                    </td>                             
                </tr>
                <?php } ?>
        </table>
        <div id="waiting-requests">
            <div>your requests status</div>
            <table>
                <tr>                
                    <th>book name</th>
                    <th>start date</th>
                    <th>end date</th>
                    <th>status</th>
                </tr>
            </table>
        </div>
        <div class="reserved-books">
            <div style="text-align: center;">your reserved books</div>
            <table class="reserved-book-table">
                <tr>                
                    <th>book name</th>
                    <th>status</th>
                    <th>remove reservation</th>
                    <?php 
                    foreach ($reservedBooks as $book) {
                    $bookName = $book['book_name'];
                    $bookId = $book['book_id'];
                    $requestId = $book['request_id'];
                    ?>
                    <tr class="reserved-book-info" info="<?php echo $bookId ?>">
                        <td info='book-name'><?php echo $bookName; ?></td>
                        <td>reserved</td>
                        <td><button>click on me</button></td>                          
                    </tr>
                    <?php } ?>
                </tr>
            </table>
        </div>
    </div>
<?php include './footer.php' ?>
 <!-- page specific js  -->
<script>
checkForUpdates();
requestbook()
</script>