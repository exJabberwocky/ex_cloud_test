<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>exCloud</title>
    <link rel="stylesheet" href="styles.css">
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
        <h1>Список доступных директорий:</h1>
        <table>
            <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Владелец</th>
                    <th>Дата создания</th>
                    <th>Будет удален через</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $dir = '/var/www/ex_cloud/cloud_share';
                $directories = array_diff(scandir($dir), array('..', '.'));
                foreach ($directories as $directory) {
                    $path = $dir . '/' . $directory;
                    $creationDate = date("d.m.Y", filectime($path));
                    $deletionDate = date("d.m.Y", strtotime($creationDate . ' + 21 days'));
                    $daysRemaining = (strtotime($deletionDate) - strtotime(date("Y-m-d"))) / 86400;
                    echo "<tr class='directory-row' data-dir='files.php?dir=" . urlencode($directory) . "'>
                            <td><img src='folder.svg' alt='folder icon' class='folder-icon'>" . htmlspecialchars($directory) . "</td>
                            <td>ex_User</td>
                            <td>$creationDate</td>
                            <td>$daysRemaining дней</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
<section>
    <h2>Загрузить файл на сервер</h2>
    <form id="uploadForm" enctype="multipart/form-data" method="POST" action="upload.php">
        <label class="upload-button">
            <img src="upload.svg">Загрузить файлы
            <input type="file" id="fileInput" name="files[]" hidden multiple>
        </label>
        <div id="progressContainer"></div>
        <p id="uploadMessage"></p>
    </form>
</section>
    </main>
    <footer>
        powered by centOS 7 & Apache. Developed by exJabberwocky.
    </footer>
<script>
const fileInput = document.getElementById('fileInput');
const uploadMessage = document.getElementById('uploadMessage');
const progressContainer = document.getElementById('progressContainer');

fileInput.addEventListener('change', function () {
    const files = this.files;
    if (files.length > 0) {
        uploadMessage.textContent = ''; // Clear previous messages
        progressContainer.innerHTML = ''; // Clear previous progress bars

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const formData = new FormData();
            formData.append('file', file);

            // Create progress bar elements
            const progressWrapper = document.createElement('div');
            progressWrapper.classList.add('progress-wrapper');
            const progressBarContainer = document.createElement('div');
            progressBarContainer.classList.add('progress-bar-container');
            const progressBar = document.createElement('div');
            progressBar.classList.add('progress-bar');
            const progressLabel = document.createElement('span');
            progressLabel.textContent = file.name;

            progressBarContainer.appendChild(progressBar);
            progressWrapper.appendChild(progressLabel);
            progressWrapper.appendChild(progressBarContainer);
            progressContainer.appendChild(progressWrapper);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload.php', true);

            xhr.upload.addEventListener('progress', function (e) {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    progressBar.style.width = percentComplete + '%';
                    progressBar.textContent = Math.min(Math.round(percentComplete), 100) + '%';
                }
            });

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        progressBar.style.backgroundColor = '#24FF00';
                        progressBar.textContent = '100%';
                        setTimeout(() => {
                            progressWrapper.innerHTML = `<span class="success-message"><p>Файл <b>${file.name}</b> успешно загружен.</span>`;
                            setTimeout(() => {
                                progressWrapper.style.display = 'none';
                            }, 20000); // 20 seconds
                        }, 1000); // 1 second delay to ensure progress bar reaches 100%
                    } else {
                        progressBar.style.backgroundColor = '#CF2126';
                        progressBar.textContent = 'Ошибка при загрузке файла.';
                    }
                } else {
                    progressBar.style.backgroundColor = '#CF2126';
                    progressBar.textContent = 'Ошибка при загрузке файла.';
                }
            };

            xhr.onerror = function () {
                progressBar.style.backgroundColor = '#CF2126';
                progressBar.textContent = 'Ошибка при загрузке файла.';
            };

            xhr.send(formData);
        }
    }
});

function updateRebootTime() {
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();
    const remainingTime = (2 - (hours % 2)) * 3600 - minutes * 60 - seconds;
    const wh = Math.floor(remainingTime / 3600);
    const m = Math.floor((remainingTime % 3600) / 60);
    const s = remainingTime % 60;
    document.getElementById('serverTime').textContent = `${h}ч ${m}м ${s}с`;
}

setInterval(updateRebootTime, 1000);
updateRebootTime();

// Add click event listener for directory rows
document.querySelectorAll('.directory-row').forEach(row => {
    row.addEventListener('click', () => {
        window.location.href = row.dataset.dir;
    });
});
</script>
</body>
</html>
