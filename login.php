<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация на сервере</title>
    <link rel="stylesheet" href="login_styles.css">
</head>
<body>
    <div class="container">
        <h2>Авторизация на сервере:</h2>
        <form action="authenticate.php" method="post">
            <input type="text" name="username" placeholder="Введите логин" required>
            <input type="password" name="password" placeholder="Введите пароль" required>
            <button type="submit">
                войти в exCloud
                <img src="logout.svg" alt="logout icon">
            </button>
        </form>
        <div class="error-message" id="errorMessage">Неверный логин или пароль</div>
    </div>
    <footer>
        powered by centOS 7 & Apache. Developed by exJabberwocky.
    </footer>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('error')) {
            document.getElementById('errorMessage').style.display = 'block';
        }
    </script>
</body>
</html>

