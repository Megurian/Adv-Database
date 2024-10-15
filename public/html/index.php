<?php
require_once '../../src/db_modules/database.php';
require_once '../../src/db_modules/user.class.php';
require_once '../../src/utils/functions.php';
$accountObj = new Account();

$email = $firstname = $lastname = $password = $confirm_password = '';
$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    $firstname = clean_input($_POST['firstname']);
    $lastname = clean_input($_POST['lastname']);
    $email = clean_input($_POST['email']);
    $password = clean_input($_POST['password']);
    $confirm_password = clean_input($_POST['confirm_password']);

    //Validation Email
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email is required';
    }

    //Validation First name
    if(empty($firstname)) {
        $errors['firstname'] = 'First name is required to signup';
    } elseif(is_numeric($firstname) || strlen($firstname) <= 1) {
        $errors['firstname'] = 'Enter a valid first name';
    }

    //Validation Last name
    if(empty($lastname)) {
        $errors['lastname'] = 'Surname is required to signup';
    } elseif(is_numeric($lastname) || strlen($lastname) <= 1) {
        $errors['lastname'] = 'Enter a valid surname';
    }

    //Validation Password
    if(empty($password)) {
        $errors['password'] = 'Password is required to signup';
    } elseif(strlen($password) < 8) {
        $errors['password'] = 'Enter atleast 8 characters password';
    } elseif(!preg_match('/[0-9]/', $password) || 
             !preg_match('/[A-Z]/', $password) || 
             !preg_match('/[a-z]/', $password) || 
             !preg_match('/[^a-zA-Z\d]/', $password)) {
        $errors['password'] = 'Password must contain at least 1 number, 1 uppercase, 1 lowercase, 1 special';
    } elseif(strpos($password, $firstname) !== false || 
             strpos($password, $lastname) !== false || 
             strpos($password, $email) !== false) {
        $errors['password'] = 'Weak password, please try a different password';
    } elseif(empty($confirm_password)) {
        $errors['confirm_password'] = 'Please confirm your password';
    } elseif($confirm_password != $password) {
        $errors['confirm_password'] = 'Password does not match!';
    }
    
    if(empty($errors)) {
        $encrytedPassword = password_hash($confirm_password, PASSWORD_ARGON2ID,['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 2]);    //this set the computational expense

        $accountObj->firstname = $firstname;
        $accountObj->lastname = $lastname;
        $accountObj->email = $email;
        $accountObj->password = $encrytedPassword;
            
        if($accountObj->userSignup()) {
            header('location: login.php');
        } else {
            echo '<script>alert("Something went wrong when signing up")</script>';
        }
     }
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
                <form action="" method="post" class="register-form" autocomplete="off">
                    <h2>Register</h2>
                    <p class="message">Signup now and start listing your antiques. </p>
                    <div class="flex">
                        <label>
                            <input class="input" type="text" name="firstname" placeholder="" value="<?= htmlspecialchars($firstname) ?>" required>
                            <span>Firstname</span>
                            <span><?= $errors['firstname'] ?? '' ?></span>
                        </label>
                
                        <label>
                            <input class="input" type="text" name="lastname" placeholder="" value="<?= htmlspecialchars($lastname) ?>" required>
                            <span>Lastname</span>
                            <span><?= $errors['lastname'] ?? '' ?></span>
                        </label>
                    </div>  
                            
                    <label>
                        <input class="input" type="email" name="email" placeholder="" value="<?= htmlspecialchars($email) ?>" required>
                        <span>Email</span>
                        <span><?= $errors['email'] ?? '' ?></span>
                    </label> 
                        
                    <label>
                        <input class="input" type="password" name="password" placeholder="" required>
                        <span>Password</span>
                        <span><?= $errors['password'] ?? '' ?></span>
                    </label>
                    <label>
                        <input class="input" type="password" name="confirm_password" placeholder="" required>
                        <span>Confirm password</span>
                        <span><?= $errors['confirm_password'] ?? '' ?></span>
                    </label>

                    <input type="submit" name="submit" value="Submit" class="submit">

                    <p class="signin">Already have an acount ? <a href="login.php">Log in</a> </p>
                </form>
            </div>
        </div>
        <div class="antique-list">
            
        </div>
    </div>
</body>
</html>