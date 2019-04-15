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
		echo mysqli_num_rows($result);
		echo "Login failure<br/>";
		//print_r($_SESSION);
		echo "admin: ".$admin_id."<br/>";
		echo "session: ".$sessionID."<br/>";
		header("Location:login.php");
    }

}else{
	//$admin_error1 = 1;
	header("Location:login.php");
}

?>

<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Inventory Management System</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	</head>

	<body>
		<H1>Inventory Management System</H1>
		<a href="add_category.php">Add Category</a><br /><br />
		<a href="view_categories.php">View Categories</a><br /><br />
		<a href="add_item.php">Add Item</a><br /><br />
		<a href="view_items.php">View Items</a><br /><br />
		<a href="view_orders.php">View Orders</a><br /><br />
		<a href="change_password.php">Change Password</a><br /><br />
		<a href="logout.php">Logout</a><br /><br />
	</body>

</html>