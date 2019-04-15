
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
    if(mysqli_num_rows($result) == 1 ){
        //echo "Login success<br/>";
    }else{
		echo "Login failure";
		header("Location:admin/login.php");
    }

}else{
	//$admin_error1 = 1;
	header("Location:admin/login.php");
}

?>
<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0	Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>View Items</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <link rel="stylesheet" type="text/css" href="style.css" />
	</head>

	<body>
		<H1>View Products</h1>
		<div class="split categorySide">
        <div class="centered">
        <h2>Hello</h2>
        </div>

        </div>
        <div class="split itemSide">
        <div class="centered">
        <h2>Hello</h2>
        </div>

        </div>



		<br /><a href="index.php">Return To Main</a>

	</body>

</html>