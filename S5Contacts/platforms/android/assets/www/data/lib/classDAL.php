<?php
class dal {
	public static function getContacts($id = null){
		if ($id){
			return (new sql)->getView('SELECT * FROM contacts WHERE id = ' . $id, true);
		} else {
			return (new sql)->getView('SELECT * FROM contacts', true);
		}
	}
	
	public function addContact($firstName, $inBetween, $lastName, $phoneNumber, $email, $profilePicture){
		return (new sql)->execute("INSERT INTO contacts 
								(firstName, inBetween, lastName, phoneNumber, email, profilePicture)
								VALUES (\"$firstName\", \"$inBetween\", \"$lastName\", \"$phoneNumber\", \"$email\", \"$profilePicture\")");
	}
	
	public function editContact($id, $firstName, $inBetween, $lastName, $phoneNumber, $email, $profilePicture){	
		return (new sql)->execute("UPDATE contacts SET 
								firstName = \"$firstName\",  
								inBetween = \"$inBetween\",  
								lastName = \"$lastName\",  
								phoneNumber = \"$phoneNumber\",  
								email = \"$email\",
								profilePicture = \"$profilePicture\"
								WHERE id = $id");
	}
	
	public function contactExists($id){
		return (new sql)->isTaken('SELECT * FROM contacts WHERE id = ' . $id);
	}
	
	public function removeContact($id){
		return (new sql)->execute('DELETE FROM contacts WHERE id = ' . $id);
	}
}
?>