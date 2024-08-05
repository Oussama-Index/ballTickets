<?php
function add_user_session($email, $pdo)
{
    // ADD USER SESSION
    $fetching = $pdo->prepare("SELECT * FROM Users WHERE email=:email");
    $fetching->execute([':email' => $email]);
    $userInfos = $fetching->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user'] = $userInfos;
}
?>