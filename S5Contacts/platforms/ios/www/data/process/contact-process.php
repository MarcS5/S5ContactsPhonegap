<?php

$id = $firstName = $inBetween = $lastName = $phoneNumber = $email = $profilePicture = "";

if (isset($data["id"])){
	$id = $data["id"];
} 

if (isset($data["firstName"])){
	$firstName = $data["firstName"];
} else { throw new Exception("First name is missing"); }

if (isset($data["inBetween"])){
	$inBetween = $data["inBetween"];
} 

if (isset($data["lastName"])){
	$lastName = $data["lastName"];
} 

if (isset($data["phoneNumber"])){
	$phoneNumber = $data["phoneNumber"];
} 

if (isset($data["email"])){
	if (filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
		$email = $data["email"];
	} else { throw new Exception("Invalid email address"); return false; }
} 

if (isset($data["profilePicture"])){
	$profilePicture = $data["profilePicture"];
} 
	
if ($id){ 
	try {			
		$_dal->editContact($id, $firstName, $inBetween, $lastName, $phoneNumber, $email, $profilePicture);
		
		$response = array("status" => true, "message" => "Contact succesfully edited");
	} catch (Exception $e) {
		print_r($e);
		$response = array("status" => false, "message" => "Something went wrong. Please try again.");
	}
		
} else {
	try {
		$_dal->addContact($firstName, $inBetween, $lastName, $phoneNumber, $email, $profilePicture);
		
		$response = array("status" => true, "message" => "Contact succesfully added");		
	} catch (Exception $e) {
	
		$response = array("status" => false, "message" => "Something went wrong. Please try again.");
	}
}


?>