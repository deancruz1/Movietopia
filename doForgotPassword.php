<?php
include "dbFunctions.php";
session_start();

$userEmail = $_POST['email'];

// build SQL query
$query = "SELECT * FROM users WHERE email LIKE '$userEmail'";

// execute SQL query
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// process the result
while ($row = mysqli_fetch_assoc($result)) {
    $arrResult[] = $row;
}

$password = $arrResult[0]['password'];

$mailSent = mail($userEmail, "Movietopia - Forgotten Password", "Your password is '$password'. Please use it to login.");

if (!empty($arrResult[0]['email']) && $mailSent) {
    //send email
    $message = "Information on your password has been sent to " . $userEmail;
} else {
    $message = "Error. No such email in database.";
}

// close connection
mysqli_close($link);
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Forgot Password</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./stylesheet/styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <div class="header">
            <div class="headerContainer">
                <nav class="navbar-expand-sm navbar-dark">
                    <div class="container-fluid">
                        <ul class="headerList">
                            <li><a href="./index.html">Movies</a>
                            <li><a href="./viewReviews.php">Reviews</a>
                            <li><a href="./login.php">Register/Login</a>
                        </ul>
                    </div>
                </nav>
                <div class="searchContainer">
                    <form class="searchBar" method="POST" action="index.html">
                        <input name="searchInput" type="text" size ="20" maxlength="100" placeholder="Search for movies" class="searchInput" required/>
                        <input class="searchBtn" type="submit" value="Search"/>
                    </form>
                </div>
            </div>
        </div>

        <div class="mainContent">
            <div class="loginContainer">
                <div class="loginHeader">Forgot Password?</div>
                <div class="usernameContainer">
                    <div><?php echo $message; ?></div>
                </div>
                <div class="registerText center">Back  to <a href="./login.php" class="registerLink">Login</a></div>
            </div>
        </div>


        <div class="footer">
            <a href="https://deancruz1997.github.io/" class="footerText">C203 Graded Assignment - Dean Cruz</a>
        </div>
        <?php
        ?>
    </body>
</html>