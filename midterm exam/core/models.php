<?php
function getAllUsers($pdo) {
    $query = "SELECT * FROM users";
    $statement = $pdo->prepare($query);
    $executeQuery = $statement->execute();
    
    if ($executeQuery) {
        return $statement->fetchAll();
    }
}

function getUserByID($pdo, $user_id) {
    $query = "SELECT * FROM users WHERE userID = ?";
    $statement = $pdo->prepare($query);
    $executeQuery = $statement->execute([$user_id]);
    
    if ($executeQuery) {
        return $statement->fetch();
    }
}
function addUser($pdo, $username, $user_password, $hashed_password, $fullName, $l_Number, $l_ExpiryDate, $specialization, $a_Contact, $yearsOfExperience, $serviceAreas) {
    if (checkUsernameExistence($pdo, $username)) {
        return "UsernameAlreadyExists";
    }
    if (!validatePassword($user_password)) {
        return "InvalidPassword";
    }

    $query1 = "INSERT INTO users (username, user_password) VALUES (?, ?)";
	$statement1 = $pdo -> prepare($query1);
	$executeQuery1 = $statement1 -> execute([$username, $hashed_password]);

    $query2 = "INSERT INTO agent_accounts (fullName, l_Number, l_ExpiryDate, specialization, a_Contact, yearsOfExperience, serviceAreas) VALUES (?, ?, ?, ?, ?, ?,?)";
    $statement2 = $pdo -> prepare($query2);
	$executeQuery2 = $statement2 -> execute([$fullName, $l_Number, $l_ExpiryDate, $specialization, $a_Contact , $yearsOfExperience, $serviceAreas]);
    
    if ($executeQuery1 && $executeQuery2) {
		return "registrationSuccess";	
	}
}


function loginUser ($pdo, $username, $user_password) {
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    if ($stmt->rowCount() == 1) {
        $userInfoRow = $stmt->fetch();
        $usernameFromDB = $userInfoRow['username'];
        $passwordFromDB = $userInfoRow['user_password'];

        if (password_verify($user_password, $passwordFromDB)) {
            $_SESSION['agentID'] = $userInfoRow['userID']; 
            $_SESSION['username'] = $usernameFromDB;
            $_SESSION['message'] = "Login successful!";
            return 'loginSuccess';
        } else {
            $_SESSION['message'] = "Password is incorrect!";
            return 'incorrectPassword';
        }
    } else {
        $_SESSION['message'] = "Username doesn't exist from the database. You may consider registration first.";
        return 'usernameDoesNotExist';
    }
}


function updateUser($pdo, $user_id, $fullName, $l_Number, $l_ExpiryDate, $specialization, $a_Contact, $yearsOfExperience, $serviceAreas) {
    $query = "UPDATE agent_accounts
                SET fullName = ?, l_Number = ?, l_ExpiryDate = ?, specialization = ?, 
                    a_Contact = ?, yearsOfExperience = ?, serviceAreas = ?
              WHERE agentID = ?";
    $statement = $pdo->prepare($query);
    $executeQuery = $statement->execute([$fullName, $l_Number, $l_ExpiryDate, $specialization, $a_Contact, $yearsOfExperience, $serviceAreas, $user_id]);
    
    return $executeQuery;
}

function removeUser($pdo, $user_id) {
    $query = "DELETE FROM users WHERE userID = ?";
    $statement = $pdo->prepare($query);
    $executeQuery = $statement->execute([$user_id]);
    
    return $executeQuery;
}


function addService($pdo, $service_offered, $property_management, $l_services, $agentID) {
    $query = "INSERT INTO services (service_offered, property_management, l_services, agentID) VALUES (?, ?, ?, ?)";
    $statement = $pdo->prepare($query);
    $executeQuery = $statement->execute([$service_offered, $property_management, $l_services, $agentID]);
    
    if($executeQuery) {
        $servicesID = getNewestServicesID($pdo)['ServiceID'];
        $serviceData = getServicesByID($pdo, $servicesID);
        logServicesAction($pdo, "ADDED", $serviceData['agentID'], $servicesID, $_SESSION['agentID']);
        return true;
    }

}

function getServicesByAgentID($pdo, $agentID) {
    $query = "SELECT * FROM services WHERE agentID = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$agentID]);
    
    return $statement->fetchAll();
}


function logServicesAction($pdo, $log_desc, $servicesID, $agentID, $doneBy) {
    $query = "INSERT INTO services_logs (log_desc, servicesID, agentID, doneBy) VALUES (?, ?, ?,?)";
    $statement = $pdo->prepare($query);
    $executeQuery = $statement->execute([$log_desc, $servicesID, $agentID, $doneBy]);
    
    return $executeQuery;
}

