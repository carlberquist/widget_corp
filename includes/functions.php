<?php  
//store all basic functions here.
function do_query($query){
	global $connection;
	if ($result = mysqli_query($connection, $query)) {
		return $result;
	} else{
		echo ("Query not complete" . mysqli_error($connection));
		exit;
	}
}
function get_all_subjects(){
	$query = "SELECT id, menu_name FROM subjects ORDER BY position ASC";
	$result = do_query($query);
	return $result;
}
function get_all_pages_for_subjects($subject_id){
	$query = "SELECT id, menu_name FROM pages WHERE subject_id = {$subject_id} ORDER BY position ASC";
	$result = do_query($query);
	return($result);
}
function get_subject_by_id(){
	if (array_key_exists('subj', $_GET)){
		$subject_id = $_GET['subj'];
		$query = "SELECT menu_name FROM subjects WHERE id= {$subject_id} LIMIT 1";
		$result_set = do_query($query);
		if ($subject = mysqli_fetch_array($result_set)){
			return $subject;
		}
		else{
			return "No subject found";
		}
	}
}
function get_page_by_id(){
	if (array_key_exists('page', $_GET)){
		$page_id = $_GET['page'];
		$query = "SELECT menu_name, content FROM pages WHERE id = {$page_id} LIMIT 1";
		$result_set = do_query($query);
		if ($subject = mysqli_fetch_array($result_set)){
			return $subject;
		}
		else{
			return "No page found";
		}
	}
}
function array_exists($array = NULL, $key, $defaultValue){
	if (!is_null($array) && array_key_exists($key, $array)){
		$value = $array[$key];
		return isset($value) ? $value : $defaultValue;
	}
	return $defaultValue;
}
function redirect_to($location = NULL){
	if ($location !== NULL){
		header($location);
		exit;
	}
}
function check_required_fields($required_fields, $redirect){
	$fields = "";
	foreach ($required_fields as $key => $value) {
		if (array_exists($_POST,$value, NULL) === NULL || empty($_POST[$value])){
			if (empty($fields)){
				$fields = "{$value}";
			}else{
				$fields .= ", {$value}";
			}
		}
	}
	redirect_to("Location: {$redirect}?error=" . urlencode($fields));
}
?>
