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
    if(mysqli_num_rows($result) >0 ){
        //echo "Login success<br/>";
    }else{
		echo "Login failure";
		header("Location:login.php");
    }

}else{
	//$admin_error1 = 1;
	header("Location:login.php");
}

echo "<h1>Change Password</h1>";
echo "<br/>";
echo "Admin ID: ".$_SESSION['admin_id']."<br/>";


//if password is incorrect
if(isset($_POST['wrongPassword'])){
    echo "<p style='color:red;'>Wrong Password</p>";
}
//if passwords dont match
if(isset($_POST['wrongPassword'])){
    echo "<p style='color:red;'>Passwords don't match</p>";
}


?>
<html>
<body>

<form action='change_password_save.php' method='POST'>
Old Password: <input type = 'password' name = 'oldPassword' /><?php if(isset($_POST['oldPasswordError'])){echo"<p style = 'color:red;'>Required</p>";} ?><br/><br/>
New Password: <input type = 'password' name = 'newPassword' /><?php if(isset($_POST['newPasswordError'])){echo"<p style = 'color:red;'>Required</p>";} ?><br/><br/>
Confirm Password: <input type = 'password' name = 'confirmPassword' /><?php if(isset($_POST['confirmPasswordError'])){echo"<p style = 'color:red;'>Required</p>";} ?><br/><br/>
<input type ='submit' value = 'submit'/>

</form>
</body>
</html>