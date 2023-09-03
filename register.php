<?php 
$title = 'register page';
include './header.php';
?>
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
        <input id="pass" type="password" class="pwd" placeholder="enter password">
        <input id="pass-check" type="password" class="pwd" placeholder="repeat password">
        <div id="pass-status" class="pass-warning-box">
            <p class="min-char">password should have at least 6 character</p>
            <p class="alpha-char">password should cointain alphabets</p>
            <p class="num-char">password should cointain numbers</p>
            <p class="special-char">password should cointain special characters</p>
            <p class="repeat-pass">password does not match</p>
        </div>
        <button id="register-btn" disabled>Registr</button>
    </form>
<?php include './footer.php' ?>