<?php
include "dbFunctions.php";
session_start();

$movieId = "";
$fromIndividualMovieReview = false;

$userId = $_SESSION['userId'];
$comment = $_POST['comment'];
$rating = $_POST['ratingsInput'];
$datePosted = date("Y-m-d");

//initial query
$query = "SELECT movieId, movieTitle FROM movies";

// execute SQL query
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// process the result
while ($row = mysqli_fetch_assoc($result)) {
    $arrResult[] = $row;
}

//get movieId through for loop
for ($i = 1; $i <= count($arrResult) + 1; $i++) {
    $movieId = "reviewMovie" . $i;
    if (isset($_POST[$movieId])) {
        $movieId = $i;
        $fromIndividualMovieReview = true;
        break;
    }
}

if (!$fromIndividualMovieReview) {
    $movieId = $_POST['movieSelect'];
}

//build insert query
$query = "INSERT INTO reviews (movieId, userId, review, rating, datePosted)"
        . " VALUES($movieId, $userId, '$comment', $rating, '$datePosted')";

// execute SQL query
$result = mysqli_query($link, $query) or die(mysqli_error($link));

$datePosted = date("d/M/Y");

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
            <div class="mainAddReviewContainer">
                <div class="addReviewHeader">Review Added</div>
                <div class="confirmAddReviewContainer">
                    <div class="columnContainer">
                        <div class="boldText">Comments:</div>
                        <?php echo $comment; ?>
                    </div>
                    <div class="columnContainer">
                        <div class="boldText">Rating:</div>
                        <?php
                        $starRating = "&#9733";
                        $whiteStarRating = "&#9734;";

                        $emptyStars = 5 - $rating;

                        echo str_repeat($starRating, $rating) . str_repeat($whiteStarRating, $emptyStars);
                        ?>
                    </div>
                    <div class="columnContainer">
                        <div class="boldText">Date:</div>
                        <?php echo $datePosted; ?>
                    </div>
                </div>
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