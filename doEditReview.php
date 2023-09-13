<?php
include "dbFunctions.php";
session_start();

$reviewId = "";

//initial query
$query = "SELECT reviewId FROM reviews";

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

//query for adding reviews
$query = "SELECT R.movieId, R.reviewId, R.review, R.datePosted, R.userId, R.rating, U.username, M.movieTitle"
        . " FROM reviews R"
        . " INNER JOIN users U ON R.userId = U.userId"
        . " INNER JOIN movies M ON R.movieId = M.movieId"
        . " WHERE R.reviewId = $reviewId";

// execute SQL query
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// process the result
while ($row = mysqli_fetch_assoc($result)) {
    $reviewArray[] = $row;
}

$movieId = $reviewArray[0]['movieId'];
$addReviewHeader = $reviewArray[0]['movieTitle'];

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
        <title>Add Review</title>
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
            <div class="mainAddReviewContainer">
                <div class="addReviewHeader">Edit Review for</div>
                <div class="addReviewHeaderSubText"><?php echo $addReviewHeader; ?></div>

                <form method="POST" action="editReview.php" class="editFormContainer">

                    <div class="usernameReviewContainer addReviewContainer">
                        <div class="labelText">Username:</div>
                        <input type="text" value="<?php echo $reviewArray[0]['username'] ?>" readonly class="uneditable inputText"/>
                    </div>

                    <div class="commentConainer">
                        <div class="labelText"><label for="comment">Comment:<span style="color:red"> * </span></label></div>
                        <textarea name="editReviewText" id="comment" maxlength="200" cols="60" rows="5" class="textField" required autofocus><?php echo $reviewArray[0]['review'] ?></textarea>
                    </div>

                    <div class="ratingsContainer addReviewContainer">
                        <div class="labelText"><label for="rating">Rating:<span style="color:red"> * </span></label></div>
                        <input name="editReviewRating" type="number" id="rating" class="inputText" min="1" max="5" step="1" value="<?php echo $reviewArray[0]['rating'] ?>" required>
                    </div>

                    <div class="submitContainer center marginFix">
                        <input class="submitBtn" type="submit" value="Update Review" name="review<?php echo $reviewId ?>">
                    </div>

                </form>

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