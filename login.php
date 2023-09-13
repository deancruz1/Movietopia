<?php
$rememberUsername = "";

if (isset($_COOKIE['remember'])) {
    $rememberUsername = $_COOKIE['remember'];
} else {
    $rememberUsername = "";
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
        <title>Login</title>
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
                            <li><a href="./login.php">Register/Login</a>
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
            <div class="loginContainer">
                <div class="loginHeader">Login</div>
                <form class="mainLoginForm" method="POST" action="doLogin.php">
                    <div class="usernameContainer">
                        <label for="username" class="labelText">Username<span style="color:red"> * </span>:</label> 
                        <input id="username" name="username" type="text" size="20" maxlength="100" required placeholder="Username" class="inputText" autofocus value="<?php echo $rememberUsername; ?>"/>
                    </div>

                    <div class="passwordContainer">
                        <label for="password" class="labelText">Password<span style="color:red"> * </span>:</label>
                        <input type="password" name="password" id="password" size="70" maxlength="100" required placeholder="Password" class="inputText"/>
                    </div>
                    <div class="rememberMe inputText"><input type="checkbox" name="remember"> Remember Me</div>
                    <div class="forgotPasswordContainer"><a href="./forgotPassword.php" class="forgotPasswordLink">Forgot password?</a></div>
                    <div class="registerInputBtm">
                        <input class="submitBtn submitLoginBtn" type="submit" value="Login"/>
                    </div>
                </form>
            </div>
            <div class="registerText">Not a member yet? <a href="./register.php" class="registerLink">Register</a> now!</div>
        </div>

        <div class="footer">
            <a href="https://deancruz1997.github.io/" class="footerText">C203 Graded Assignment - Dean Cruz</a>
        </div>
        <?php
        ?>
    </body>
</html>