<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<html>
<head>
    <title>Lopez real estate</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <h2>Welcome to lopez real estate services gawa kana account!</h2>

    <?php if (isset($_SESSION['message'])) { ?>
        <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
    <?php } unset($_SESSION['message']); ?>

    <form action="core/handleForms.php" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" required>

        <label for="password">Password</label>
        <input type="password" name="user_password" required> 
        
        <label for="confirm_password">Confirm password</label>
        <input type="password" name="confirm_password" required> <br><br>

        <label for="fullName">Full Name</label>
        <input type="text" name="fullName" required>

        <label for="l_Number">License Number</label>
        <input type="text" name="l_Number" required> <br>

        <label for="l_ExpiryDate">License Expiry Date</label>
        <input type="date" name="l_ExpiryDate" required>

        <label for="specialization">Specialization</label>
        <input type="text" name="specialization">

        <label for="a_Contact">Contact</label>
        <input type="text" name="a_Contact"> <br>

        <label for="yearsOfExperience">Years of Experience</label>
        <input type="number" name="yearsOfExperience" min="0">

        <label for="serviceAreas">Service Areas</label>
        <textarea name="serviceAreas"></textarea> <br>

        <input type="submit" name="registerButton" value="Register account">
    </form>
    <input type="submit" name="returnButton" value="Return to login" onclick="window.location.href='login.php'">
</body>
</html>
