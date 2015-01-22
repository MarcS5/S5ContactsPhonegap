<?php
class helper
{
	public static function setMessage($type, $message, $location){
		$_SESSION[$type] = $message;
		if ($location != false){
			header("location:$location");
		}
	}
	
	public static function getMessages(){
		if (!$_POST['fc']){
			if (isset($_SESSION['error']))
			{
				echo '<div class="alert alert-danger">'.$_SESSION['confirm'].'</div>';
				unset($_SESSION['error']);
			}
			if (isset($_SESSION['success']))
			{
				echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
				unset($_SESSION['success']);
			}
		}
	}
	
	public function stringToURL($value) {
		$value = strtolower($value);
		$value = urlencode($value);
		//$value = str_replace('+', '-', $value);
		return $value;
	}
	
	public function urlToString($value){
		$value = strtolower($value);
		$value = urldecode($value);
		return $value;
	}
	
	public function parseRating($value){
		$floor = floor($value);
		$remainder = $value - $floor;
		$returnString = '';
		// <ul class="active"><li></li><li></li><li></li><li class="half"></li></ul>
		
		$returnString .= '<div class="stars"><ul class="default"><li></li><li></li><li></li><li></li><li></li></ul>';
		$returnString .= '<ul class="active">';
		for ($i = 0; $i < $floor; $i++){
			$returnString .= '<li></li>';
		}
		if ($remainder > 0){
			$returnString .= '<li class="half"></li>';
		}		
		$returnString .= '</ul></div>';
		return $returnString;
	}
	
	public function filterGet($value){
		return $value;
	}
	
	public static function uniqueFormValue(){
		$date = date('d-m-Y');
		return hash('crc32', $date);
	}
	
	public static function getMonths(){
		return array('Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December');
	}
}
?>