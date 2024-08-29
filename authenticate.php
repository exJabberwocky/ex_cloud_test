<?php
session_start();

$users = [
    'ex_odmen' => 'WHiZ79YyyyARRR',
    'bald&brother' => 'Iqup.Wy"S7',
];

$username = $_POST['username'];
$password = $_POST['password'];

if (isset($users[$username]) && $users[$username] === $password) {
    $_SESSION['username'] = $username;
    header('Location: index.php');
    exit;
} else {
    header('Location: login.php?error=invalid');
    exit;
}
?>

