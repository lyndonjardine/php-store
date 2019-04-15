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
<?php

	include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 

	$category_id=mysqli_real_escape_string($conn, $_POST['category_id']);

	$TableName = "categories";
	$QueryString = "SELECT * FROM $TableName WHERE category_id='$category_id'";
	$QueryResult = mysqli_query($conn, $QueryString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	while ($Row = mysqli_fetch_assoc($QueryResult)) {
		$image = $Row["picture"];
	}	
	if ($image!="") unlink("../images/$image");
    
    //double check that there are no items before running the query
    $sql = "SELECT * FROM items WHERE category = '".$category_id."' ";

		$itemCheck = mysqli_query($conn, $sql) or trigger_error( mysqli_error(), E_USER_ERROR);
		if ( mysqli_num_rows($itemCheck) == 0 ){
            //if no rows are returned, run the query
            $query = "DELETE FROM $TableName WHERE category_id = '$category_id'";
            $result = mysqli_query($conn, $query) or trigger_error( mysqli_error(), E_USER_ERROR);
        }else{
            echo "Something went wrong...";
        }

	mysqli_close($conn);
	header("Location:./view_categories.php");
    
?>
