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
                <th>request</th>
            </tr>
        </table>
        <div id="waiting-requests">
            <div>
                <p>requests</p><span>status</span>
            </div>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.library.js"></script>
    <script>books();
            checkForUpdates();
    </script>
</body>
</html>