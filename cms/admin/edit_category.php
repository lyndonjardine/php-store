
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
		echo "Login failure";
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
		<title>Edit Category</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	</head>

	<body>
	<H1>Edit Category</h1>

<?php

	include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	$category_id=mysqli_real_escape_string($conn, $_POST['category_id']);
	echo $category_id;
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 
	
 	$TableName = "categories";
	$QueryString = "SELECT * FROM $TableName WHERE category_id='$category_id'";
	$QueryResult = mysqli_query($conn, $QueryString) or trigger_error( mysqli_error(), E_USER_ERROR);
	
	while ($Row = mysqli_fetch_assoc($QueryResult)) {
   		$category_id = $Row["category_id"];
   		$category = $Row["category"];

   		echo "    <FORM action=\"check_category_save.php\" method=\"POST\">";
   		echo "      Category: <input type=\"hidden\" name=\"category_id\" value=\"$category_id\" />";
   		echo "      <input type=\"text\" name=\"category\" value=\"$category\" />";
   		echo "      <input type=\"submit\" name=\"submit\" value=\"Save\" />";
   		echo "    </FORM>";
   
 	}   
	 echo "test";
	mysqli_close($conn);
 
?>
  
		</table>
	</body>

</html>