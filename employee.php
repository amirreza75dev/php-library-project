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


    </div>


    <form class="add-books">
        <div> Adding new book</div>
        <label for="book-name">book name
            <input id="book-name" type="text">
        </label>
        <label for="section-id">section name </br>
            <select name="section" id="section_name">
                <option info="1" value="fiction">fiction</option>
                <option info="2" value="science">science</option>
                <option info="3" value="history">history</option>
                <option info="4" value="romance">romance</option>
                <option info="5" value="mystery">mystery</option>
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


</div>
<script src="js/jquery.js"></script>
<script src="js/jquery.library.js"></script>
</body>

</html>