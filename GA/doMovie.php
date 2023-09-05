<?php
include "dbFunctions.php";
session_start();

$movieId = "";

// build initial SQL query
$query = "SELECT * FROM movies";

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

// build 2nd SQL query with movieId to display
$movieQuery = "SELECT * FROM movies WHERE movieId = $movieId";

// execute SQL query
$movieResult = mysqli_query($link, $movieQuery) or die(mysqli_error($link));

// process the result
while ($row = mysqli_fetch_assoc($movieResult)) {
    $movieArrResult[] = $row;
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
        <title><?php echo $movieArrResult[0]['movieTitle'] ?></title>
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
            <div class="mainMovieContainer">
                <div class="moviesListHeader">Movie Information</div>
                <div class="mainDoMovieContainer">
                    <div class="movieContainerLeft">
                        <img src="./Images/<?php echo $movieArrResult[0]['picture'] ?>" alt="<?php echo $arrResult[0]['picture'] ?>" class="movieImg">
                    </div>
                    <div class="movieContainerRight">
                        <div class="movieTitle"><?php echo $movieArrResult[0]['movieTitle'] ?></div>
                        <div class="movieGenre2"><b>Genre:</b> <?php echo $movieArrResult[0]['movieGenre'] ?></div>
                        <div class="movieRunningTime"><b>Running Time:</b> <?php echo $movieArrResult[0]['runningTime'] ?></div>
                        <div class="movieLanguage"><b>Language:</b> <?php echo $movieArrResult[0]['language'] ?></div>
                        <div class="movieDirector"><b>Director:</b> <?php echo $movieArrResult[0]['director'] ?></div>
                        <div class="movieCasts"><b>Cast:</b> <?php echo $movieArrResult[0]['cast'] ?></div>
                        <div class="synopsisContainer">
                            <div class="synopsisHeader"><b>Synopsis:</b></div>
                            <div class="movieSynopsis"><?php echo $movieArrResult[0]['synopsis'] ?></div>
                        </div>
                        <form action="viewReviews.php" method="POST" class="viewMovieReview">
                            <button name="reviewMovie<?php echo $movieId; ?>" class="viewMovieReviewBtn" type="submit">View Reviews for <?php echo $movieArrResult[0]['movieTitle']; ?></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="movieText"><a href="./viewMovies.php" class="movieLink">Back</a> to movies list page!</div>
        </div>

        <div class="footer">
            <a href="https://deancruz1997.github.io/" class="footerText">C203 Graded Assignment - Dean Cruz</a>
        </div>
        <?php
        ?>
    </body>
</html>