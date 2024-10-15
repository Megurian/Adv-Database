<?php
require_once '../../src/db_modules/database.php';
require_once '../../src/db_modules/antique.class.php';
require_once '../../src/utils/functions.php';
$antiqueObj = new Antique();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="..\css\navigation.css"> 
    <link rel="stylesheet" href="..\css\root.css">
    <link rel="stylesheet" href="..\css\landing.css">
    <link rel="stylesheet" href="..\css\antique-list.css">
</head>
<body>
    <div class="container"> <!-- holds the entire structure or the wrapper -->
        <div class="header"> <!-- This div is for the header/navbar -->
            <div class="search">
                <form class="form" action="" method="post">
                    <button>
                        <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                            <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    <input class="input" placeholder="Search antiques..." required type="search">
                    <button class="reset" type="reset">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </form>
            </div>
            <div class="logo">
                <a href="">Heirloom Alcove</a>
            </div>
            <div class="nav">
                <a href="" class="text hideOnMobile">Antiques</a>
                <a href="" class="text hideOnMobile">Recently listed</a>
                <a href="" class="text hideOnMobile">About us</i></a>
                <a onclick=showSidebar() class="menu-icon"><i class='bx bx-menu'></i></a>
            </div>
        </div>
   
        <div class="banner">
            <div class="title-intro">
                <div class="title">
                    <h1>Welcome to Heirloom Alcove</h1>
                </div>
                <div class="introduction">
                    <p>The Beauty of Yesterday</p>
                </div>
            </div>

            <div>
                <form action="" method="" class="register-form" autocomplete="off">
                    <h2>Login</h2>
                    <p class="message">See the beauty of yesterday. </p>
                            
                    <label>
                        <input required="" placeholder="" type="email" class="input">
                        <span>Email</span>
                    </label> 
                        
                    <label>
                        <input required="" placeholder="" type="password" class="input">
                        <span>Password</span>
                    </label>
                    
                    <input type="submit" value="Login" class="submit">

                    <div class="login-actions">
                        <p class="forgotpassword"><a href="#">Forgot Password?</a></p>
                        <p class="signin">Don't have an acount ? <a href="index.php">Signup</a> </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>