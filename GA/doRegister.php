<?php
include "dbFunctions.php";

$registerName = $_POST['firstName'];

// Change dob to format as same in SQL
$inputDate = $_POST['dob'];
$convertedDate = str_replace("-", "/", $inputDate);
$registerDob = date("d/M/Y", strtotime($convertedDate));

$registerUsername = $_POST['username'];
$registerEmail = $_POST['email'];
$registerPassword = $_POST['password'];

$registerContactNo = NULL;
$registerGender = NULL;
$registerAddress = NULL;

// build SQL query
$query = "INSERT INTO users (username, password, name, dob, email)"
        . " VALUES ('$registerUsername', '$registerPassword', '$registerName', '$registerDob',"
        . " '$registerEmail')";

// execute SQL query
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// if optional fields are filled, insert into latest row 
if ($_POST['phonenum'] != "") {
    $registerContactNo = $_POST['phonenum'];

    $query = "UPDATE users"
            . " SET contactnumber = '$registerContactNo'"
            . " ORDER BY userId DESC limit 1";

    $result = mysqli_query($link, $query) or die(mysqli_error($link));
}

if (isset($_POST['gender'])) {
    $registerGender = $_POST['gender'];

    $query = "UPDATE users"
            . " SET gender = '$registerGender'"
            . " ORDER BY userId DESC limit 1";

    $result = mysqli_query($link, $query) or die(mysqli_error($link));
}

if ($_POST['address'] != "") {
    $registerAddress = $_POST['address'];

    $query = "UPDATE users"
            . " SET address = '$registerAddress'"
            . " ORDER BY userId DESC limit 1";

    $result = mysqli_query($link, $query) or die(mysqli_error($link));
}

$registerMessage = "<b>Username:</b> " . $registerUsername . "<br/>"
        . "<b>Name:</b> " . $registerName . "<br/>"
        . "<b>Date of Birth:</b> " . $registerDob . "<br/>"
        . "<b>Email:</b> " . $registerEmail . "<br/><br/>";

$loginLink = 'Proceed to view <a class="loginResultLink" href="/GA/login.php">Login</a>.';

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
        <title>Movietopia || Registration Successful</title>
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

        <div class="mainContent">
            <div class="registerResultContainer">
                <div class="registerHeader">Registration Successful</div>
                <div class="registerResultContainerVert">
                    <div class="registerMessage"><?php echo $registerMessage ?></div>
                    <div class="registerLinkMessage"><?php echo $loginLink; ?></div>
                </div>
            </div>
        </div>

        <div class="footer">
            <a href="https://deancruz1997.github.io/" class="footerText">C203 Graded Assignment - Dean Cruz</a>
        </div>
        <?php
        ?>
    </body>
</html>
