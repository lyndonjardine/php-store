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
    if(mysqli_num_rows($result) > 0 ){
        //echo "Login success<br/>";
    }else{

		echo "SESSION DOESNT MATCH";
		header("Location:login.php");
    }

}else{
	//$admin_error1 = 1;
	echo "SESSION NOT SET";
	header("Location:login.php");
}

?>
<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Add A Category</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	</head>

	<body>

		<h2>Enter A New Category</h2>

   		<FORM action="check_category_add.php" method="POST">
     		Category: <input type="text" name="category" value="" /><br /><br />
      		<input type="submit" name="submit" value="Save" />
   		</FORM>

		<a href="index.php">Return To Main</a>   
   
	</body>

</html>