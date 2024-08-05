<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['sign_in_btn']))
    {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        require_once "../functions/database.php";

        $state = $pdo->prepare("INSERT INTO Users(nom, prenom, email, pass) VALUES(:nom, :prenom, :email, :pass)");
        $state->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':pass' => $pass
        ]);

        include "../functions/user_session.php";
        add_user_session($email, $pdo);
        
        // REDIRECT
        header('location: ../index.html');
        exit;
        
    }
    else {
        echo "fill the form informations please";
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
        <div class="title">
            <h1>Sign in With BallTickets</h1>
            <a href="../index.html">Home</a>
        </div>
        <div>
            <div class="box">

                <h2>Sign In Today</h2>
                <form method="POST">
                    <div>
                        <input type="text" name="nom" placeholder="FIRST NAME">
                        <input type="text" name="prenom" placeholder="LAST NAME">
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="EMAIL">
                    </div>
                    <div>
                        <input type="password" name="pass" placeholder="PASSWORD">
                    </div>
                    <div>
                        <input type="submit" name="sign_in_btn" value="Sign in">
                    </div>
                    <p>Do You Have an Account, Try to <a href="log_in.php">Log in</a></p>
                </form>

            </div>
        </div>

    </div>
</body>
</html>

