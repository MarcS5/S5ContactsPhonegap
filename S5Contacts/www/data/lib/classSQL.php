<?php
class sql
{
	public static function execute($query, $multi=false){
		$dbQuery = db::query();
		if($query){
			if ($multi){
				$result = mysqli_multi_query($dbQuery, $query);
			} else {
				$result = mysqli_query($dbQuery, $query);
			}
			if ($result){
				return $result;
			} else {
				//echo $query;
				echo mysqli_error($dbQuery);
			}
		} else {
			return false;
		}		
	}
		
	public static function getView($query, $json = false){
		$rowResults  = array();
		$result = sql::execute($query);
		while($row = $result->fetch_assoc()){
			$rowResults[] = $row;
		}
		if ($json){
			return json_encode($rowResults);
		} else {
			return $rowResults;
		}
	}
	
	public function getResult($query) {
		$result = sql::execute($query);
		return $result->fetch_assoc();
	}
	
	public static function isTaken($query){
		$result = sql::execute($query);
		if ($result){
			if(mysqli_num_rows($result) > 0){
				return true;
			} else {
				return false;
			}
		}	
	}
	
	public static function error($error){
		echo $error;
	}
}

?>