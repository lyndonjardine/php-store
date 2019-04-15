
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
<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0	Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>View Items</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	</head>

	<body>
		<H1>View Items</h1>
		<TABLE>
<?php
	include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 

 	$TableName = "items";
	$QueryString = "SELECT * FROM $TableName ORDER BY description ASC";
	$QueryResult = mysqli_query($conn, $QueryString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	while ($Row = mysqli_fetch_assoc($QueryResult)) {
		$item_id = $Row["item_id"];
		$title = $Row["title"];
	
   
		echo "<tr>";
   		echo "  <td>$title </td>";
   		echo "  <td>\n";
   		echo "    <FORM action=\"edit_item.php\" method=\"POST\">\n";
   		echo "      <input type=\"hidden\" name=\"item_id\" value=\"$item_id\" />\n";
   		echo "      <input type=\"submit\" name=\"submit\" value=\"EDIT\" />\n";
   		echo "    </FORM>\n";
   		echo "  </td>\n";
   		echo "  <td>\n";
   		echo "    <FORM action=\"delete_item_confirm.php\" method=\"POST\">\n";
   		echo "      <input type=\"hidden\" name=\"item_id\" value=\"$item_id\" />\n";
   		echo "      <input type=\"submit\" name=\"submit\" value=\"DELETE\" />\n";
   		echo "    </FORM>\n";
   		echo "  </td>\n";
   		echo "</tr>";
   
 	}

	mysqli_close($conn);
?>
		</table>
		<br /><a href="index.php">Return To Main</a>

	</body>

</html>