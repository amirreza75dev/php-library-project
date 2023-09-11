<?php
$title = 'login page';
include './header.php';
if (isset($_SESSION['clientId']) || isset($_SESSION['employeeId'])){
    // Redirect the user to another page, e.g., the homepage
    header('Location: logout.php'); // Change 'homepage.php' to the desired destination page
    exit();
}
?>
<div class="login-page-box">
    <form class="login-container">
        <input id="name" type="email" class="client-name" placeholder="enter email" required>
        <input id="pass" type="password" class="pwd" placeholder="enter password" required>
        <div class="radio-btns">
            <label for="client-btn">client
                <input type="radio" id="client-btn" name="role" value="client" required>
            </label>
            <label for="employee-btn">employee
                <input type="radio" id="employee-btn" name="role" value="employee" required>
            </label>
        </div>
        <div class="invalid">
            <p>invalid information...</p>
        </div>
        <button type="submit" id="log-btn">Log in</button>
    </form>
    <h3 class="register-prompt">if you do not have any account yet.. <a href="register.php">please register</a> </h3>
</div>
<?php include './footer.php' ?>