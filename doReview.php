<?php
include "dbFunctions.php";
session_start();

$movieId = "";
$addReviewHeader = "";

//initial query
$query = "SELECT movieId, movieTitle FROM movies";

// execute SQL query
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// process the result
while ($row = mysqli_fetch_assoc($result)) {
    $arrResult[] = $row;
}

//get movieId through for loop
for ($i = 1; $i <= count($arrResult); $i++) {
    $movieId = "movie" . $i;
    if (isset($_POST[$movieId])) {
        $movieId = $i;
        break;
    }
}

// if movieId is a still a string (ie it goes through the whole for loop and is now "movie5")
// that means that the "Add Review" button was not accessed from doMovie.php, and instead clicked from the header directly
// different block of code will execute in this case to let user add reviews to ALL movies instead of a specific one.
if (is_string($movieId)) {
    $showAllMovies = true;
    $addReviewHeader = "a movie";
    $textColor = "textWhite";
} else if (is_int($movieId)) {
    $showAllMovies = false;
    $textColor = "textBlack";

    $query = "SELECT movieTitle FROM movies WHERE movieId = $movieId";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    while ($row = mysqli_fetch_assoc($result)) {
        $movieArray[] = $row;
    }

    $addReviewHeader = $movieArray[0]['movieTitle'];
}

//query for adding reviews
$query = "SELECT userId, username FROM users";

// execute SQL query
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// process the result
while ($row = mysqli_fetch_assoc($result)) {
    $userArray[] = $row;
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
                <div class="addReviewHeader">Add new review for</div>
                <div class="addReviewHeaderSubText"><?php echo $addReviewHeader; ?></div>

                <form method="POST" action="addReview.php" class="addReviewForm">

                    <div class="usernameReviewContainer addReviewContainer">
                        <div class="labelText"><label for="userSelect">Username:</label></div>
                        <input type="text" value="<?php echo $_SESSION['username'] ?>" readonly class="uneditable inputText"/>

                    </div>

                    <!-- will only show if "Reviews" was accessed from the header, aka not adding review for a specific movie -->
                    <?php if ($showAllMovies) { ?>
                        <div class="movieReviewContainer addReviewContainer">
                            <div class="labelText"><label for="movieSelect">Movie:</label></div>
                            <select name="movieSelect" class="inputText" id="movieSelect">
                                <?php for ($i = 0; $i < count($arrResult); $i++) { ?>
                                    <option value="<?php echo $arrResult[$i]['movieId']; ?>"><?php echo $arrResult[$i]['movieTitle']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>

                    <div class="commentConainer">
                        <div class="labelText"><label for="comment">Comment:<span style="color:red"> * </span></label></div>
                        <textarea name="comment" id="comment" placeholder="Comment" maxlength="200" cols="60" rows="5" class="textField" required></textarea>
                    </div>

                    <div class="ratingsContainer addReviewContainer">
                        <div class="labelText"><label for="rating">Rating:<span style="color:red"> * </span></label></div>
                        <input name="ratingsInput" type="number" id="rating" class="inputText" min="1" max="5" step="1" placeholder="Input rating" required>
                    </div>

                    <div class="submitContainer addReviewContainer">
                        <input class="submitBtn" type="submit" value="Submit" name="reviewMovie<?php echo $movieId; ?>">
                    </div>

                </form>

            </div>
            <form action="viewReviews.php" method="POST" class="viewMovieReviewForm">
                <div class="backContainer <?php echo $textColor; ?>">
                    <button name="reviewMovie<?php echo $movieId; ?>" class="registerLink addReviewBtn <?php echo $textColor; ?>" type="submit">Back</button>to Reviews List!
                </div>
            </form>
        </div>

        <div class="footer">
            <a href="https://deancruz1997.github.io/" class="footerText">C203 Graded Assignment - Dean Cruz</a>
        </div>
        <?php ?>
    </body>
</html>