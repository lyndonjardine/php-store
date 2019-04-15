<?php
session_start();
include("dbinfo.php");
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
$admin_error1 = 0;
$admin_error2 = 0;
//code to ensure the user is logged in
if(isset($_SESSION['admin_id'])){
	//echo $_SESSION['admin_id'];
	//echo "<br/>";
	//echo session_id();

	$sessionID = session_id();
	$admin_id = $_SESSION['admin_id'];
	//echo $sessionID."<br/>";
	//echo $admin_id;

	$sql = "SELECT * FROM current_sessions WHERE admin_id = '".$admin_id."' AND sessionID = '".$sessionID."'";
    $result = mysqli_query($conn, $sql);

    //if exactly 1 row is returned, the login is a success
    if(mysqli_num_rows($result) >0){
        //echo "Login success<br/>";
    }else{
		echo "Login failure";
		header("Location:login.php");
    }

}else{
	//$admin_error1 = 1;
	header("Location:login.php");
}

?>
<?php

	include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 
    
  	$category=mysqli_real_escape_string($conn, $_POST['category']);
	
  	$errors = 0;
  
  	if ($category=="") $errors=1;
  
	$TableName = "categories";
	$sql = "SELECT * FROM $TableName WHERE category='$category'";
	$DuplicateCheck = mysqli_query($conn, $sql) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	if ( mysqli_num_rows($DuplicateCheck) > 0 ) {  $errors=2; $is_duplicate="yes"; }	  

	if ($errors>0) {
?>  
<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Check Category Add</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	</head>

	<body>

		<FONT color=red><h2>All Fields Are Required</h2></font>
	   	<FORM action="check_category_add.php" method="POST">
	      	Category: <input type="text" name="category" value="<?php echo "$category"; ?>" />
			<?php if ($category=="") echo "<font color=red> *required</font>"; ?>
			<?php if ($category!="" && $is_duplicate=="yes") echo "<font color=red> *duplicate</font>"; ?>
	      	<br><br>
	      	<input type="submit" name="submit" value="Add" />
	   	</FORM>

	</body>

</html>
<?php
		mysqli_close($conn);

  	} else {

		$SQLString = "INSERT INTO $TableName(category)values('$category')";
		$QueryResult = mysqli_query($conn, $SQLString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);

		mysqli_close($conn);
		header("Location:./view_categories.php");
	}


		


?>
  


