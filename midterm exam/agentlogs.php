<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if(!isset($_SESSION['agentID']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>

<html>
    <head>
        <title>lopez real estate</title>
        <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <h2>Designer Logs</h2>

        <input type="submit" value="Return To Your Profile" onclick="window.location.href='index.php'">

        <table>
            <tr>
                <th>Log ID</th>
                <th>Action Done</th>
                <th>Services ID</th>
                <th>Agent ID</th>
                <th>Done By</th>
                <th>Date Logged</th>
            </tr>

            <?php $AgentLogs = getAgentLogs($pdo); ?>
            <?php foreach ($AgentLogs as $row) { ?>
            <tr>
                <td><?php echo $row['log_id']?></td>
                <td><?php echo $row['log_desc']?></td>
                <td><?php echo $row['servicesID']?></td>
                <td><?php echo $row['agentID']?></td>
                <td><?php echo $row['doneBy']?></td>
                <td><?php echo $row['date_logged']?></td>
            </tr>
            <?php } ?>
        </table>    
    </body>
</html>
