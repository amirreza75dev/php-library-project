<?php 
$title = 'client page';
include './header.php';
if(!isset($_SESSION['clientId'])){
    header('Location: login.php');
    exit();
}
?>
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
    </div>
<?php include './footer.php' ?>
 <!-- page specific js  -->
<script>
books();
checkForUpdates();
</script>