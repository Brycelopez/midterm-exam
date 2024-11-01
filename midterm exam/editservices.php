<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; 
if (!isset($_SESSION['agentID']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit services</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="viewservices.php?servicesID=<?php echo $_GET['servicesID']; ?>">View the services</a>
    <h1>Edit the services!</h1>
    
    <?php 
    if (isset($_GET['servicesID'])) {
        $getServicesByID = getServicesByID($pdo, $_GET['servicesID']);
        
        if ($getServicesByID) { 
    ?>
        <form action="core/handleForms.php?servicesID=<?php echo $_GET['servicesID']; ?>&servicesID=<?php echo $_GET['servicesID']; ?>" method="POST">
            <p>
                <label for="service_offered"> Service</label>
                <input type="text" name="service_offered" value="<?php echo ($getServicesByID['service_offered']); ?>" required>
            </p>
            <p>
                <label for="property_management"> property management </label>
                <input type="text" name="property_management" value="<?php echo ($getServicesByID['property_management']); ?>" required>
            </p>
            <p>
                <label for="l_services"> legal services </label>
                <input type="text" name="l_services"  value="<?php echo ($getServicesByID['l_services']); ?>" required>
            </p>
            <p>
                <input type="submit" name="editServicesBtn" value="Update services">
            </p>
        </form>
    <?php 
        } else {
            echo "<p>services not found.</p>";
        }
    } else {
        echo "<p>No services ID provided.</p>";
    }
    ?>
    
    <p><a href="viewservices.php?servicesID=<?php echo $_GET['servicesID']; ?>">Return to services</a></p>
</body>
</html>