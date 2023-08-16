<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Register page</title>
</head>
<body>


<form class="login-container">
    <input id="name" type="text" class="username" placeholder="enter name" required>
    <input id="email" type="email" class="username" placeholder="enter email" required>

    <div class="radio-btns">
        <label for="user-btn">User
            <input type="radio" id="user-btn" name="role" value="user" required>
        </label>
        
        <label for="employee-btn">employee
        <input type="radio" id="employee-btn" name="role" value="employee" required>
        </label>
    
    </div>
    <input id="pass" type="password" class="pwd" placeholder="enter password" onkeyup="checkPasswordStrength();">
    <input id="pass-check" type="password" class="pwd" placeholder="repeat password" onkeyup="checkPasswordRepeat();">
    <div id="pass-status" class="pass-warning-box">
        <p class="min-char">password should have at least 6 character</p>
        <p class="alpha-char">password should cointain alphabets</p>
        <p class="num-char">password should cointain numbers</p>
        <p class="special-char">password should cointain special characters</p>
        <p class="repeat-pass">password does not match</p>
    </div>
    <button id="log-btn" disabled>Registr</button>


</form>

<script src="js/jquery.js"></script>
<script src="js/register.js"></script>
</body>
</html>