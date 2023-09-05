<?php
include "dbFunctions.php";
session_start();

$movieUsername = $_POST['username'];
$moviePassword = $_POST['password'];

$loginResult = "";
$loginMessage = "";
$loginLink = "";
$errorMessage = "";
$welcomeMessage = "";

// build SQL query
$query = "SELECT *"
        . " FROM users U"
        . " WHERE username = '$movieUsername'"
        . " AND password = '$moviePassword'";

// execute SQL query
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// process result
$row = mysqli_fetch_assoc($result);
$arrResult[] = $row;

if (!empty($row)) {
    $_SESSION['userId'] = $row['userId'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['isLoggedIn'] = true;

    $welcomeMessage = "Welcome, " . $row['name'];
    $loginResult = "Welcome";
    $loginMessage = "<b>Username:</b> " . $movieUsername . "<br/>"
            . "<b>Name:</b> " . $row['name'] . "<br/>"
            . "<b>Date of Birth:</b> " . $row['dob'] . "<br/>"
            . "<b>Email:</b> " . $row['email'] . "<br/><br/>";
    $loginLink = 'Proceed to view <a class="loginResultLink" href="/GA/viewMovies.php">Movies</a> list.';
} else {
    $loginResult = "Login failed";
    $errorMessage = "No matching record found!<br/>";
    $loginLink = '<a class="loginResultLink" href="/GA/login.php">Login</a> again.';
}

if (isset($_POST['remember'])) {
    $rememberMe = $_POST['remember'];
    setcookie("remember", $movieUsername, time() + 60 * 60 * 24 * 365 * 10);
} else {
    setcookie("remember", $movieUsername, time() - 3600, "/");
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
        <title>Login Result</title>
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
                            <li><a href="./viewMovies.php">Movies</a>
                            <li><a href="./viewReviews.php">Reviews</a>
                                <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) { ?>
                                <li><a href="./accountInformation.php">Account Information</a>    
                                <li><a href="./logout.php">Logout</a>
                                <?php } else { ?>
                                <li><a href="./login.php">Register/Login</a>
                                <?php } ?>
                        </ul>
                    </div>
                </nav>
                <div class="searchContainer">
                    <form class="searchBar" method="POST" action="viewMovies.php">
                        <input name="searchInput" type="text" size ="20" maxlength="100" placeholder="Search for movies" class="searchInput" required/>
                        <input class="searchBtn" type="submit" value="Search"/>
                    </form>
                </div>
            </div>
        </div>

        <div class="welcomeMessage"><?php echo $welcomeMessage ?></div>

        <div class="mainContent">
            <div class="loginResultContainer">
                <div class="loginHeader"><?php echo $loginResult; ?></div>
                <div class="loginResultContainerVert">
                    <div class="loginMessage"><?php echo $loginMessage; ?></div>
                    <div class="errorMessage"><?php echo $errorMessage; ?></div>
                    <div class="loginLinkMessage"><?php echo $loginLink; ?></div>
                </div>
            </div>
        </div>

        <div class="footer">
            <a href="https://deancruz1997.github.io/" class="footerText">C203 Graded Assignment - Dean Cruz</a>
        </div>
    </body>
</html>
