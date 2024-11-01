<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<html>
<head>
    <title>lopez real estate </title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <h2>Welcome to Lopez real estate!</h2>

    <?php if (isset($_SESSION['message'])) { ?>
        <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
    <?php } unset($_SESSION['message']); ?>

    <form action="core/handleforms.php" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" required>

        <label for="password">Password</label>
        <input type="password" name="user_password" required> <br>

        <input type="submit" name="loginButton" value="Log in">
    </form>
    <input type="submit" name="registerButton" value="Register" onclick="window.location.href='register.php'">
</body>
</html>
