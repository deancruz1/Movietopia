<?php
session_start();
include "dbFunctions.php";

$userId = $_SESSION['userId'];
$query = "SELECT * FROM users WHERE userId = $userId";

$result = mysqli_query($link, $query) or die(mysqli_error($link));

$row = mysqli_fetch_assoc($result);
$arrResult[] = $row;
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Account Information</title>
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
            <div class='accountContainer'>
                <div class='accountHeader'>Account Information</div>

                <div class='sectionMain'>
                    <div class='sectionContainer'>
                        <div class='labelText'>Username:</div>
                        <div class='inputText'> <?php echo $row['username'] ?></div>
                    </div>

                    <div class='sectionContainer'>
                        <div class='labelText'>Name:</div>
                        <div class='inputText'> <?php echo $row['name'] ?></div>
                    </div>

                    <div class='sectionContainer'>
                        <div class='labelText'>Date of Birth:</div>
                        <div class='inputText'> <?php echo $row['dob'] ?></div>
                    </div>

                    <div class='sectionContainer'>
                        <div class='labelText'>Email:</div>
                        <div class='inputText'> <?php echo $row['email'] ?></div>
                    </div>

                    <div class='buttons'>
                        <form method='POST' action='./editAccount.php'>
                            <input type='submit' value='Edit Account'>
                        </form>

                        <form method='POST' action='./deleteAccount.php'>
                            <input type='submit' value='Delete Account'>
                        </form>
                    </div>
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