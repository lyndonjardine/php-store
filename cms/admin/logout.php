<?php
session_start();
include("dbinfo.php");
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

//code to ensure the user is logged in
if(isset($_SESSION['admin_id'])){

	$sessionID = session_id();
	$admin_id = $_SESSION['admin_id'];

    echo "<br/>SESSION:".$sessionID;
    echo "<br/>ADMIN:".$admin_id;

	$sql = "SELECT * FROM current_sessions WHERE sessionID = '$sessionID' AND admin_id = $admin_id ";
    $result = mysqli_query($conn, $sql);

    //if exactly 1 row is returned, the login is a success
    if(mysqli_num_rows($result) > 0 ){
        //if user exists
        $sql = "DELETE FROM current_sessions WHERE admin_id = $admin_id AND sessionID = '".$sessionID."'";
        if(mysqli_query($conn, $sql)){
            echo "User Successfully Signed Out";
            session_destroy();
            header("Location:login.php");
        }else{
            echo "Error signing user out";
        }

    }else{
        //if user doesnt exist
        echo "DOESNT EXIST";
        session_destroy();
		header("Location:login.php");
    }

}else{
    //if session is not set
    echo"NOT SET";
	header("Location:login.php");
}



?>