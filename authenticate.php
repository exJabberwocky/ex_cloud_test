<?php
session_start();

$users = [
    'ex_odmen' => '*****',
    'bald&brother' => '*****',
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

