<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if (!empty($_POST['email']) && !empty($_POST['pass']))
    {
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        require_once "../functions/database.php";
        $state = $pdo->prepare("SELECT * FROM Users WHERE email = :email AND pass = :pass");
        $state->execute([':email' => $email, 'pass' => $pass]);
        if ($state->rowCount() == 1)
        {
            include "../functions/user_session.php";
            add_user_session($email, $pdo);
            header('location: ../index.html');
        }
        else {
            echo "the email or the password is invalid";
        }
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
   <!-- fichier css -->
   <link rel="stylesheet" href="../css/componants.css">
   <link rel="stylesheet" href="../css/sign_in.css">
   <link rel="stylesheet" href="../css/log_in.css">
   <!-- les font utilise -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Mali:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Mali:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>
    <div class="con">
        <div>
            <div class="box">
                
                <h2>Log In Today</h2>
                <form method="POST">
                    <div>
                        <input type="email" name="email" placeholder="EMAIL">
                    </div>
                    <div>
                        <input type="password" name="pass" placeholder="PASSWORD">
                    </div>
                    <div>
                        <input type="submit" value="Log in">
                    </div>
                    <p>You Don't Have an Account, Try to <a href="sign_in.php">Sign in</a></p>
                </form>

            </div>
        </div>
        <div class="title">
            <h1>Log In With BallTickets</h1>
            <a href="../index.html">Home</a>
        </div>

    </div>
</body>
</html>