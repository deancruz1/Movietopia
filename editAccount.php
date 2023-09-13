<?php
session_start();
include "dbFunctions.php";

$userId = $_SESSION['userId'];
$query = "SELECT * FROM users WHERE userId = $userId";

$result = mysqli_query($link, $query) or die(mysqli_error($link));

$row = mysqli_fetch_assoc($result);
$arrResult[] = $row;

$dob = $row['dob'];

function formatDateString($dateString) {
    $dateParts = explode('/', $dateString);
    $formattedDate = $dateParts[2] . '-' . getMonthNumber($dateParts[1]) . '-' . $dateParts[0];
    return $formattedDate;
}

function getMonthNumber($month) {
    $monthNames = array(
        'Jan' => '01',
        'Feb' => '02',
        'Mar' => '03',
        'Apr' => '04',
        'May' => '05',
        'Jun' => '06',
        'Jul' => '07',
        'Aug' => '08',
        'Sep' => '09',
        'Oct' => '10',
        'Nov' => '11',
        'Dec' => '12'
    );

    return $monthNames[$month];
}
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
                            <li><a href="./index.html">Movies</a>
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
                    <form class="searchBar" method="POST" action="index.html">
                        <input name="searchInput" type="text" size ="20" maxlength="100" placeholder="Search for movies" class="searchInput" required/>
                        <input class="searchBtn" type="submit" value="Search"/>
                    </form>
                </div>
            </div>
        </div>

        <div class="mainContent">
            <div class='accountContainer'>
                <div class='sectionMain'>
                    <form action='./doEditAccount.php' method='POST'>
                        <div class='accountHeader'>Edit Account</div>

                        <div class='sectionContainer'>
                            <div class='labelText'>Username:</div>
                            <input name='username' type='text' class='inputText' value='<?php echo $row['username'] ?>' autofocus required/>
                        </div><br/>

                        <div class='sectionContainer'>
                            <div class='labelText'>Name:</div>
                            <input name='name' type='text' class='inputText' value='<?php echo $row['name'] ?>' required/>
                        </div><br/>

                        <div class='sectionContainer'>
                            <div class='labelText'>Date of Birth:</div>
                            <input name='dob' type='date' value='<?php echo formatDateString($dob); ?>' required>
                        </div><br/>

                        <div class='sectionContainer'>
                            <div class='labelText'>Email:</div>
                            <input name='email' type='email' class='inputText' value='<?php echo $row['email'] ?>' required/>
                        </div><br/> 

                        <div class='buttons'>
                            <input type='submit' value='Confirm Changes'>
                        </div>
                    </form>
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