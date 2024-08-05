<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    !isset($_COOKIE['user']) ? session_start() : 0;

    require_once('database.php');
    
    $id = $_SESSION['user']['id'];
    
    $state = $pdo->prepare("SELECT Reservations.id, team_away, team_home, reservations.date, quantity 
                                    FROM Reservations, Matches  
                                    WHERE Reservations.match_id = Matches.id
                                    AND Reservations.user_id = :user_id
                                    ORDER BY reservations.date");
    $state->execute([':user_id' => $id]);
    $reservations = $state->fetchAll(PDO::FETCH_ASSOC);
    
    $json_data = json_encode($reservations, JSON_PRETTY_PRINT);
    
    file_put_contents('../json/reservations.json', $json_data);
}

?>