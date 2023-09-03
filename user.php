<?php 
$title = 'user page';
include './header.php';
?>
<div class="main">
    <div class="requests_user">
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
        </table>
        <div id="waiting-requests">
            <div>
                <p>requests</p><span>status</span>
            </div>
        </div>
    </div>
<?php include './footer.php' ?>
 <!-- page specific js  -->
<script>
books();
checkForUpdates();
</script>