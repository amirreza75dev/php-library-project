<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Login page</title>
</head>
<body>


<form class="login-container">
    <input id="name" type="email" class="username" placeholder="enter email" required>
    <input id="pass" type="password" class="pwd" placeholder="enter password" required>
    <div class="radio-btns">
        <label for="user-btn">User
            <input type="radio" id="user-btn" name="role" value="user" required>
        </label>
        
        <label for="employee-btn">employee
        <input type="radio" id="employee-btn" name="role" value="employee" required>
        </label>
    
    </div>
    <div class="invalid">
    <p>invalid information...</p>
    
    </div>
    <button id="log-btn">Log in</button>


</form>
<script src="js/jquery.js"></script>
<script src="js/login.js"></script>
</body>
</html>