<?php
session_start();
include("dbinfo.php");
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
$admin_error1 = 0;
$wrongPasswordError = 0;
$newPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);

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

$oldPasswordError = 0; //if old password is blank
$newPasswordError = 0; // if new is blank
$confirmPasswordError = 0; // if confirm password is blank
$matchingError = 0; //if the passwords dont match

if(isset($_POST['oldPassword']) && $_POST['oldPassword'] != ""){
    $oldPassword = mysqli_real_escape_string($conn, $_POST['oldPassword']) ;
}else{
    $oldPasswordError = 1;
}

if(isset($_POST['newPassword']) && $_POST['newPassword'] != ""){
    $newPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);
}else{
    $newPasswordError = 1;
}

if(isset($_POST['confirmPassword']) && $_POST['confirmPassword'] != ""){
    $confirmPassword = mysqli_real_escape_string($conn,$_POST['confirmPassword']);
}else{
    $confirmPasswordError = 1;
}

$sql = "SELECT * FROM admin_info WHERE password = '".$oldPassword."' AND admin_id = $admin_id ";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) == 0 ){
    $wrongPasswordError = 1;
}

if($oldPasswordError != 0 || $newPasswordError != 0 || $confirmPasswordError != 0 || $wrongPasswordError != 0){


    ?>

    <html>
        <body>
            <form action='change_password_save.php' method='POST'>
                Old Password: <input type = 'password' name = 'oldPassword' /><?php if($oldPasswordError = 1){echo"<p style = 'color:red;'>Required</p>";} ?><br/><br/>
                New Password: <input type = 'password' name = 'newPassword' /><?php if($newPasswordError = 1){echo"<p style = 'color:red;'>Required</p>";} ?><br/><br/>
                Confirm Password: <input type = 'password' name = 'confirmPassword' /><?php if($confirmPasswordError = 1){echo"<p style = 'color:red;'>Required</p>";} ?><br/><br/>
                <?php if($wrongPasswordError == 1){echo"password incorrect";} ?>
                <input type ='submit' value = 'submit'/>

            </form>
        </body>
    </html>


    <?php
    
    
}else{
    
    //echo "<br/>id: $admin_id";
    //echo "<br/>password: $newPassword";
    
    $sql = "UPDATE admin_info SET password='".$newPassword."' WHERE admin_id = '".$admin_id."'";
    if(mysqli_query($conn, $sql)){
        //echo "success";
        header("Location:index.php");
    }else{
        echo "Something went wrong...";
    }
}

?>