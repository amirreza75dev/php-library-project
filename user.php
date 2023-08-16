<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Welcome</title>
</head>
<body>
<div class="main">
        <div class="requests_user">
            <div class="search-book"><input type="text" placeholder="search book"></div>
            <div id="orders">
                <div>your orders</div>
                <div id="book-inf"></div>
                <button type="button" id="submit-orders">send requests</button>



            </div>
            <table id="data-container">




            </table>

            <div id="waiting-requests">
                <div>
                     <p>requests waiting for approval</p><span>status</span>
                </div>



            </div>




        </div>

<script src="js/jquery.js"></script>
<script src="js/user.js"></script>

</body>
</html>