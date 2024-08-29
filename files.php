<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
$username = $_SESSION['username'];
$dir = isset($_GET['dir']) ? $_GET['dir'] : '';
$path = '/var/www/ex_cloud/cloud_share/' . $dir;

if (!is_dir($path)) {
    header('Location: index.php');
    exit;
}

$files = array_diff(scandir($path), array('..', '.'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>exCloud - Files</title>
    <link rel="stylesheet" href="styles_files.css">
</head>
<body>
<header>
    <img src="logotype.png" alt="Logo" class="logo">
    <div class="welcome">
        <img src="user.svg">
        <p>Добро пожаловать, <u><a href="logout.php"><?php echo htmlspecialchars($username); ?></a></u></p>
    </div>
    <div class="server-time">
        <p>Время до перезагрузки сервера: <span id="serverTime"></span></p>
    </div>
</header>
<main>
    <h1>Список файлов в директории:</h1>
    <table>
        <thead>
            <tr>
                <th>Наименование</th>
                <th>Дата создания</th>
                <th>Размер</th>
                <th>Описание</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($files as $file):
                $filePath = $path . '/' . $file;
                $fileSize = filesize($filePath) / 1024 / 1024; // размер в мегабайтах
                $creationDate = date("d.m.Y", filectime($filePath));
            ?>
                <tr class="file-row" data-file="<?php echo urlencode($dir . '/' . $file); ?>">
                    <td><img src="download.svg"><?php echo htmlspecialchars($file); ?></td>
                    <td><?php echo $creationDate; ?></td>
                    <td><?php echo round($fileSize, 2) . ' МБ'; ?></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php" class="button"><img src="backward.svg">Вернуться назад</a>
</main>
<footer>
    powered by centOS 7 & Apache. Developed by exJabberwocky.
</footer>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const restartTimeElement = document.getElementById('serverTime');
    setInterval(function () {
        const now = new Date();
        const nextRestart = new Date();
        nextRestart.setHours(Math.ceil(now.getHours() / 2) * 2, 0, 0, 0);
        const timeRemaining = nextRestart - now;
        const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
        restartTimeElement.textContent = `${hours}ч ${minutes}м ${seconds}с`;
    }, 1000);

    const rows = document.querySelectorAll('.file-row');
    rows.forEach(row => {
        row.addEventListener('click', function() {
            const file = this.dataset.file;
            window.location.href = 'download.php?file=' + file;
        });
    });
});
</script>
</body>
</html>
