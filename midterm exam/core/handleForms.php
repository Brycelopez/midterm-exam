<?php 

require_once 'dbConfig.php'; 
require_once 'models.php';

if (isset($_POST['insertAgentBtn'])) {

	$query = insertAgent($pdo, $_POST['fullName'], $_POST['l_Number'], 
		$_POST['l_ExpiryDate'], $_POST['specialization'], $_POST['a_Contact'], $_POST['yearsOfExperience'], $_POST['serviceAreas']);

	if ($query) {
		header("Location: ../index.php");
	}
	else {
		echo "Insertion failed";
	}

}


if (isset($_POST['editagentBtn'])) {

	if (!empty($_POST['fullName']) && !empty($_POST['l_Number']) && !empty($_POST['l_ExpiryDate']) && !empty($_POST['specialization']) &&  !empty($_POST['a_Contact'])  && !empty($_POST['yearsOfExperience'])  && !empty($_GET['agentID']) ) {

		$query = updateAgent($pdo, $_POST['fullName'], $_POST['l_Number'], 
		$_POST['l_ExpiryDate'], $_POST['specialization'], $_POST['a_Contact'], $_POST['yearsOfExperience'], $_GET['agentID']);

		if ($query) {
			header("Location: ../index.php");
		}

		else {
			echo "Edit failed";
		}

	}

	else {
		echo "Make sure no input fields are empty before updating!";
	}



}

if (isset($_POST['deleteAgentBtn'])) {
	$query = deleteAgent($pdo, $_GET['agentID']);

	if ($query) {
		header("Location: ../index.php");
	}

	else {
		echo "Deletion failed";
	}
}

if (isset($_POST['insertNewServicestBtn'])) {
	$query = insertService($pdo, $_POST['service_offered'], $_POST['property_management'], $_GET['l_services'], $_GET['agentID']);

	if ($query) {
		header("Location: ../viewservices.php?agentID=".$_GET['agentID']);
	}
	else {
		echo "Insertion failed";
	}
}
if (isset($_POST['editServicesBtn'])) {
	$query = insertService($pdo, $_POST['service_offered'], $_POST['property_management'], $_GET['l_services'], $_GET['servicesID']);
	if ($query) {
		header("Location: ../viewservices.php?agentID=".$_GET['agentID']);
	}
	else {
		echo "Update failed";
	}

}
if (isset($_POST['deleteServicesBtn'])) {
	$query = deleteServices($pdo, $_GET['servicesID']);

	if ($query) {
		header("Location: ../viewservices.php?agentID=".$_GET['agentID']);
	}
	else {
		echo "Deletion failed";
	}
}
if (isset($_POST['registerButton'])) {
    $username = sanitizeInput($_POST['username']);
    $user_password = $_POST['user_password'];
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    $confirm_password = sanitizeInput($_POST['confirm_password']);
    
    
    $fullName = sanitizeInput($_POST['fullName']);
    $l_Number = sanitizeInput($_POST['l_Number']);
    $l_ExpiryDate = sanitizeInput($_POST['l_ExpiryDate']);
    $specialization = sanitizeInput($_POST['specialization']);
    $a_Contact = sanitizeInput($_POST['a_Contact']);
    $yearsOfExperience = (int)$_POST['yearsOfExperience'];
    $serviceAreas = sanitizeInput($_POST['serviceAreas']);


    $function = addUser($pdo, $username, $user_password, $hashed_password, $fullName, $l_Number, $l_ExpiryDate, $specialization, $a_Contact, $yearsOfExperience, $serviceAreas);
    
    if ($function == "registrationSuccess") {
        header("Location: ../login.php");
    } elseif ($function == "UsernameAlreadyExists") {
        $_SESSION['message'] = "Username already exists";
        header("Location: ../register.php");
    } elseif ($function == "InvalidPassword") {
        $_SESSION['message'] = "hina ng password mo dapat 8 letters tsaka may uppercase ano bayan.";
        header("Location: ../register.php");
    } else {
        echo "<h2>User addition failed.</h2>";
        echo '<a href="../register.php">';
        echo '<input type="submit" id="returnHomeButton" value="Return to register page" style="padding: 6px 8px; margin: 8px 2px;">';
        echo '</a>';
    }
   
}
if(isset($_POST['loginButton'])) {
    $username = sanitizeInput($_POST['username']);
    $user_password = $_POST['user_password'];

    $function = loginUser($pdo, $username, $user_password);
    if($function == "loginSuccess") {
        header("Location: ../index.php");
    } elseif($function == "usernameDoesntExist") {
        $_SESSION['message'] = "Username does not exist!";
        header("Location: ../login.php");
    } elseif($function == "incorrectPassword") {
        $_SESSION['message'] = "Password is incorrect!";
        header("Location: ../login.php");
    }
}

if (isset($_POST['editUserButton'])) {
    $fullName = sanitizeInput($_POST['fullName']);
    $l_Number = sanitizeInput($_POST['l_Number']);
    $l_ExpiryDate = sanitizeInput($_POST['l_ExpiryDate']);
    $specialization = sanitizeInput($_POST['specialization']);
    $a_Contact = sanitizeInput($_POST['a_Contact']);
    $yearsOfExperience = (int)$_POST['yearsOfExperience'];
    $serviceAreas = sanitizeInput($_POST['serviceAreas']);
    $agentID = $_GET['agentID']; // Use agentID for editing

    $function = updateUser($pdo, $fullName, $l_Number, $l_ExpiryDate, $specialization, $a_Contact, $yearsOfExperience, $serviceAreas, $agentID);
    if ($function) {
        header("Location: ../index.php");
    } else {
        echo "<h2>User editing failed.</h2>";
        echo '<a href="../index.php">';
        echo '<input type="submit" id="returnHomeButton" value="Return to home page" style="padding: 6px 8px; margin: 8px 2px;">';
        echo '</a>';
    }
}

if (isset($_POST['removeUserButton'])) {
    $agentID = $_GET['agentID']; 
    $function = removeUser($pdo, $agentID);
    if ($function) {
        header("Location: logout.php");
    } else {
        echo "<h2>User removal failed.</h2>";
        echo '<a href="../index.php">';
        echo '<input type="submit" id="returnHomeButton" value="Return to home page" style="padding: 6px 8px; margin: 8px 2px;">';
        echo '</a>';
    }
}
?>