<?php
include "dbFunctions.php";
session_start();

$movieId = "";
$fromDoMovie = false;

//query to get movie title to be used in header, seperate query from getting reviews in case movie has 0 reviews, and thus cannot retrieve movie title
$query = "SELECT movieTitle FROM movies";

// execute SQL query
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// process the result
while ($row = mysqli_fetch_assoc($result)) {
    $arrResult[] = $row;
}

//get movieId through for loop
for ($i = 1; $i <= count($arrResult); $i++) {
    $movieId = "reviewMovie" . $i;
    if (isset($_POST[$movieId])) {
        $movieId = $i;
        $fromDoMovie = true;
        break;
    }
}

// change query and reviews header
if ($fromDoMovie) {
    $reviewsHeader = "Movie Reviews for " . $arrResult[$movieId - 1]['movieTitle'];
    $query = "SELECT R.reviewId, R.review, R.rating, U.username, M.movieTitle, R.datePosted, R.userId"
            . " FROM reviews R"
            . " INNER JOIN users U ON U.userId = R.userId"
            . " INNER JOIN movies M ON M.movieId = R.movieId"
            . " WHERE R.movieId = $movieId"
            . " ORDER BY 6";
} else {
    $reviewsHeader = "Movie Reviews for all movies";
    $query = "SELECT R.reviewId, R.review, R.rating, U.username, M.movieTitle, R.datePosted, R.userId"
            . " FROM reviews R"
            . " INNER JOIN users U ON U.userId = R.userId"
            . " INNER JOIN movies M ON M.movieId = R.movieId"
            . " ORDER BY 6";
}

// execute SQL query
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// process the result
while ($row = mysqli_fetch_assoc($result)) {
    $secondArrResult[] = $row;
}

$welcomeMessage = "";
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    $welcomeMessage = "Welcome, " . $_SESSION['name'];
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
        <title>Reviews</title>
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
            <div class="mainReviewContainer">
                <div class="reviewsHeader"><?php echo $reviewsHeader; ?></div>
                <?php if (isset($_POST['sortOrder'])) { ?>
                    <div class="sortText"><?php echo $sortMessage; ?></div>
                <?php } ?>
                <form method="POST" action="doReview.php">
                    <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) { ?>
                        <div class="center"><button class="registerLink addReviewBtn" name="movie<?php echo $movieId ?>">Add new Review</button></div>
                    <?php } ?>
                </form>

                <table class="reviewTable table table-striped">
                    <tr class="reviewRow">
                        <th class="reviewHeader noHeader">No.</th>
                        <th class="reviewHeader movieTitleHeader">Movie Title</th>
                        <th class="reviewHeader contentHeader">Review</th>
                        <th class="reviewHeader ratingHeader">Rating</th>
                        <th class="reviewHeader datePostedHeader">Date Posted</th>
                        <th class="reviewHeader usernameHeader">Username</th>
                        <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) { ?>
                            <th class="reviewHeader editHeader">Edit</th>
                            <th class="reviewHeader deleteHeader">Delete</th>
                        <?php } ?>
                    </tr>
                    <?php
                    if (isset($secondArrResult)) {
                        $ratings = [];
                        $starRating = "&#9733";
                        $whiteStarRating = "&#9734;";

                        for ($i = 0; $i < count($secondArrResult); $i++) {
                            $ratings[] = $secondArrResult[$i]['rating'];
                            $emptyStars = 5 - $ratings[$i];
                            ?>
                            <tr class="reviewRow">
                                <td class="startingCol"><?php echo $i + 1 . '.' ?></td>
                                <td class="middleCol"><?php echo $secondArrResult[$i]['movieTitle'] ?></td>
                                <td class="middleCol"><?php echo $secondArrResult[$i]['review'] ?></td>
                                <td class="middleCol"><?php echo str_repeat($starRating, $ratings[$i]) . str_repeat($whiteStarRating, $emptyStars); ?></td>
                                <td class="middleCol"><?php echo date("d/M/Y", strtotime(str_replace("-", "/", $secondArrResult[$i]['datePosted']))) ?></td>
                                <td class="middleCol"><?php echo $secondArrResult[$i]['username'] ?></td>

                                <!-- if statement to see who is logged in. will iterate on this when i find out how to actually login -->
                                <?php
                                if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
                                    if ($secondArrResult[$i]['userId'] == $_SESSION['userId']) {
                                        ?>
                                        <td class="middleCol">
                                            <form action="doEditReview.php" method="POST" class="editForm">
                                                <button name="review<?php echo $secondArrResult[$i]['reviewId']; ?>" class="registerLink addReviewBtn textBlack" type="submit">Edit</button>
                                            </form>
                                        </td>
                                        <td class="endCol">
                                            <form action="doDeleteReview.php" method="POST" class="deleteForm">
                                                <button name="review<?php echo $secondArrResult[$i]['reviewId']; ?>" class="registerLink addReviewBtn textBlack" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } else {
                                    ?>
                                    <td class="middleCol"></td>
                                    <td class="endCol"></td>
                                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </table>

            </div>
            <div class="registerText"><a href="./viewMovies.php" class="registerLink">Back</a> to movies list page!</div>
        </div>

        <div class="footer">
            <a href="https://deancruz1997.github.io/" class="footerText">C203 Graded Assignment - Dean Cruz</a>
        </div>
    </body>
</html>