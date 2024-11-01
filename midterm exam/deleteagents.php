<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 
if (!isset($_SESSION['agentID']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete agent</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Are you sure you want to delete this agent?</h1>
    
    <?php 
    if (isset($_GET['agentID'])) {
        $getAgentByID = getAgentByID($pdo, $_GET['agentID']); 
        
        if ($getAgentByID) {
            ?>
            <h2>Full Name: <?php echo ($getAgentByID['fullName']); ?></h2>
            <h2>Last Name: <?php echo ($getAgentByID['l_Number']); ?></h2>
            <h2>expired date: <?php echo ($getAgentByID['l_ExpiryDate']); ?></h2>
            <h2>specialization: <?php echo ($getAgentByID['specialization']); ?></h2>
            <h2>Contact: <?php echo ($getAgentByID['a_Contact']); ?></h2>
            <h2>Years of Experience: <?php echo ($getAgentByID['yearsOfExperience']); ?></h2>

            <form action="core/handleForms.php?agentID=<?php echo $_GET['agentID']; ?>" method="POST">
                <input type="submit" name="deleteAgentBtn" value="Delete">
            </form>
            <?php
        } else {
            echo "<h2>agent not found.</h2>";
        }
    } else {
        echo "<h2>No agent ID provided.</h2>";
    }
    ?>
</body>
</html>