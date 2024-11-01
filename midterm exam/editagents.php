<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; 
if (!isset($_SESSION['agentID']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit agent</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
    $getAgentByID = getAgentByID($pdo, $_GET['agentID']);
    
    if (!$getAgentByID) {
        echo "<h2>agent not found!</h2>";
        exit;
    }
    ?>
    
    <h1>Edit the agent!</h1>
    <form action="core/handleForms.php?agentID=<?php echo $_GET['agentID']; ?>" method="POST">
        <p>
            <label for="fullName">First Name: </label>
            <input type="text" name="fullName" value="<?php echo $getAgentByID['fullName']; ?>" required>
        </p>
        <p>
            <label for="l_Number">lisence number: </label>
            <input type="text" name="l_Number" value="<?php echo $getAgentByID['l_Number']; ?>" required>
        </p>
        <p>
            <label for="l_ExpiryDate">Lisense expirydate: </label>
            <input type="text" name="l_ExpiryDate" value="<?php echo $getAgentByID['l_ExpiryDate']; ?>" required>
        </p>
        <p>
            <label for="specialization">specialization: </label>
            <input type="text" name="specialization" min="1" value="<?php echo $getAgentByID['specialization']; ?>" required>
        </p>
        <p>
            <label for="a_Contact">contact: </label>
            <input type="text" name="a_Contact" value="<?php echo $getAgentByID['a_Contact']; ?>" required>
        </p>
        <p>
            <label for="yearsOfExperience">yearsOfExperience: </label>
            <input type="text" name="yearsOfExperience" value="<?php echo $getAgentByID['yearsOfExperience']; ?>" required>
        </p>
        <p><input type="submit" name="editagentBtn" value="Update agent"></p>
    </form>
    
    <p><a href="index.php">Return to Home Screen</a></p>
</body>
</html>