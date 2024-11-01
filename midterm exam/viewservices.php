<?php 
require_once 'core/models.php'; 
require_once 'core/dbConfig.php'; 
if (!isset($_SESSION['agentID']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View services</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php">Return to Home Screen</a>
                <?php
                 $getServicesByAgent = getServicesByAgents($pdo, $_GET['agentID']); 
                ?>

                <h1>agentID:<?php echo $_GET['agentID']; ?></h1>
        

                <h1>Add New services</h1>
                <form action="core/handleForms.php?agentID=<?php echo $_GET['agentID']; ?>" method="POST">
                    <p>
                        <label for="service_offered">Services: </label>
                        <input type="text" name="service_offered"> 
                    </p>
                    <p>
                        <label for="property_management">Property management: </label>
                        <input type="text" name="property_management">
                    </p>
                    <p>
                        <label for="l_services">Legal services: </label>
                        <input type="text" name="l_services" >
                    </p>
                    <p>
                        <input type="submit" name="insertNewServicestBtn" value="Addservices">
                    </p>
                </form>

                <table style="width:100%; margin-top: 50px;">
                    <tr>
                        <th>Services ID</th>
                        <th>Service offered</th>
                        <th>Property management</th>
                        <th>legal services</th>
                        <th>Date Added</th>
                        <th>Action</th>
                    </tr>

                    <?php 
                        // Fetch services by agent ID
                        $getServicesByAgent = getServicesByAgents($pdo, $_GET['agentID']); 
                        foreach ($getServicesByAgent as $row) { 
                    ?>
                        <tr>
                            <td><?php echo ($row['servicesID']); ?></td>
                            <td><?php echo ($row['service_offered']); ?></td>
                            <td><?php echo ($row['property_management']); ?></td>
                            <td><?php echo ($row['l_services']); ?></td>
                            <td><?php echo ($row['date_added']); ?></td>
                            <td>
                                <a href="editservices.php?servicesID=<?php echo $row['servicesID']; ?>&agentID=<?php echo $_GET['agentID']; ?>">Edit</a>
                                <a href="deleteservices.php?servicesID=<?php echo $row['servicesID']; ?>&agentID=<?php echo $_GET['agentID']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
  
</body>
</html>