function getAgentLogs($pdo) {
    $query = "SELECT * FROM services_logs ORDER BY date_logged DESC";
    $statement = $pdo->prepare($query);
    $executeQuery = $statement->execute();
    
    if ($executeQuery) {
        return $statement->fetchAll();
    }
}
function insertAgent($pdo, $fullName, $l_Number, $l_ExpiryDate, $specialization, $a_Contact, $yearsOfExperience) {
    $sql = "INSERT INTO agent_accounts (fullName, l_Number, l_ExpiryDate, specialization, a_Contact, yearsOfExperience) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$fullName, $l_Number, $l_ExpiryDate, $specialization, $a_Contact, $yearsOfExperience]);
}

function updateAgent($pdo, $fullName, $l_Number, $l_ExpiryDate, $specialization, $a_Contact, $yearsOfExperience, $agentID) {
    $sql = "UPDATE agent_accounts SET fullName = ?, l_Number = ?, l_ExpiryDate = ?, specialization = ?, a_Contact = ?, yearsOfExperience = ? WHERE agentID = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$fullName, $l_Number, $l_ExpiryDate, $specialization, $a_Contact, $yearsOfExperience, $agentID]);
}

function deleteAgent($pdo, $agentID) {
    $sql = "DELETE FROM services WHERE agentID = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$agentID])) {
        $sql = "DELETE FROM agent_accounts WHERE agentID = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$agentID]);
    }
    return false;
}

function getAllAgents($pdo) {
    $sql = "SELECT * FROM agent_accounts";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getAgentByID($pdo, $agentID) {
    $sql = "SELECT * FROM agent_accounts WHERE agentID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$agentID]);
    return $stmt->fetch();
}


function getServicesByAgents($pdo, $agentID) {
    $sql = "SELECT services.servicesID, services.service_offered, services.property_management, services.l_services, services.date_added,
                   agent_accounts.fullName AS services_owner
            FROM services
            JOIN agent_accounts ON services.agentID = agent_accounts.agentID
            WHERE services.agentID = ?
            ORDER BY services.service_offered";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$agentID]);
    return $stmt->fetchAll();
}

function insertService($pdo, $service_offered, $property_management, $l_services, $agentID) {
    $sql = "INSERT INTO services (service_offered, property_management, l_services, agentID) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
   $executeQuery = $stmt->execute([$service_offered, $property_management, $l_services, $agentID]);

   if($executeQuery) {
    $servicesID = getNewestServicesID($pdo)['servicesID'];
    $servicesData = getServicesByID($pdo, $servicesID);
    logServicesAction($pdo, "ADDED", $servicesData['agentID'], $servicesID, $_SESSION['agentID']);
    return true;
}
}
function getServicesByID($pdo, $servicesID) {
    $sql = "SELECT services.servicesID, services.service_offered, services.property_management, services.l_services, services.date_added,
                   agent_accounts.agentID AS services_owner
            FROM services
            JOIN agent_accounts ON services.agentID = agent_accounts.agentID
            WHERE services.servicesID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$servicesID]);
    return $stmt->fetch();
}

function updateService($pdo, $service_offered, $property_management, $l_services, $servicesID) {
    $servicesData = getServicesByID($pdo, $servicesID);

    $sql = "UPDATE services SET service_offered = ?, property_management = ?, l_services = ? WHERE servicesID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$service_offered, $property_management, $l_services, $servicesID]);
    
    if($executeQuery) {
        logServicesAction($pdo, "UPDATE", $servicesData['agentID'], $servicesID, $_SESSION['agentID']);
        return true;
    } 

}

function deleteservices($pdo, $servicesID) {
    $servicesData = getServicesByID($pdo, $servicesID);

    $sql = "DELETE FROM services WHERE servicesID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$servicesID]);

    if($executeQuery) {
        logServicesAction($pdo, "REMOVED", $servicesData['agentID'], $servicesID, $_SESSION['agentID']);
        return true;
    } 
}
function checkUsernameExistence($pdo, $username) {
	$query = "SELECT * FROM users WHERE username = ?";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$username]);

	if($statement -> rowCount() > 0) {
		return true;
	}
}
function validatePassword($user_password) {
	if(strlen($user_password) >= 8) {
		$hasLower = false;
		$hasUpper = false;
		$hasNumber = false;

		for($i = 0; $i < strlen($user_password); $i++) {
			if(ctype_lower($user_password[$i])) {
				$hasLower = true;
			}
			if(ctype_upper($user_password[$i])) {
				$hasUpper = true;
			}
			if(ctype_digit($user_password[$i])) {
				$hasNumber = true;
			}

			if($hasLower && $hasUpper && $hasNumber) {
				return true;
			}
		}
	}
	return false;
}
function sanitizeInput($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}
function getNewestServicesID($pdo) {
	$query = "SELECT servicesID
			FROM services
			ORDER BY servicesID DESC
    		LIMIT 1;";
		$statement = $pdo -> prepare($query);
		$executeQuery = $statement -> execute();
		
		if ($executeQuery) {
			return $statement -> fetch();
		}
        function redirectWithMessage($location, $message) {
            $_SESSION['message'] = $message;
            header("Location: $location");
            exit();
        }
}

?>