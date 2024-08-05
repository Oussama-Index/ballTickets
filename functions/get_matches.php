<?php

require_once('database.php');

$matches = $pdo->query("SELECT * FROM Matches ORDER BY date")->fetchAll(PDO::FETCH_ASSOC);

$json_data = json_encode($matches, JSON_PRETTY_PRINT);

file_put_contents('../json/matches.json', $json_data);

?>