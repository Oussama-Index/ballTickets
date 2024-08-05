<?php
(!isset($_COOKIE['user'])) ? session_start() : 0;
$connected = isset($_SESSION['user']) ? 1 : 0;



if ( $_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id_match']) && $connected){

    $id_match = $_GET['id_match'];

    // print_r($_SESSION['user']);
    require_once '../functions/database.php';
    $state = $pdo->prepare("SELECT * FROM Matches WHERE id = :id");
    $state->execute(['id' => $id_match]);
    $info = $state->fetch(PDO::FETCH_ASSOC);
    $match_text = $info['team_home'] . ' ' . $info['team_away'] . ' | ' . $info['date'] . ' | ' . $info['venue'];
    $nom_complet = $_SESSION['user']['nom'] . ' ' . $_SESSION['user']['prenom'];
    $email = $_SESSION['user']['email'];
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Ticket</title>
    <!-- fichier css -->
    <link rel="stylesheet" href="../css/componants.css">
    <link rel="stylesheet" href="../css/reservation_page.css">
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
            <h1>Get Ticket</h1>
            <a href="../index.html">Home</a>
        </div>
        <div>
            <div class="box">

                <h2>Get Ticket</h2>
                <form method="POST">
                    <div>
                        <input type="text" name="nom_complet" placeholder="FULL NAME" value="<?= $nom_complet ?>">
                        <input type="text" name="cin" placeholder="CIN">
                        <input type="text" name="telephone" placeholder="N TELEPHONE">
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="EMAIL" value="<?= $email ?>">
                        <input type="password" name="pass" placeholder="PASSWORD">
                    </div>
                    <div>
                        <input type="text" name="match" class="match" value="<?= $match_text ?>" readonly>
                        <div>
                            <label for="">Tickets Number</label>
                            <input type="number" name="quantity" value="1" min=0>
                        </div>
                    </div>
                    <div>
                    </div>
                    <div>
                        <input type="hidden" value="<?= $_SESSION['user']['id'] ?>" name="id_user">
                        <input type="hidden" value="<?= $id_match ?>" name="id_match">
                        <input type="submit" name="reserve_btn" value="Reserve">
                    </div>
                </form>

            </div>
        </div>

    </div>
</body>
</html>


<?php 
} 
else if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (!empty($_POST['id_match']) && !empty($_POST['id_user']) && !empty($_POST['quantity'])){
        $match_id = $_POST['id_match'];
        $user_id = $_POST['id_user'];
        $quantity = $_POST['quantity'];
        require_once '../functions/database.php';
        $state = $pdo->prepare('INSERT INTO Reservations (match_id, user_id, quantity) VALUES (:match_id, :user_id, :quantity)');
        $state->execute([
            ':match_id' => $match_id,
            ':user_id' => $user_id,
            ':quantity' => $quantity
        ]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Ticket</title>
    <!-- fichier css -->
    <link rel="stylesheet" href="../css/componants.css">
    <link rel="stylesheet" href="../css/reservation_page.css">
    <!-- les font utilise -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mali:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mali:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>
    <div class="success">
        <h1>Your Reservation Done Successfuly</h1>
        <a href="../index.html">see upcomming matches</a>
    </div>
</body>
<?php
    } else {
        echo 'fill the form information please';
    }
}
else {
    header(!$connected ? 'location: sign_in.php' : 'location: ../index.html');
}
