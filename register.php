<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Register</title>
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
            <div class="registerContainer">
                <div class="registerHeader">Register</div>

                <form class="mainRegisterForm" method="POST" action="doRegister.php">
                    <div class="registerInputVert">

                        <fieldset class="fieldsetLeft">
                            <legend>Personal Details</legend>
                            <div class="registerInputLeft">
                                <div class="nameContainer">
                                    <label for="name" class="labelText">Full Name<span style="color:red"> * </span>:</label> 
                                    <input id="name" name="firstName" type="text" size="20" maxlength="100" required autofocus placeholder="Full name" class="inputText"/>
                                </div>
                                <div class="numberContainer">
                                    <label for="phonenum" class="labelText">Contact Number:</label> 
                                    <input type="tel" name="phonenum" id="phonenum" maxlength="8" pattern="[0-9]*" placeholder="98765432" class="inputText">
                                </div>
                                <div class="dobContainer">
                                    <label for="dob" class="labelText">Date of Birth<span style="color:red"> * </span>:</label>
                                    <input type="date" required id="dob" class="inputText" name="dob">
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="fieldsetRight">
                            <legend>User Details</legend>
                            <div class="registerInputRight">
                                <div class="usernameContainer">
                                    <label for="username" class="labelText">Username<span style="color:red"> * </span>:</label> 
                                    <input id="username" name="username" type="text" size="20" maxlength="100" required placeholder="Username" class="inputText"/>
                                </div>
                                <div class="emailContainer">
                                    <label for="email" class="labelText">Email<span style="color:red"> * </span>:</label>
                                    <input type="email" name="email" id="email" size="20" maxlength="100" required placeholder="john@gmail.com" class="inputText"/>
                                </div>

                                <div class="passwordContainer">
                                    <label for="password" class="labelText">Password<span style="color:red"> * </span>:</label>
                                    <input type="password" name="password" id="password" size="20" maxlength="100" required placeholder="Password" class="inputText"/>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="registerInputHorizontal">
                        <fieldset>
                            <legend class="legendBottom">Other Details</legend>
                            <div class="registerInputTop">
                                <div class="genderContainer">
                                    <label class="labelText">Gender:</label> 
                                    <input type="radio" name="gender" value="m" id="male"><label for="male">Male</label>
                                    <input type="radio" name="gender" value="f" id="female"><label for="female">Female</label>
                                    <input type="radio" name="gender" value="o" id="other"><label for="other">Prefer not to say</label>
                                </div>
                            </div>
                            <div class="registerInputMiddle">
                                <div class="addressContainer">
                                    <label for="address" class="labelText" id="addressText">Residential Address:</label>
                                    <textarea name="address" id="address" placeholder="Address" maxlength="200" cols="60" rows="5" class="textField"></textarea>
                                </div>
                            </div>
                        </fieldset>
                        <div class="registerInputBtm">
                            <input class="submitBtn" type="submit" value="Submit"/>
                            <input class="resetBtn" type="reset" value="Reset"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="loginText">Already a member? <a href="./login.php" class="loginLink">Login</a> now!</div>
        </div>

        <div class="footer">
            <a href="https://deancruz1997.github.io/" class="footerText">C203 Graded Assignment - Dean Cruz</a>
        </div>
        <?php
        ?>
    </body>
</html>
