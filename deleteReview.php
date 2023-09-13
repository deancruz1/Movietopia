<?php
include "dbFunctions.php";
session_start();


//initial query
$query = "SELECT * FROM reviews";

// execute SQL query
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// process the result
while ($row = mysqli_fetch_assoc($result)) {
    $arrResult[] = $row;
}

//get reviewId through for loop
for ($i = 1; $i <= 999; $i++) {
    $reviewId = "review" . $i;
    if (isset($_POST[$reviewId])) {
        $reviewId = $i;
        break;
    }
}

// delete query
$query = "DELETE FROM reviews WHERE reviewId = $reviewId";

// execute SQL query
$result = mysqli_query($link, $query) or die(mysqli_error($link));

for ($i = 0; $i < count($arrResult); $i++) {
    $iterable = $arrResult[$i]['reviewId'];
    if ($iterable == $reviewId) {
        $movieId = $arrResult[$i]['movieId'];
    }
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
        <title>Review Added</title>
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
            <div class="mainDeleteReviewContainer">
                <div class="addReviewHeader">Review Deleted</div>
            </div>
            <form action="viewReviews.php" method="POST" class="viewMovieReviewForm">
                <div class="backContainer textBlack">
                    <button name="reviewMovie<?php echo $movieId; ?>" class="registerLink addReviewBtn textBlack" type="submit">Back</button>to Reviews List!
                </div>
            </form>
        </div>

        <div class="footer">
            <a href="https://deancruz1997.github.io/" class="footerText">C203 Graded Assignment - Dean Cruz</a>
        </div>
        <?php ?>
    </body>
</html>