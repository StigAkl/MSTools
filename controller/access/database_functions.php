<?php
session_start(); 
include_once("db_connect.php");

/**
 * Adds a user to the database, parameters are selfdescribing
 * @param $username
 * @param $password
 * @param $email
 * @return string error message in case something goes wrong
 */
function addUser($username, $password, $email) {
	try {
		$db = Db::getInstance(); 
		$timestamp = date('Y-m-d G:i:s');
		$sql = "INSERT INTO users (username, password, email, reg_date)
		VALUES ('$username', '$password', '$email', '$timestamp')";
		$db->exec($sql);
	}

	catch(PDOException $e) {
		return $sql . "<br>" . $e->getMessage();
	}
}


/**
 * Function to get the total numbers of users or of a specific username (To check if the user exists already)
 * @param int $username The users username, -1 if we want the total amount of registered users
 * @return number of users
 */
function countUsers($username=-1) {
	$db = Db::getInstance(); 
	$countRows = -1;

	if($username ==-1) {
		try {
			$countRows = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
		}
		catch(PDOException $e) {
			return $e->getMessage();
		}
	} else {

		try {
			$countRows = $db->query("SELECT COUNT(*) FROM users WHERE username='$username'")->fetchColumn();
		} catch(PDOException $e) {
			return $e->getMessage(); 
		}
	}

	return $countRows; 
}

/**
 * Check if a user exists
 * @param $user username to the user
 * @return bool true if user exist, false if not
 */
function userExist($user) {
	$num = countUsers($user); 

	if($num <= 0) {
		return false; 
	} 
	return true; 
}

/**
 * Check if an email exist
 * @param $email
 * @return true if exist, false if not
 */
function emailExist($email) {
    $sql = "SELECT email FROM users WHERE email ='$email'";

    try {
        $db = Db::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();

    } catch(PDOException $e) {
        return $e->getMessage();
    }

    if($count >= 1)
        return true;
    else
        return false;
}

//Getting the user object from db
function getUser($username) {
	
	$sql = "SELECT * FROM users WHERE username='$username'";
	try {
		$db = Db::getInstance(); 
		$stmt = $db->prepare($sql);
        $stmt->execute();
        $user = $stmt->fetchObject(); 
        return $user;
	} catch(PDOException $e) {
		return $e->getMessage(); 
	}
}
?>