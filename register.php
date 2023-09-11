<?php 
$title = 'register page';
include './header.php';
if (isset($_SESSION['clientId']) || isset($_SESSION['employeeId'])){
    // Redirect the user to another page, e.g., the homepage
    header('Location: logout.php'); // Change 'homepage.php' to the desired destination page
    exit();
}
?>
    <form class="register-container">
        <input id="name" type="text" class="clientname" placeholder="enter name" required>
        <input id="email" type="email" class="clientname" placeholder="enter email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}" required>
        <div class="radio-btns">
            <label for="client-btn">client
                <input type="radio" id="client-btn" name="role" value="client" required>
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
        <button type="submit" id="register-btn" disabled>Registr</button>
    </form>
<?php include './footer.php' ?>