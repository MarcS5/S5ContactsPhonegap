<?php
class validate
{
	// Clean up string
	public static function clean($string)
	{
		$dbQuery = db::query();
		if (self::notEmpty($string)){
			$string = self::stripHTML(mysqli_real_escape_string($dbQuery, trim($string)));
			return $string;
		}
	}
	
	// Check if string is email
	public static function isEmail($string)
	{
		if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		return false;
	}
	
	// Check minimum size of string
	public static function minSize($string, $size)
	{
		if (strlen($string) >= $size){
			return true;
		}
		return false;
	}
	
	// Check maximum size of string
	public static function maxSize($string, $size)
	{
		if (strlen($string) <= $size){
			return true;
		}
		return false;
	}
	
	// Strip HTML from string
	public static function stripHTML($string) 
	{
		return htmlentities($string);
	}
	
	// Check if string is not empty
	public static function notEmpty($string)
	{
		if ($string && $string!=''){
			return true;
		}
		return false;
	}
	
	public static function equals($value1, $value2)
	{
		if ($value1 === $value2){
			return true;
		}
		return false;
	}
	
	// Show error message
	public static function errorMsg($string){
		if(self::notEmpty($string) && $string!==true){
			return '<div class="error">'.$string.'</div>';
		}
	}
	
	// Validate entire Array
	public static function validateArray($validateArray, $formValue, $formValue2 = ''){
		$validateArray = explode(',',str_replace(' ', '', $validateArray));
			
		// Loop through all rules
		foreach($validateArray as $validateRule){
			switch($validateRule){
				// If value is required:
				case 'required':
					if(!self::notEmpty($formValue)){
						return 'Dit veld is verplicht';
					}
					break;
				// If minsize:
				case (strpos($validateRule,'minSize=') !== false):
					$sizeValue = str_replace('minSize=','',$validateRule);
					if (!self::minSize($formValue, $sizeValue)){
						return 'Minimaal aantal karakters: '. $sizeValue;
					}
					break;
				// If maxsize:
				case (strpos($validateRule,'maxSize=') !== false):
					$sizeValue = str_replace('maxSize=','',$validateRule);
					if (!self::maxSize($formValue, $sizeValue)){
						return 'Maximaal aantal karakters: '. $sizeValue;
					}
					break;
				// If email check:
				case ('email'):
					if (!self::isEmail($formValue)){
						return 'Het email adres is niet valide';
					}
					break;
				// If equals other value:
				case ('equals'):
					if (!self::equals($formValue, $formValue2)){
						return 'De waardes komen niet overeen';
					}
					break;
				// If ajax request: 
				case (strpos($validateRule,'ajax=') !== false):
					$ajaxRequest = str_replace('ajax=','',$validateRule);
						return self::ajaxReference($ajaxRequest, $formValue);
					break;
			}
			
		}
		return true;
	}
	
	// Manage references to Ajax requests
	public static function ajaxReference($reference, $value){
		$response = true;
		switch($reference){
			case 'ajaxCheckUsername':
				$checkValue = check_username($value);
				if (!$checkValue[1]){
					$response  = 'De gebruikersnaam is niet beschikbaar';
				}
				break;
			case 'ajaxCheckEmail':
				$checkValue = check_email($value);
				if (!$checkValue[1]){
					$response  = 'Dit email adres is al geregistreerd';
				}
				break;
		}
		return $response;
	}
}
?>