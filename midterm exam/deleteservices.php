
<?php require_once 'core/dbConfig.php'; ?>
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
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php $getServicesByID = getServicesByID($pdo, $_GET['servicesID']); ?>
    <h1>Are you sure you want to delete this agent?</h1>

    <h2>services: <?php echo $getServicesByID['servicesID'] ?></h2>
    <h2>Property: <?php echo $getServicesByID['property_management'] ?></h2>
    <h2>l_services: <?php echo $getServicesByID['l_services'] ?></h2>
    <h2>Date Added: <?php echo $getServicesByID['date_added'] ?></h2>

    <form action="core/handleForms.php?servicesID=<?php echo $_GET['servicesID']; ?>" method="POST">
        <input type="submit" name="deleteServicesBtn" value="Delete">
    </form>
</body>
</html>
