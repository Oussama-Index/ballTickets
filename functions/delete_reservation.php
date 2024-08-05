<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (!empty($_POST['reservation_id'])){
        $reservation_id = $_POST['reservation_id'];
        require_once 'database.php';
        $state = $pdo->prepare('DELETE FROM Reservations WHERE id = :id');
        $state->execute([':id' => $reservation_id]);
        echo 1;
    }
}