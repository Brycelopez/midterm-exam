<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['agentID']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>

<html>
<head>
    <title>bryce real estate </title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <h2>Welcome <?php echo getAgentByID($pdo,$_SESSION['agentID'])['fullName']; ?> to your real estate profile !</h2>
    
    <input type="submit" value="Log out" onclick="window.location.href='core/logout.php'">
    <input type="submit" value="Agent logs" onclick="window.location.href='agentlogs.php'">
    
    <h3>Your Services!</h3>
    <table>
        <tr>
            <th>Service ID</th>
            <th>Service Offered</th>
            <th>Legal services</th>
            <th>Date Added</th>
            <th>Actions</th>
        </tr>

        <?php $getServicesByAgentID = getServicesByAgentID($pdo, $_SESSION['agentID']); ?>
        <?php foreach ($getServicesByAgentID as $row) { ?>
        <tr>
            <td><?php echo $row['servicesID']; ?></td>
            <td><?php echo htmlspecialchars($row['service_offered']); ?></td>
            <td><?php echo htmlspecialchars($row['property_management']); ?></td>
            <td><?php echo $row['date_added']; ?></td>
            <td>
                <?php
                $servicesID = $row['servicesID'];
                $agentID = $_SESSION['agentID'];
                ?>

                <input type="submit" value="Edit services" onclick="window.location.href='editservices.php?servicesID=<?php echo $servicesID; ?>&agentID=<?php echo $agentID; ?>';">
                <input type="submit" value="Remove services" onclick="window.location.href='deleteservices.php?servicesID=<?php echo $servicesID; ?>&agentID=<?php echo $agentID; ?>';">
            </td>
        </tr>
        <?php } ?>
    </table> <br>

    <input type="submit" value="Add Service" onclick="window.location.href='viewservices.php?agentID=<?php echo $_SESSION['agentID'];?>';">
    
    <br><br><br>
    <h3>Your Profile</h3>
        <table>
            <tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>License number</th>
                <th>License expiry</th>
                <th>specialization</th>
                <th>Agent contact</th>
                <th>Years of experience</th>
                <th>Services area</th>
                <th>Date Added</th>
            </tr>

            <?php $userData = getAgentByID($pdo, $_SESSION['agentID']); ?>
            <tr>
                <td><?php echo $userData['agentID']?></td>
                <td><?php echo $userData['fullName']?></td>
                <td><?php echo $userData['l_Number']?></td>
                <td><?php echo $userData['l_ExpiryDate']?></td>
                <td><?php echo $userData['specialization']?></td>
                <td><?php echo $userData['a_Contact']?></td>
                <td><?php echo $userData['yearsOfExperience']?></td>
                <td><?php echo $userData['serviceAreas']?></td>
                <td><?php echo $userData['date_added']?></td>
            </tr>
        </table>

    <input type="submit" value="Edit Profile" onclick="window.location.href='editagents.php?agentID=<?php echo $userData['agentID']; ?>';">
    <input type="submit" value="Delete Account" onclick="window.location.href='deleteagents.php?agentID=<?php echo $userData['agentID']; ?>';">
</body>
</html>
